<?php

namespace GeneaLabs\CashierPaypal\Console\Commands;

use Illuminate\Console\Command;
use GeneaLabs\CashierPaypal\Cashier;
use Illuminate\Support\Collection;

class CashierRun extends Command
{
    protected $signature = 'cashier:run';
    protected $description = 'Process due order items';

    public function handle() : Collection
    {
        $orders = Cashier::run();
        $this->info("Created {$orders->count()} orders.");

        return $orders;
    }
}
