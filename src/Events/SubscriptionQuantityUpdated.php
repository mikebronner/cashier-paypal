<?php

namespace GeneaLabs\CashierPaypal\Events;

use GeneaLabs\CashierPaypal\Subscription;

class SubscriptionQuantityUpdated
{
    /**
     * @var \GeneaLabs\CashierPaypal\Subscription
     */
    public $subscription;

    /**
     * @var int
     */
    public $oldQuantity;

    public function __construct(Subscription $subscription, int $oldQuantity)
    {
        $this->subscription = $subscription;
        $this->oldQuantity = $oldQuantity;
    }
}
