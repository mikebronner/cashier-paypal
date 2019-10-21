<?php

namespace GeneaLabs\CashierPaypal\Coupon;

use Illuminate\Support\Arr;
use GeneaLabs\CashierPaypal\Coupon\Contracts\AcceptsCoupons;
use GeneaLabs\CashierPaypal\Coupon\Contracts\CouponHandler;
use GeneaLabs\CashierPaypal\Events\CouponApplied;
use GeneaLabs\CashierPaypal\Exceptions\CouponException;
use GeneaLabs\CashierPaypal\Order\OrderItem;
use GeneaLabs\CashierPaypal\Order\OrderItemCollection;

abstract class BaseCouponHandler implements CouponHandler
{
    /** @var \GeneaLabs\CashierPaypal\Coupon\AppliedCoupon */
    protected $appliedCoupon;

    /** @var array */
    protected $context = [];

    /**
     * @param \GeneaLabs\CashierPaypal\Order\OrderItemCollection $items
     * @return \GeneaLabs\CashierPaypal\Order\OrderItemCollection
     */
    abstract public function getDiscountOrderItems(OrderItemCollection $items);

    /**
     * @param \GeneaLabs\CashierPaypal\Coupon\Coupon $coupon
     * @param \GeneaLabs\CashierPaypal\Coupon\Contracts\AcceptsCoupons $model
     * @return bool
     * @throws \Throwable|CouponException
     */
    public function validate(Coupon $coupon, AcceptsCoupons $model)
    {
        $this->validateOwnersFirstUse($coupon, $model);

        return true;
    }

    /**
     * @param \GeneaLabs\CashierPaypal\Coupon\RedeemedCoupon $redeemedCoupon
     * @param \GeneaLabs\CashierPaypal\Order\OrderItemCollection $items
     * @return \GeneaLabs\CashierPaypal\Order\OrderItemCollection
     */
    public function handle(RedeemedCoupon $redeemedCoupon, OrderItemCollection $items)
    {
        $this->markApplied($redeemedCoupon);

        return $this->apply($redeemedCoupon, $items);
    }

    /**
     * @param \GeneaLabs\CashierPaypal\Coupon\RedeemedCoupon $redeemedCoupon
     * @param \GeneaLabs\CashierPaypal\Order\OrderItemCollection $items
     * @return \GeneaLabs\CashierPaypal\Order\OrderItemCollection
     */
    public function apply(RedeemedCoupon $redeemedCoupon, OrderItemCollection $items)
    {
        return $items->concat(
            $this->getDiscountOrderItems($items)->save()
        );
    }

    /**
     * @param \GeneaLabs\CashierPaypal\Coupon\Coupon $coupon
     * @param \GeneaLabs\CashierPaypal\Coupon\Contracts\AcceptsCoupons $model
     * @throws \Throwable
     * @throws \GeneaLabs\CashierPaypal\Exceptions\CouponException
     */
    public function validateOwnersFirstUse(Coupon $coupon, AcceptsCoupons $model)
    {
        $exists = RedeemedCoupon::whereName($coupon->name())
                ->whereOwnerType($model->ownerType())
                ->whereOwnerId($model->ownerId())
                ->count() > 0;

        throw_if($exists, new CouponException('You have already used this coupon.'));
    }

    /**
     * @param \GeneaLabs\CashierPaypal\Coupon\RedeemedCoupon $redeemedCoupon
     * @return \GeneaLabs\CashierPaypal\Coupon\AppliedCoupon
     */
    public function markApplied(RedeemedCoupon $redeemedCoupon)
    {
        $appliedCoupon = $this->appliedCoupon = AppliedCoupon::create([
            'redeemed_coupon_id' => $redeemedCoupon->id,
            'model_type' => $redeemedCoupon->model_type,
            'model_id' => $redeemedCoupon->model_id,
        ]);

        $redeemedCoupon->markApplied();

        event(new CouponApplied($redeemedCoupon, $appliedCoupon));

        return $appliedCoupon;
    }

    /**
     * Create and return an un-saved OrderItem instance. If a coupon has been applied,
     * the order item will be tied to the coupon.
     *
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model|\GeneaLabs\CashierPaypal\Order\OrderItem
     */
    protected function makeOrderItem(array $data)
    {
        if($this->appliedCoupon) {
            return $this->appliedCoupon->orderItems()->make($data);
        }

        return OrderItem::make($data);
    }

    /**
     * Get an item from the context using "dot" notation.
     *
     * @param $key
     * @param null $default
     * @return mixed
     */
    protected function context($key, $default = null)
    {
        return Arr::get($this->context, $key, $default);
    }

    /**
     * @param array $context
     * @return $this
     */
    public function withContext(array $context)
    {
        $this->context = $context;

        return $this;
    }
}
