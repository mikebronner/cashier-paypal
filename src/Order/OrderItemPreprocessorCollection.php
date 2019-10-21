<?php

namespace GeneaLabs\CashierPaypal\Order;

use Illuminate\Support\Collection;
use Illuminate\Support\Collection as BaseCollection;
use \GeneaLabs\CashierPaypal\Order\BaseOrderItemPreprocessor as Preprocessor;

/**
 * A collection of instantiable OrderItemPreprocessor class strings.
 *
 * @package GeneaLabs\CashierPaypal\Order
 */
class OrderItemPreprocessorCollection extends Collection
{
    /**
     * Initialize the preprocessors from a string array.
     *
     * @param string[] $value
     * @return \GeneaLabs\CashierPaypal\Order\OrderItemPreprocessorCollection
     */
    public static function fromArray($value)
    {
        $preprocessors = collect($value)->map(function ($class) {
            return app()->make($class);
        });

        return static::fromBaseCollection($preprocessors);
    }

    /**
     * @param \GeneaLabs\CashierPaypal\Order\OrderItem $item
     * @return \GeneaLabs\CashierPaypal\Order\OrderItemCollection
     */
    public function handle(OrderItem $item)
    {
        $items = $this->reduce(function($carry, Preprocessor $preprocessor) {
            return $preprocessor->handle($carry);
        }, $item->toCollection());

        return new OrderItemCollection($items);
    }

    /**
     * Create an OrderItemCollection from a basic Collection.
     *
     * @param \Illuminate\Support\Collection $collection
     * @return \GeneaLabs\CashierPaypal\Order\OrderItemPreprocessorCollection
     */
    public static function fromBaseCollection(BaseCollection $collection)
    {
        return new static($collection->all());
    }
}
