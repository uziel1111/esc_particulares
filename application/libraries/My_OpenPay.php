<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('openpay-php/Openpay.php');


class My_OpenPay {
  private static $openpay;
  function __construct() {
    self::$openpay = Openpay::getInstance(OPENPAY_ID, OPENPAY_PRIVATEKEY); // ID y PrivateKey
  }

  public static function get_openpay(){
    return self::$openpay;
  }
}



?>
