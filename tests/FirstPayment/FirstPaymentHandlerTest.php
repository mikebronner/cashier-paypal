<?php

namespace GeneaLabs\CashierPaypal\Tests\FirstPayment;

use Illuminate\Support\Facades\Event;
use GeneaLabs\CashierPaypal\Events\MandateUpdated;
use GeneaLabs\CashierPaypal\FirstPayment\Actions\AddBalance;
use GeneaLabs\CashierPaypal\FirstPayment\FirstPaymentHandler;
use GeneaLabs\CashierPaypal\Order\Order;
use GeneaLabs\CashierPaypal\Tests\BaseTestCase;

class FirstPaymentHandlerTest extends BaseTestCase
{
    /** @test */
    public function handlesMolliePayments()
    {
        $this->withPackageMigrations();
        Event::fake();

        $payment = $this->getMandatePayment();

        $owner = factory($payment->metadata->owner->type)->create([
            'id' => $payment->metadata->owner->id,
            'mollie_customer_id' => $this->getMandatedCustomerId(),
        ]);

        $handler = new FirstPaymentHandler($payment);

        $this->assertTrue($owner->is($handler->getOwner()));

        $actions = $handler->getActions();
        $this->assertCount(2, $actions);

        $firstAction = $actions[0];
        $this->assertInstanceOf(AddBalance::class, $firstAction);
        $this->assertMoneyEURCents(500, $firstAction->getTotal());
        $this->assertEquals('Test add balance 1', $firstAction->getDescription());

        $secondAction = $actions[1];
        $this->assertInstanceOf(AddBalance::class, $secondAction);
        $this->assertMoneyEURCents(500, $secondAction->getTotal());
        $this->assertEquals('Test add balance 2', $secondAction->getDescription());

        $this->assertFalse($owner->hasCredit());
        $this->assertNull($owner->mollie_mandate_id);

        $this->assertEquals(0, $owner->orderItems()->count());
        $this->assertEquals(0, $owner->orders()->count());

        $order = $handler->execute();

        $owner = $owner->fresh();

        $this->assertTrue($owner->hasCredit());
        $credit = $owner->credit('EUR');
        $this->assertMoneyEURCents(1000,$credit->money());

        $this->assertEquals(2, $owner->orderItems()->count());
        $this->assertEquals(1, $owner->orders()->count());

        $this->assertInstanceOf(Order::Class, $order);
        $this->assertTrue($order->isProcessed());

        $this->assertEquals(2, $order->items()->count());

        $this->assertNotNull($owner->mollie_mandate_id);
        $this->assertEquals($payment->mandateId, $owner->mollie_mandate_id);

        Event::assertDispatched(MandateUpdated::class, function(MandateUpdated $e) use ($owner) {
            return $e->owner->is($owner);
        });
    }
}
