<?php

namespace GeneaLabs\CashierPaypal\Events;

use Illuminate\Queue\SerializesModels;
use GeneaLabs\CashierPaypal\Order\Order;

class OrderProcessed
{
    use SerializesModels;

    /**
     * The processed order.
     *
     * @var Order
     */
    public $order;

    /**
     * OrderProcessed constructor.
     *
     * @param \GeneaLabs\CashierPaypal\Order\Order $order
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }
}
