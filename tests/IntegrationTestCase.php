<?php

namespace GeneaLabs\CashierPaypal\Tests;

use GeneaLabs\CashierPaypal\ServiceProviders\Cashier;
use Orchestra\Testbench\TestCase;

class IntegrationTestCase extends TestCase
{
    protected function getEnvironmentSetUp($app)
    {
        //
    }

    protected function getPackageProviders($app)
    {
        return [
            Cashier::class,
        ];
    }
}
