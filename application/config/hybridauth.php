<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| HybridAuth settings
| -------------------------------------------------------------------------
| Your HybridAuth config can be specified below.
|
| See: https://github.com/hybridauth/hybridauth/blob/v2/hybridauth/config.php
*/
$config['hybridauth'] = array(
  "providers" => array(
    "OpenID" => array(
      "enabled" => FALSE,
    ),
    "Yahoo" => array(
      "enabled" => FALSE,
      "keys" => array("id" => "", "secret" => ""),
    ),
    "Google" => array(
      "enabled" => TRUE,
      "keys" => array("id" => "908636486414-tjukcch2cr7626l3jcslh9dkov485p59.apps.googleusercontent.com", "secret" => "0pLg4CPu60aj8JFrqUf2hjlh"),
    ),
    "Facebook" => array(
      "enabled" => TRUE,
      "keys" => array("id" => "2107747222854877", "secret" => "2d2e76065909b902ce1a083eb96e53a9"),
      "trustForwarded" => FALSE,
    ),
    "Twitter" => array(
      "enabled" => FALSE,
      "keys" => array("key" => "", "secret" => ""),
      "includeEmail" => FALSE,
    ),
    "LinkedIn" => array(
      "enabled" => FALSE,
      "keys" => array("id" => "", "secret" => ""),
    ),
  ),
  // If you want to enable logging, set 'debug_mode' to true.
  // You can also set it to
  // - "error" To log only error messages. Useful in production
  // - "info" To log info and error messages (ignore debug messages)
  "debug_mode" => FALSE,
  // Path to file writable by the web server. Required if 'debug_mode' is not false
  "debug_file" => APPPATH . 'logs/hybridauth.log',
);
