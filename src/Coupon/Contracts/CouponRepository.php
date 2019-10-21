<?php

namespace GeneaLabs\CashierPaypal\Coupon\Contracts;

use GeneaLabs\CashierPaypal\Coupon\Coupon;
use GeneaLabs\CashierPaypal\Exceptions\CouponNotFoundException;

interface CouponRepository
{
    /**
     * @param string $coupon
     * @return Coupon|null
     */
    public function find(string $coupon);

    /**
     * @param string $coupon
     * @return Coupon
     *
     * @throws CouponNotFoundException
     */
    public function findOrFail(string $coupon);
}
