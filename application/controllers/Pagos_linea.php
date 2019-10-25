<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pagos_linea extends CI_Controller {

	function __construct() {
	parent::__construct();
	$this->load->library('My_OpenPay');
}// __construct()

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$data['openpay_id'] = OPENPAY_ID;
		$data['openpay_publickey'] = OPENPAY_PUBLICKEY;
		$this->load->view('pagos_linea/index', $data);
	}

	public function openpay(){
		$openpay = My_OpenPay::get_openpay();
		// var_dump($openpay); die();
		// var_dump($this->input->post()); die();
		/*
		$openpay = Openpay::getInstance('mzdtln0bmtms6o3kck8f',
		  'sk_e568c42a6c384b7ab02cd47d2e407cab');
			*/

		$customer = array(
		     'name' => "MIGUEL", #$_POST["name"],
		     'last_name' => "HERNANDEZ", #$_POST["last_name"],
		     'phone_number' => "2227607019", #$_POST["phone_number"],
		     'email' => "miguellhdez@gmail.com" #$_POST["email"],
			 );

		$chargeData = array(
		    'method' => 'card',
		    'source_id' => $_POST["token_id"],
		    'amount' => (float)10, #(float)$_POST["amount"],
		    'description' => "demo pago", #$_POST["description"],
		    'use_card_points' => $_POST["use_card_points"], // Opcional, si estamos usando puntos
		    'device_session_id' => $_POST["deviceIdHiddenFieldName"],
		    'customer' => $customer
		    );

		try {
			$charge = $openpay->charges->create($chargeData);
			var_dump($charge); die();
		} catch (OpenpayApiTransactionError $e) {
			/*
			error_log('ERROR on the transaction: ' . $e->getMessage() .
			      ' [error code: ' . $e->getErrorCode() .
			      ', error category: ' . $e->getCategory() .
			      ', HTTP code: '. $e->getHttpCode() .
			      ', request ID: ' . $e->getRequestId() . ']', 0);
						*/
				echo 'ERROR on the transaction: ' . $e->getMessage();
				echo "<br>";
				echo 'ERROR on the transaction: error code' . $e->getErrorCode();
				echo "<br>";
				echo 'ERROR on the transaction: error category' . $e->getCategory();
				echo "<br>";
				echo 'ERROR on the transaction: HTTP code' . $e->getHttpCode();
				echo "<br>";
				echo 'ERROR on the transaction: request ID' . $e->getRequestId();
		} catch (OpenpayApiRequestError $e) {
			// error_log('ERROR on the request: ' . $e->getMessage(), 0);
			echo 'ERROR on the request: ' . $e->getMessage();
			echo "<br>";
			echo 'ERROR on the request: ' . $e->getErrorCode();
			echo "<br>";
			echo 'ERROR on the request: ' . $e->getHttpCode();
			echo "<br>";
			echo 'ERROR on the request: ' . $e->getCategory();
		} catch (OpenpayApiConnectionError $e) {
			// error_log('ERROR while connecting to the API: ' . $e->getMessage(), 0);
			echo 'ERROR while connecting to the API: ' . $e->getMessage();
			echo "<br>";
			echo 'ERROR while connecting to the API: ' . $e->getErrorCode();
			echo "<br>";
			echo 'ERROR while connecting to the API: ' . $e->getHttpCode();
			echo "<br>";
			echo 'ERROR while connecting to the API: ' . $e->getCategory();
		} catch (OpenpayApiAuthError $e) {
			// error_log('ERROR on the authentication: ' . $e->getMessage(), 0);
			echo 'ERROR on the authentication: ' . $e->getMessage();
			echo "<br>";
			echo 'ERROR on the authentication: ' . $e->getErrorCode();
			echo "<br>";
			echo 'ERROR on the authentication: ' . $e->getHttpCode();
			echo "<br>";
			echo 'ERROR on the authentication: ' . $e->getCategory();
		} catch (OpenpayApiError $e) {
			// error_log('ERROR on the API: ' . $e->getMessage(), 0);
			echo 'ERROR on the API: ' . $e->getMessage();
			echo "<br>";
			echo 'ERROR on the API: ' . $e->getErrorCode();
			echo "<br>";
			echo 'ERROR on the API: ' . $e->getHttpCode();
			echo "<br>";
			echo 'ERROR on the API: ' . $e->getCategory();
		} catch (Exception $e) {
			// error_log('Error on the script: ' . $e->getMessage(), 0);
			echo 'Error on the script: ' . $e->getMessage();
			echo "<br>";
			echo 'Error on the script: ' . $e->getErrorCode();
			echo "<br>";
			echo 'Error on the script: ' . $e->getHttpCode();
			echo "<br>";
			echo 'Error on the script: ' . $e->getCategory();
		}


	}

	public function openpay_auto(){
		// $openpay = Openpay::getInstance('mzdtln0bmtms6o3kck8f', 'sk_e568c42a6c384b7ab02cd47d2e407cab');
		$openpay = My_OpenPay::get_openpay();

		$customer = array(
		     'name' => 'Mario',
		     'last_name' => 'Benedetti Farrugia',
		     'phone_number' => '1111111111',
		     'email' => 'mario_benedetti@miempresa.mx');

		$chargeRequest = array(
		    "method" => "card",
		    'amount' => 111,
		    'description' => 'Cargo desde terminal virtual de 111',
		    'customer' => $customer,
		    'send_email' => false,
		    'confirm' => false,
		    'redirect_url' => 'http://www.openpay.mx/index.html')
		;

		$charge = $openpay->charges->create($chargeRequest);
		// var_dump($charge);
		header('Location:'.$charge->payment_method->url);
		// var_dump($charge);
	}

}
