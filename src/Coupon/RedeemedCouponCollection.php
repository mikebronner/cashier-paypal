<?php

namespace GeneaLabs\CashierPaypal\Coupon;

use Illuminate\Database\Eloquent\Collection;
use GeneaLabs\CashierPaypal\Order\OrderItem;
use GeneaLabs\CashierPaypal\Order\OrderItemCollection;

class RedeemedCouponCollection extends Collection
{
    public function applyTo(OrderItem $item)
    {
        return $this->reduce(
            function(OrderItemCollection $carry, RedeemedCoupon $coupon) {
                return $coupon->applyTo($carry);
            },
            $item->toCollection()
        );
    }
}
