<?php

namespace GeneaLabs\CashierPaypal\Database\Factories;

use Carbon\Carbon;
use Faker\Generator as Faker;
use GeneaLabs\CashierPaypal\Subscription;
use GeneaLabs\CashierPaypal\Tests\Fixtures\User;

$factory->define(Subscription::class, function (Faker $faker) {
    return [
        'name' => 'dummy name',
        'plan' => 'monthly-10-1',
        'owner_id' => 1,
        'owner_type' => User::class,
        'cycle_started_at' => now(),
        'cycle_ends_at' => function (array $subscription) {
            return Carbon::parse($subscription['cycle_started_at'])->addMonth();
        },
        'tax_percentage' => 0,
    ];
});
