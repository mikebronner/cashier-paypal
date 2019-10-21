<?php

namespace GeneaLabs\CashierPaypal\Events;

use Illuminate\Queue\SerializesModels;
use GeneaLabs\CashierPaypal\Order\Order;

class OrderCreated
{
    use SerializesModels;

    /**
     * The created order.
     *
     * @var Order
     */
    public $order;

    /**
     * Creates a new OrderCreated event.
     *
     * @param $order
     */
    public function __construct($order)
    {
        $this->order = $order;
    }
}
