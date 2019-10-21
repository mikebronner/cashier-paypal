<?php

namespace GeneaLabs\CashierPaypal\Coupon;

use Illuminate\Config\Repository;
use GeneaLabs\CashierPaypal\Coupon\Contracts\CouponRepository;
use GeneaLabs\CashierPaypal\Exceptions\CouponNotFoundException;

class ConfigCouponRepository implements CouponRepository
{
    /** @var array */
    protected $defaults;

    /** @var array */
    protected $coupons;

    /**
     * ConfigCouponRepository constructor.
     *
     * @param array $defaults
     * @param array $coupons
     */
    public function __construct(array $defaults, array $coupons)
    {
        $this->defaults = $defaults;
        $this->coupons = array_change_key_case($coupons);
    }

    /**
     * @param string $coupon
     * @return Coupon|null
     */
    public function find(string $coupon)
    {
        $needle = strtolower($coupon);
        if(array_key_exists($needle, $this->coupons)) {
            return $this->buildCoupon($needle);
        }

        return null;
    }

    /**
     * @param string $coupon
     * @return Coupon
     *
     * @throws CouponNotFoundException
     */
    public function findOrFail(string $coupon)
    {
        $result = $this->find($coupon);
        throw_if(is_null($result), CouponNotFoundException::class);

        return $result;
    }

    /**
     * @param string $name
     * @return \GeneaLabs\CashierPaypal\Coupon\Coupon
     */
    protected function buildCoupon(string $name)
    {
        $couponConfig = array_merge($this->defaults, $this->coupons[$name]);

        $coupon = new Coupon($name, new $couponConfig['handler'], $couponConfig['context']);

        return $coupon->withTimes($couponConfig['times']);
    }
}
