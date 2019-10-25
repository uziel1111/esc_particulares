<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('PHPExcel/Classes/PHPExcel.php');
class My_PHPExcel extends PHPExcel {
  function __construct() {
    parent::__construct();
  }
}
?>
