<?php

return [
    /**
     * Mode
     * Accepted value: test for the test mode or live for the live mode
     */
    'mode' => env('THAWANI_MODE', 'test'),

    /**
     * Success URL
     * Accepted value: URL
     */
    'success_url' => env('THAWANI_SUCCESS_URL'),

    /**
     * Cancel URL
     * Accepted value: URL
     */
    'cancel_url' => env('THAWANI_CANCEL_URL'),
];