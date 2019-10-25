<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inicio extends CI_Controller {

	public function index()
	{
		$data = array();
		carga_pagina_basica($this, "inicio", $data);
	}
}
