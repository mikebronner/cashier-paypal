<?php

namespace GeneaLabs\CashierPaypal\Order;

class PersistOrderItemsPreprocessor extends BaseOrderItemPreprocessor
{
    /**
     * @param \GeneaLabs\CashierPaypal\Order\OrderItemCollection $items
     * @return \GeneaLabs\CashierPaypal\Order\OrderItemCollection
     */
    public function handle(OrderItemCollection $items)
    {
        return $items->save();
    }
}
