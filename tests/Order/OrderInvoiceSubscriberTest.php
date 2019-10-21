<?php

namespace GeneaLabs\CashierPaypal\Tests\Order;

use Illuminate\Support\Facades\Event;
use GeneaLabs\CashierPaypal\Events\FirstPaymentPaid;
use GeneaLabs\CashierPaypal\Events\OrderInvoiceAvailable;
use GeneaLabs\CashierPaypal\Events\OrderPaymentPaid;
use GeneaLabs\CashierPaypal\Order\Order;
use GeneaLabs\CashierPaypal\Order\OrderInvoiceSubscriber;
use GeneaLabs\CashierPaypal\Tests\BaseTestCase;
use Mollie\Api\Resources\Payment;

class OrderInvoiceSubscriberTest extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->subscriber = new OrderInvoiceSubscriber;
    }

    /** @test */
    public function itHandlesTheFirstPaymentPaidEvent()
    {
        $this->assertItHandlesEvent(
            new FirstPaymentPaid($this->mock(Payment::class), $this->order()),
            'handleFirstPaymentPaid'
        );
    }

    /** @test */
    public function itHandlesTheOrderPaymentPaidEvent()
    {
        $this->assertItHandlesEvent(
            new OrderPaymentPaid($this->order()),
            'handleOrderPaymentPaid'
        );
    }

    private function assertItHandlesEvent($event, $methodName)
    {
        Event::fake(OrderInvoiceAvailable::class);

        (new OrderInvoiceSubscriber)->$methodName($event);

        Event::assertDispatched(OrderInvoiceAvailable::class, function($e) use ($event) {
            return $e->order === $event->order;
        });
    }

    private function order() {
        return factory(Order::class)->make();
    }
}
