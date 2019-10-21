<?php

namespace GeneaLabs\CashierPaypal\Tests;

use Illuminate\Support\Facades\Event;
use GeneaLabs\CashierPaypal\Events\OrderInvoiceAvailable;
use GeneaLabs\CashierPaypal\Events\OrderPaymentPaid;
use GeneaLabs\CashierPaypal\Order\Order;

class EventServiceProviderTest extends BaseTestCase
{
    /** @test */
    public function itIsWiredUpAndFiring()
    {
        Event::fake(OrderInvoiceAvailable::class);

        $event = new OrderPaymentPaid(factory(Order::class)->make());
        Event::dispatch($event);

        Event::assertDispatched(OrderInvoiceAvailable::class, function($e) use ($event) {
            return $e->order === $event->order;
        });
    }
}
