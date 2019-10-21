<?php

declare(strict_types=1);

namespace GeneaLabs\CashierPaypal\Plan\Contracts;

interface PlanRepository
{
    /**
     * @param string $name
     * @return null|\GeneaLabs\CashierPaypal\Plan\Contracts\Plan
     */
    public static function find(string $name);

    /**
     * @param string $name
     * @return \GeneaLabs\CashierPaypal\Plan\Contracts\Plan
     */
    public static function findOrFail(string $name);
}
