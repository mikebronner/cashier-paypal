<?php

namespace GeneaLabs\CashierPaypal\Coupon;

use Illuminate\Database\Eloquent\Model;
use GeneaLabs\CashierPaypal\Order\Contracts\InteractsWithOrderItems;
use GeneaLabs\CashierPaypal\Order\OrderItem;

/**
 * @method static create(array $array)
 */
class AppliedCoupon extends Model implements InteractsWithOrderItems
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Get the model relation the coupon was applied to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function model()
    {
        return $this->morphTo();
    }

    /**
     * The OrderItem relation for this applied coupon.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function orderItems()
    {
        return $this->morphMany(OrderItem::class, 'orderable');
    }

    /**
     * Called right before processing the order item into an order.
     *
     * @param OrderItem $item
     * @return \GeneaLabs\CashierPaypal\Order\OrderItemCollection
     */
    public static function preprocessOrderItem(OrderItem $item)
    {
        return $item->toCollection();
    }

    /**
     * Called after processing the order item into an order.
     *
     * @param OrderItem $item
     * @return OrderItem The order item that's being processed
     */
    public static function processOrderItem(OrderItem $item)
    {
        return $item;
    }

    /**
     * Handle a failed payment.
     *
     * @param OrderItem $item
     * @return void
     */
    public static function handlePaymentFailed(OrderItem $item)
    {
        $item->orderable->delete();
    }

    /**
     * Handle a paid payment.
     *
     * @param OrderItem $item
     * @return void
     */
    public static function handlePaymentPaid(OrderItem $item)
    {
        // All is taken care of
    }
}
