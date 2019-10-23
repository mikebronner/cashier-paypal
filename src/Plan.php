<?php

namespace GeneaLabs\CashierPaypal;

use GeneaLabs\CashierPaypal\Service\PaypalPlan;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $fillable = [
        "amount",
        "auto_bill_amount",
        "cancel_url",
        "currency",
        "cycles",
        "description",
        "frequency",
        "has_trial",
        "initial_fail_amount_action",
        "interval",
        "max_fail_attempts",
        "name",
        "notify_url",
        "return_url",
        "setup_fee",
        "shipping",
        "status",
        "tax",
        "trial_amount",
        "trial_currency",
        "trial_cycles",
        "trial_frequency",
        "trial_interval",
        "trial_shipping",
        "trial_tax",
        "type",
    ];

    public function updateFromPaypal(PaypalPlan $paypalPlan) : self
    {
        $this->fill([
            "amount",
            "auto_bill_amount",
            "cancel_url",
            "currency",
            "cycles",
            "description",
            "frequency",
            "has_trial",
            "initial_fail_amount_action",
            "interval",
            "max_fail_attempts",
            "name",
            "notify_url",
            "return_url",
            "setup_fee",
            "shipping",
            "status",
            "tax",
            "trial_amount",
            "trial_currency",
            "trial_cycles",
            "trial_frequency",
            "trial_interval",
            "trial_shipping",
            "trial_tax",
            "type",
            ]);
        $this->save();

        return $this;
    }
}
