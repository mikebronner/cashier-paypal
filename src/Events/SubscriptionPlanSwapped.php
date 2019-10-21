<?php

namespace GeneaLabs\CashierPaypal\Events;

use GeneaLabs\CashierPaypal\Subscription;

class SubscriptionPlanSwapped
{
    /**
     * @var \GeneaLabs\CashierPaypal\Subscription
     */
    public $subscription;

    public function __construct(Subscription $subscription)
    {
        $this->subscription = $subscription;
    }
}
