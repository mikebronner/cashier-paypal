<?php

namespace GeneaLabs\CashierPaypal\Service;

use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;

class PaypalBase
{
    protected $apiContext;

    public function __construct()
    {
        $useSandbox = config("services.paypal.enable_sandbox", false);
        $clientId = $useSandbox
            ? config("services.paypal.sandbox_client_id")
            : config("services.paypal.client_id");
        $clientSecret = $useSandbox
            ? config("services.paypal.sandbox_client_secret")
            : config("services.paypal.client_secret");
        $this->apiContext = new ApiContext(
            new OAuthTokenCredential($clientId, $clientSecret)
        );
        // dd($useSandbox);
        $this->apiContext->setConfig([
            'mode' => $useSandbox ? "sandbox" : "live",
            'log.LogEnabled' => true,
            'log.FileName' => '../PayPal.log',
            'log.LogLevel' => 'DEBUG', // PLEASE USE FINE LEVEL FOR LOGGING IN LIVE ENVIRONMENTS
            'cache.enabled' => false,
        ]);
    }
}
