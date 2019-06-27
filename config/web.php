<?php

return [
	'SMS_ID' => env('SMS_ID'),
    
    'SMS_KEY' => env('SMS_KEY'),

    'SMS_SIGN' => env('SMS_SIGN','e融通'),

    'SMS_TEMPLATE_VERIFY' => env('SMS_TEMPLATE_VERIFY'),

    'longtimecache' => env('LONGTIME_CACHE', 10),

    'shrottimecache' => env('SHORTTIME_CACHE', 2),

];
