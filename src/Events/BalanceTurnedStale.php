<?php

namespace GeneaLabs\CashierPaypal\Events;

use GeneaLabs\CashierPaypal\Credit\Credit;

class BalanceTurnedStale
{
    /**
     * @var \GeneaLabs\CashierPaypal\Credit\Credit
     */
    public $credit;

    public function __construct(Credit $credit)
    {
        $this->credit = $credit;
    }
}
