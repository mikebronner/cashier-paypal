<?php

namespace GeneaLabs\CashierPaypal\ServiceProviders;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use GeneaLabs\CashierPaypal\Order\OrderInvoiceSubscriber;

class Event extends ServiceProvider
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
