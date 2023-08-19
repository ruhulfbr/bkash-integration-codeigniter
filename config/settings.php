<?php

defined('BASEPATH') OR exit('No direct script access allowed');

//BKASH
$config['BKASH_CREDENTIALS'] = [
   "createURL"  => "https://checkout.pay.bka.sh/v1.2.0-beta/checkout/payment/create", 
   "executeURL" => "https://checkout.pay.bka.sh/v1.2.0-beta/checkout/payment/execute/", 
   "tokenURL"   => "https://checkout.pay.bka.sh/v1.2.0-beta/checkout/token/grant", 
   "script"     => "https://scripts.pay.bka.sh/versions/1.2.0-beta/checkout/bKash-checkout.js", 
   "app_key"    => "your app key", 
   "proxy"      => "", 
   "app_secret" => "your app secret", 
   "username"   => "your user name", 
   "password"   => "your password"
]; 