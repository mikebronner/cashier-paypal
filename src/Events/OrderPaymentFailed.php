<?php

namespace GeneaLabs\CashierPaypal\Events;

use Illuminate\Queue\SerializesModels;

class OrderPaymentFailed
{
    use SerializesModels;

    /**
     * The failed order.
     *
     * @var \GeneaLabs\CashierPaypal\Order\Order
     */
    public $order;

    /**
     * Creates a new OrderPaymentFailed event.
     *
     * @param $order
     */
    public function __construct($order)
    {
        $this->order = $order;
    }
}
