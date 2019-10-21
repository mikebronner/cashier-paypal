<?php

namespace GeneaLabs\CashierPaypal\Coupon;

use GeneaLabs\CashierPaypal\Order\OrderItem;
use GeneaLabs\CashierPaypal\Order\OrderItemCollection;
use Money\Money;

class FixedDiscountHandler extends BaseCouponHandler
{
    /**
     * @param \GeneaLabs\CashierPaypal\Order\OrderItemCollection $items
     * @return \GeneaLabs\CashierPaypal\Order\OrderItemCollection
     */
    public function getDiscountOrderItems(OrderItemCollection $items)
    {
        if($items->isEmpty()) {
            return new OrderItemCollection;
        }

        /** @var OrderItem $firstItem */
        $firstItem = $items->first();

        $unitPrice = $this->unitPrice($firstItem->getTotal());

        return $this->makeOrderItem([
            'process_at' => now(),
            'owner_type' => $firstItem->owner_type,
            'owner_id' => $firstItem->owner_id,
            'currency' => $unitPrice->getCurrency()->getCode(),
            'unit_price' => $unitPrice->getAmount(),
            'quantity' => $this->quantity($firstItem),
            'tax_percentage' => $this->taxPercentage($firstItem),
            'description' => $this->context('description'),
        ])->toCollection();
    }

    /**
     * @param \Money\Money $base The amount the discount is applied to.
     * @return \Money\Money
     */
    protected function unitPrice(Money $base)
    {
        $discount = mollie_array_to_money($this->context('discount'));

        if($this->context('allow_surplus', false) && $discount->greaterThan($base)) {
            return $base->negative();
        }

        return $discount->negative();
    }

    /**
     * @param \GeneaLabs\CashierPaypal\Order\OrderItem $firstItem
     * @return int
     */
    protected function quantity(OrderItem $firstItem)
    {
        $adaptive = $this->context('adaptive_quantity', false);

        return $adaptive ? $firstItem->quantity : 1;
    }

    /**
     * @param \GeneaLabs\CashierPaypal\Order\OrderItem $firstItem
     * @return float|int
     */
    protected function taxPercentage(OrderItem $firstItem)
    {
        $noTax = $this->context('no_tax', true);

        return $noTax ? 0 : $firstItem->getTaxPercentage();
    }
}
