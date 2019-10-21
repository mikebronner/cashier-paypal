<?php

namespace GeneaLabs\CashierPaypal\Order;

use Illuminate\Support\Facades\Event;
use GeneaLabs\CashierPaypal\Events\FirstPaymentPaid;
use GeneaLabs\CashierPaypal\Events\OrderInvoiceAvailable;
use GeneaLabs\CashierPaypal\Events\OrderPaymentPaid;

class OrderInvoiceSubscriber
{
    /**
     * @param FirstPaymentPaid $event
     */
    public function handleFirstPaymentPaid($event)
    {
        Event::dispatch(new OrderInvoiceAvailable($event->order));
    }

    /**
     * @param OrderPaymentPaid $event
     */
    public function handleOrderPaymentPaid($event)
    {
        Event::dispatch(new OrderInvoiceAvailable($event->order));
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  \Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events)
    {
        $events->listen(
            OrderPaymentPaid::class,
            self::class . '@handleOrderPaymentPaid'
        );

        $events->listen(
            FirstPaymentPaid::class,
            self::class . '@handleFirstPaymentPaid'
        );
    }
}
