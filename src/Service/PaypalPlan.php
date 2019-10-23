<?php

namespace GeneaLabs\CashierPaypal\Service;

use Exception;
use GeneaLabs\CashierPaypal\Plan;
use PayPal\Api\ChargeModel;
use PayPal\Api\Currency;
use PayPal\Api\MerchantPreferences;
use PayPal\Api\PaymentDefinition;
use PayPal\Api\Plan as PaypalApiPlan;

class PaypalPlan extends PaypalBase
{
    public function create(Plan $plan) : PaypalApiPlan
    {
        $paypalPlan = new PaypalApiPlan();
        $paypalPlan
            ->setName($plan->name)
            ->setDescription($plan->description)
            ->setType($plan->type);
        $paymentDefinitions = [];

        // Set billing plan definitions
        $paymentDefinition = new PaymentDefinition();
        $paymentDefinition
            ->setName('Payment')
            ->setType('REGULAR')
            ->setFrequency($plan->frequency)
            ->setFrequencyInterval($plan->interval)
            ->setCycles($plan->cycles)
            ->setAmount(new Currency([
                'value' => $plan->amount / 100,
                'currency' => strtoupper($plan->currency),
            ]));

        // Set charge models
        $chargeModel = new ChargeModel();
        $chargeModel
            ->setType('SHIPPING')
            ->setAmount(new Currency([
                'value' => $plan->shipping / 100,
                'currency' => strtoupper($plan->currency),
            ]));
        $paymentDefinition
            ->setChargeModels(array($chargeModel));
        $paymentDefinitions[] = $paymentDefinition;

        if ($plan->has_trial) {
            // Set billing plan definitions
            $trialPaymentDefinition = new PaymentDefinition();
            $trialPaymentDefinition
                ->setName('Payment')
                ->setType('TRIAL')
                ->setFrequency($plan->trial_frequency)
                ->setFrequencyInterval($plan->trial_interval)
                ->setCycles($plan->trial_cycles)
                ->setAmount(new Currency([
                    'value' => $plan->trial_price / 100,
                    'currency' => strtoupper($plan->currency),
                ]));

            // Set charge models
            $chargeModel = new ChargeModel();
            $chargeModel
                ->setType('SHIPPING')
                ->setAmount(new Currency([
                    'value' => $plan->trial_shipping / 100,
                    'currency' => strtoupper($plan->currency),
                ]));
            $trialPaymentDefinition
                ->setChargeModels(array($chargeModel));
            $paymentDefinitions[] = $trialPaymentDefinition;
        }

        // Set merchant preferences
        $merchantPreferences = new MerchantPreferences();
        $merchantPreferences
            ->setReturnUrl($plan->return_url)
            ->setCancelUrl($plan->cancel_url)
            ->setAutoBillAmount($plan->auto_bill_amount ? "yes" : "no")
            ->setInitialFailAmountAction($plan->initial_fail_amount_action)
            ->setMaxFailAttempts($plan->max_failed_attempts)
            ->setSetupFee(new Currency([
                'value' => $plan->setup_fee / 100,
                'currency' => strtoupper($plan->currency),
            ]));

        $paypalPlan
            ->setPaymentDefinitions($paymentDefinitions)
            ->setMerchantPreferences($merchantPreferences);

        try {
            $createdPlan = $paypalPlan->create($this->apiContext);
        } catch (Exception $exception) {
            dd($exception);
        }

        return $createdPlan;
    }

    // public function create(Plan $plan) : PaypalApiPlan
    // {

    // }
}
