<?php

namespace GeneaLabs\CashierPaypal\Tests\Order;

use GeneaLabs\CashierPaypal\Order\Invoice;
use GeneaLabs\CashierPaypal\Order\Order;
use GeneaLabs\CashierPaypal\Tests\BaseTestCase;
use GeneaLabs\CashierPaypal\Tests\Fixtures\User;

class OrderCollectionTest extends BaseTestCase
{
    /** @test */
    public function canGetInvoices()
    {
        $this->withPackageMigrations();
        $user = factory(User::class)->create();
        $orders = $user->orders()->saveMany(factory(Order::class, 2)->make());

        $invoices = $orders->invoices();

        $this->assertCount(2, $invoices);
        $this->assertInstanceOf(Invoice::class, $invoices->first());
    }
}
