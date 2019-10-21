<?php

namespace GeneaLabs\CashierPaypal;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use GeneaLabs\CashierPaypal\Order\OrderInvoiceSubscriber;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The subscriber classes to register.
     *
     * @var array
     */
    protected $subscribe = [
        OrderInvoiceSubscriber::class,
    ];
}
