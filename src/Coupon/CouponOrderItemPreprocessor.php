<?php

namespace GeneaLabs\CashierPaypal\Coupon;

use GeneaLabs\CashierPaypal\Order\BaseOrderItemPreprocessor;
use GeneaLabs\CashierPaypal\Order\OrderItem;
use GeneaLabs\CashierPaypal\Order\OrderItemCollection;

class CouponOrderItemPreprocessor extends BaseOrderItemPreprocessor
{
    /**
     * @param \GeneaLabs\CashierPaypal\Order\OrderItemCollection $items
     * @return \GeneaLabs\CashierPaypal\Order\OrderItemCollection
     */
    public function handle(OrderItemCollection $items)
    {
        $result = new OrderItemCollection;

        $items->each(function (OrderItem $item) use (&$result) {
            if($item->orderableIsSet()) {
                $coupons = $this->getActiveCoupons($item->orderable_type, $item->orderable_id);
                $result = $result->concat($coupons->applyTo($item));
            } else {
                $result->push($item);
            }
        });

        return $result;
    }

    /**
     * @param $modelType
     * @param $modelId
     * @return mixed
     */
    protected function getActiveCoupons($modelType, $modelId)
    {
        return RedeemedCoupon::whereModel($modelType, $modelId)->active()->get();
    }
}
