<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inicio extends CI_Controller {
	public function index()
	{
		$data = array();
		carga_pagina_basica($this, $data, "inicio");
	}

	public function mensaje(){
		// echo "llego";
		$response = array("result" => "llego_y_va");
		envia_datos_json($this, $response, 200);
	}
}
