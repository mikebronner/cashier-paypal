<?php

namespace GeneaLabs\CashierPaypal\Order;

abstract class BaseOrderItemPreprocessor
{
    /**
     * @param \GeneaLabs\CashierPaypal\Order\OrderItemCollection $items
     * @return \GeneaLabs\CashierPaypal\Order\OrderItemCollection
     */
    abstract public function handle(OrderItemCollection $items);
}
