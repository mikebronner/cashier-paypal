<?php

namespace GeneaLabs\CashierPaypal\Tests\IntegrationTests\Services;

use GeneaLabs\CashierPaypal\Plan;
use GeneaLabs\CashierPaypal\Service\PaypalPlan;
use GeneaLabs\CashierPaypal\Tests\IntegrationTestCase;

class PaypalPlanTest extends IntegrationTestCase
{
    /** @group test */
    public function testCreateMethod()
    {
        $plan = (new Plan)
            ->fill([
                "name" => "Test Plan",
                "description" => "plan used during testing",
                "type" => "fixed",
                "status" => "active",

                "interval" => 1,
                "frequency" => "year",
                "cycles" => 1,
                "amount" => 12345,
                "currency" => "usd",
                "tax" => 7,
                "shipping" => 450,
                "has_trial" => false,

                "setup_fee" => 3000,
                "cancel_url" => "https://google.com",
                "return_url" => "https://enstest.com",
                "notify_url" => "https://example.com",
                "max_fail_attempts" => 0,
                "auto_bill_amount" => false,
                "initial_fail_amount_action" => "continue",
            ]);
// dd($plan);
        $createdPlan = (new PaypalPlan)
            ->create($plan);

        dd($createdPlan);
    }
}
