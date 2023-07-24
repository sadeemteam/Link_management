<?php


return [
   'mode'    => 'live', // Can only be 'sandbox' Or 'live'. If empty or invalid, 'live' will be used.
   'sandbox' => [
      'client_id'     => '',
      'client_secret' => '',
      'app_id'        => 'APP-80W284485P519543T',
   ],
   'live' => [
      'client_id'     => '',
      'client_secret' => '',
      'app_id'        => '',
   ],
   'payment_action' => 'Sale', // Can only be 'Sale', 'Authorization' or 'Order'
   'currency'       => 'USD',
   'notify_url'     => '', // Change this accordingly for your application.
   'locale'         => 'en_US', // force gateway language  i.e. it_IT, es_ES, en_US ... (for express checkout only)
   'validate_ssl'   => true, // Validate SSL when creating api client.
];