<?php

namespace GeneaLabs\CashierPaypal\Coupon\Contracts;

use GeneaLabs\CashierPaypal\Coupon\Coupon;
use GeneaLabs\CashierPaypal\Coupon\RedeemedCoupon;
use GeneaLabs\CashierPaypal\Exceptions\CouponException;
use GeneaLabs\CashierPaypal\Order\OrderItemCollection;

interface CouponHandler
{
    /**
     * @param array $context
     * @return \GeneaLabs\CashierPaypal\Coupon\Contracts\CouponHandler
     */
    public function withContext(array $context);

    /**
     * @param \GeneaLabs\CashierPaypal\Coupon\Coupon $coupon
     * @param \GeneaLabs\CashierPaypal\Coupon\Contracts\AcceptsCoupons $model
     * @return bool
     * @throws \Throwable|CouponException
     */
    public function validate(Coupon $coupon, AcceptsCoupons $model);

    /**
     * Apply the coupon to the OrderItemCollection
     *
     * @param \GeneaLabs\CashierPaypal\Coupon\RedeemedCoupon $redeemedCoupon
     * @param \GeneaLabs\CashierPaypal\Order\OrderItemCollection $items
     * @return \GeneaLabs\CashierPaypal\Order\OrderItemCollection
     */
    public function handle(RedeemedCoupon $redeemedCoupon, OrderItemCollection $items);

    /**
     * @param \GeneaLabs\CashierPaypal\Order\OrderItemCollection $items
     * @return \GeneaLabs\CashierPaypal\Order\OrderItemCollection
     */
    public function getDiscountOrderItems(OrderItemCollection $items);
}
