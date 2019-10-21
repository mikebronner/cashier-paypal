<?php

namespace GeneaLabs\CashierPaypal\Tests\Order;

use Illuminate\Support\Arr;
use GeneaLabs\CashierPaypal\Order\BaseOrderItemPreprocessor;
use GeneaLabs\CashierPaypal\Order\OrderItem;
use GeneaLabs\CashierPaypal\Order\OrderItemCollection;
use GeneaLabs\CashierPaypal\Tests\BaseTestCase;

class FakeOrderItemPreprocessor extends BaseOrderItemPreprocessor {

    protected $items = [];
    protected $result;

    /**
     * @param \GeneaLabs\CashierPaypal\Order\OrderItemCollection $items
     * @return \GeneaLabs\CashierPaypal\Order\OrderItemCollection
     */
    public function handle(OrderItemCollection $items)
    {
        $this->items[] = $items;

        return $this->result ?: $items;
    }

    public function withResult(OrderItemCollection $mockResult)
    {
        $this->result = $mockResult;

        return $this;
    }

    public function assertOrderItemHandled(OrderItem $item)
    {
        BaseTestCase::assertContains($item, Arr::flatten($this->items), "OrderItem `{$item->description}` was not handled");
    }
}
