<?php

namespace GeneaLabs\CashierPaypal\Events;

use Mollie\Api\Resources\Payment;

class FirstPaymentFailed
{
    /**
     * @var \Mollie\Api\Resources\Payment
     */
    public $payment;

    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
    }
}
