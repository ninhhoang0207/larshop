<?php
  return [
    'nexmo_sms_api_settings' => [
      'API_KEY' => env('NEXMO_API_KEY', ''),
      'API_SECRET' => env('NEXMO_API_SECRET', ''),
      'SEND_SMS_FROM' => env('NEXMO_SMS_FROM', 'IYNGARAN'),
    ],
    'twilio_sms_api_settings' => [
      'SID' => env('TWILIO_SID', ''),
      'TOKEN' => env('TWILIO_TOKEN', ''),
      'SEND_SMS_FROM' => env('TWILIO_SMS_FROM', '+12012926824'),
    ],
    'message_bird_sms_api_settings' => [
      'API_KEY' => env('MESSAGE_BIRD_API_KEY', ''),
      'SEND_SMS_FROM' => env('MESSAGE_BIRD_SMS_FROM', '+12012926824'),
    ],
    'dialog_sms_api_settings' => [
      'API_KEY' => env('DIALOG_SMS_API_KEY', ''),
      'ENDPOINT' => env('DIALOG_SMS_ENDPOINT', ''),
      'SEND_SMS_FROM' => env('DIALOG_SMS_FROM', 'IYNGARAN'),
    ],
  ];
