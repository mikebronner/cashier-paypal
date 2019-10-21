<?php

namespace GeneaLabs\CashierPaypal\Order;

trait ConvertsToMoney
{
    /**
     * @param int $value
     * @return \Money\Money
     */
    protected function toMoney($value = 0)
    {
        return money(round($value), $this->getCurrency());
    }
}
