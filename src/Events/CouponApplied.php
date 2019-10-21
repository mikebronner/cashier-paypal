<?php

namespace GeneaLabs\CashierPaypal\Events;

use GeneaLabs\CashierPaypal\Coupon\AppliedCoupon;
use GeneaLabs\CashierPaypal\Coupon\RedeemedCoupon;

class CouponApplied
{
    /**
     * @var \GeneaLabs\CashierPaypal\Coupon\RedeemedCoupon
     */
    public $redeemedCoupon;

    /**
     * @var \GeneaLabs\CashierPaypal\Coupon\AppliedCoupon
     */
    public $appliedCoupon;

    public function __construct(RedeemedCoupon $redeemedCoupon, AppliedCoupon $appliedCoupon)
    {
        $this->redeemedCoupon = $redeemedCoupon;
        $this->appliedCoupon = $appliedCoupon;
    }
}
