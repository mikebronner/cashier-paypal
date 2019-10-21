<?php

namespace GeneaLabs\CashierPaypal\Events;

use Illuminate\Queue\SerializesModels;
use GeneaLabs\CashierPaypal\Order\Order;

class FirstPaymentPaid
{
    use SerializesModels;

    /**
     * @var \Mollie\Api\Resources\Payment
     */
    public $payment;

    /**
     * The order created for this first payment.
     *
     * @var Order
     */
    public $order;

    public function __construct($payment, $order)
    {
        $this->payment = $payment;
        $this->order = $order;
    }
}
