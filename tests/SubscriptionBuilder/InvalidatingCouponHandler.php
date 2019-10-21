<?php

namespace GeneaLabs\CashierPaypal\Tests\SubscriptionBuilder;

use GeneaLabs\CashierPaypal\Coupon\BaseCouponHandler;
use GeneaLabs\CashierPaypal\Coupon\Contracts\AcceptsCoupons;
use GeneaLabs\CashierPaypal\Coupon\Coupon;
use GeneaLabs\CashierPaypal\Coupon\RedeemedCoupon;
use GeneaLabs\CashierPaypal\Exceptions\CouponException;
use GeneaLabs\CashierPaypal\Order\OrderItemCollection;

class InvalidatingCouponHandler extends BaseCouponHandler
{
    public function validate(Coupon $coupon, AcceptsCoupons $model)
    {
        throw new CouponException('This exception should be thrown');
    }

    public function getDiscountOrderItems(OrderItemCollection $items)
    {
        return $items;
    }
}
