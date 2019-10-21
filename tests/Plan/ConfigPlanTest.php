<?php

namespace GeneaLabs\CashierPaypal\Tests\Plan;

use GeneaLabs\CashierPaypal\Plan\ConfigPlanRepository;
use GeneaLabs\CashierPaypal\Plan\Plan;
use GeneaLabs\CashierPaypal\Tests\BaseTestCase;
use GeneaLabs\CashierPaypal\Tests\Order\FakeOrderItemPreprocessor;

class ConfigPlanTest extends BaseTestCase
{
    /**
     * @var Plan
     */
    protected $plan;

    /**
     * @var array
     */
    protected $configArray;

    protected function setUp(): void
    {
        parent::setUp();

        $this->configArray = [
            'amount' => [
                'value' => '10.00',
                'currency' => 'EUR',
            ],
            'interval' => '1 month',
            'description' => 'Test subscription (monthly)',
            'first_payment_method' => 'directdebit',
            'first_payment_amount' => [
                'value' => '0.05',
                'currency' => 'EUR',
            ],
            'first_payment_description' => 'Test mandate payment',
            'order_item_preprocessors' => [
                FakeOrderItemPreprocessor::class,
            ],
        ];

        $this->plan = ConfigPlanRepository::populatePlan('Test', $this->configArray);
    }

    /** @test */
    public function createFromConfigArrays()
    {
        $this->assertMoneyEURCents(1000, $this->plan->amount());
        $this->assertEquals('1 month', $this->plan->interval());
        $this->assertEquals('directdebit', $this->plan->firstPaymentMethod());
        $this->assertEquals('Test subscription (monthly)', $this->plan->description());
        $this->assertMoneyEURCents(5, $this->plan->firstPaymentAmount());
        $this->assertEquals('Test mandate payment', $this->plan->firstPaymentDescription());
        $this->assertCount(1, $this->plan->orderItemPreprocessors());
    }

    /** @test */
    public function getFirstPaymentAmount()
    {
        $amount = $this->plan->firstPaymentAmount();
        $this->assertMoneyEURCents(5, $amount);
    }

    /** @test */
    public function getFirstPaymentDescription()
    {
        $this->assertEquals('Test mandate payment', $this->plan->firstPaymentDescription());
    }

    /** @test */
    public function getPreprocessors()
    {
        $this->assertNotEmpty($this->plan->orderItemPreprocessors());
        $this->assertInstanceOf(
            FakeOrderItemPreprocessor::class,
            $this->plan->orderItemPreprocessors()[0]
        );
    }
}
