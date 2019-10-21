<?php

namespace GeneaLabs\CashierPaypal\Tests\Coupon;

use GeneaLabs\CashierPaypal\Coupon\AppliedCoupon;
use GeneaLabs\CashierPaypal\Coupon\Contracts\CouponRepository;
use GeneaLabs\CashierPaypal\Coupon\CouponOrderItemPreprocessor;
use GeneaLabs\CashierPaypal\Coupon\RedeemedCoupon;
use GeneaLabs\CashierPaypal\Order\OrderItem;
use GeneaLabs\CashierPaypal\Order\OrderItemCollection;
use GeneaLabs\CashierPaypal\Subscription;
use GeneaLabs\CashierPaypal\Tests\BaseTestCase;

class CouponOrderItemPreprocessorTest extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->withPackageMigrations();
    }

    /** @test */
    public function appliesCoupon()
    {
        $this->withMockedCouponRepository();

        /** @var Subscription $subscription */
        $subscription = factory(Subscription::class)->create();
        $item = factory(OrderItem::class)->make();
        $subscription->orderItems()->save($item);

        /** @var \GeneaLabs\CashierPaypal\Coupon\Coupon $coupon */
        $coupon = app()->make(CouponRepository::class)->findOrFail('test-coupon');
        $redeemedCoupon = $coupon->redeemFor($subscription);
        $preprocessor = new CouponOrderItemPreprocessor();
        $this->assertEquals(0, AppliedCoupon::count());
        $this->assertEquals(1, $redeemedCoupon->times_left);

        $result = $preprocessor->handle($item->toCollection());

        $this->assertEquals(1, AppliedCoupon::count());
        $this->assertInstanceOf(OrderItemCollection::class, $result);
        $this->assertNotEquals($item->toCollection(), $result);
        $this->assertEquals(0, $redeemedCoupon->refresh()->times_left);
    }

    /** @test */
    public function passesThroughWhenNoRedeemedCoupon()
    {
        $preprocessor = new CouponOrderItemPreprocessor();
        $items = factory(OrderItem::class, 1)->make();
        $this->assertInstanceOf(OrderItemCollection::class, $items);
        $this->assertEquals(0, RedeemedCoupon::count());

        $result = $preprocessor->handle($items);

        $this->assertInstanceOf(OrderItemCollection::class, $result);
        $this->assertEquals($items, $result);
    }
}
