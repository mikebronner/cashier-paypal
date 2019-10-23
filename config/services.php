<?php

return [
    "paypal" => [
        "enable_sandbox" => (bool) env("PAYPAL_SANDBOX_ENABLED", false),
        "client_id" => env("PAYPAL_CLIENT_ID"),
        "client_secret" => env("PAYPAL_CLIENT_SECRET"),
        "sandbox_client_id" => env("PAYPAL_SANDBOX_CLIENT_ID"),
        "sandbox_client_secret" => env("PAYPAL_SANDBOX_CLIENT_SECRET"),
    ],
];
