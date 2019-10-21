<?php

namespace GeneaLabs\CashierPaypal\FirstPayment\Actions;

use Illuminate\Database\Eloquent\Model;
use GeneaLabs\CashierPaypal\Coupon\Coupon;
use GeneaLabs\CashierPaypal\Order\OrderItemCollection;

class ApplySubscriptionCouponToPayment extends BaseNullAction
{
    /**
     * @var \GeneaLabs\CashierPaypal\Coupon\Coupon
     */
    protected $coupon;

    /**
     * The coupon's (discount) OrderItems
     * @var \GeneaLabs\CashierPaypal\Order\OrderItemCollection
     */
    protected $orderItems;

    /**
     * ApplySubscriptionCouponToPayment constructor.
     *
     * @param \Illuminate\Database\Eloquent\Model $owner
     * @param \GeneaLabs\CashierPaypal\Coupon\Coupon $coupon
     * @param \GeneaLabs\CashierPaypal\Order\OrderItemCollection $orderItems
     */
    public function __construct(Model $owner, Coupon $coupon, OrderItemCollection $orderItems)
    {
        $this->owner = $owner;
        $this->coupon = $coupon;
        $this->orderItems = $this->coupon->handler()->getDiscountOrderItems($orderItems);
    }

    /**
     * @return \Money\Money
     */
    public function getSubtotal()
    {
        return $this->toMoney($this->orderItems->sum('subtotal'));
    }

    /**
     * @return \Money\Money
     */
    public function getTax()
    {
        return $this->toMoney($this->orderItems->sum('tax'));
    }

    /**
     * @param int $value
     * @return \Money\Money
     */
    protected function toMoney($value = 0)
    {
        return money($value, $this->getCurrency());
    }
}
