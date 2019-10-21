<?php

namespace GeneaLabs\CashierPaypal\Events;

use Illuminate\Queue\SerializesModels;

class OrderInvoiceAvailable
{
    use SerializesModels;

    /**
     * The created order.
     *
     * @var \GeneaLabs\CashierPaypal\Order\Order
     */
    public $order;

    /**
     * Creates a new OrderInvoiceAvailable event.
     *
     * @param $order
     */
    public function __construct($order)
    {
        $this->order = $order;
    }
}
