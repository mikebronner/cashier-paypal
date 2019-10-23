<?php

namespace GeneaLabs\CashierPaypal\Observers;

use GeneaLabs\CashierPaypal\Plan;
use GeneaLabs\CashierPaypal\Service\PaypalPlan;

class PlanObserver
{
    public function created(Plan $plan) : void
    {
        //
    }

    public function creating(Plan $plan) : void
    {
        $paypalPlan = (new PaypalPlan)->create($plan);
        $plan->updateFromPaypal($paypalPlan);
    }

    public function deleted(Plan $plan) : void
    {
        //
    }

    public function deleting(Plan $plan) : void
    {
        //
    }

    public function updated(Plan $plan) : void
    {
        //
    }

    public function updating(Plan $plan) : void
    {
        //
    }

    public function retrieved(Plan $plan) : void
    {
        //
    }

    public function saved(Plan $plan) : void
    {
        //
    }

    public function saving(Plan $plan) : void
    {
        //
    }

    public function restored(Plan $plan) : void
    {
        //
    }

    public function restoring(Plan $plan) : void
    {
        //
    }
}
