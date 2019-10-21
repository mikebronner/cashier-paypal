<?php

namespace GeneaLabs\CashierPaypal\Order\Contracts;

use GeneaLabs\CashierPaypal\Order\OrderItem;

interface PreprocessesOrderItems
{
    /**
     * Called right before processing the order item into an order.
     *
     * @param OrderItem $item
     * @return \GeneaLabs\CashierPaypal\Order\OrderItemCollection
     */
    public static function preprocessOrderItem(OrderItem $item);
}
