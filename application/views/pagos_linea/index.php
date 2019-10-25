<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Demo OpenPay</title>

	<script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

	<script type="text/javascript" src="https://openpay.s3.amazonaws.com/openpay.v1.min.js"></script>
	<script type='text/javascript'
	  src="https://openpay.s3.amazonaws.com/openpay-data.v1.min.js"></script>



	<script type="text/javascript">
		// Configuración
		OpenPay.setId('<?= $openpay_id ?>');
		OpenPay.setApiKey('<?= $openpay_publickey ?>');
		// Habilitar modo sandbox
		OpenPay.setSandboxMode(true);
	</script>

	<script type="text/javascript">
	$(function() {
		// Configuración
		OpenPay.setId('<?= $openpay_id ?>');
		OpenPay.setApiKey('<?= $openpay_publickey ?>');
		// Habilitar modo sandbox
		OpenPay.setSandboxMode(true);
		//Se genera el id de dispositivo
		var deviceSessionId = OpenPay.deviceData.setup("payment-form", "deviceIdHiddenFieldName");
		console.info("deviceSessionId: "+deviceSessionId);


		// Atrapamos el evento de clic del botón "Pagar" para que en lugar de que haga el submit del formulario realice la función "tokenize" de la tarjeta:
		$("#pay-button").click(function(e){
			e.preventDefault();
			alert("click pay-button");
			$("#pay-button").prop( "disabled", true);
			OpenPay.token.extractFormAndCreate('payment-form', success_callbak, error_callbak);
		});

		var success_callbak = function(response) {
		              var token_id = response.data.id;
		              $('#token_id').val(token_id);
		              $('#payment-form').submit();
		};

		var error_callbak = function(response) {
		     var desc = response.data.description != undefined ?
		        response.data.description : response.message;
		     alert("ERROR [" + response.status + "] " + desc);
		     $("#pay-button").prop("disabled", false);
		};
});




	</script>

</head>
<body>

<div class="container">
	<h1>EJEMPLO OPENPAY -Creación de tokens con formulario- </h1>

	<p>
		<label>ID:</label>
		 <?= $openpay_id ?>
	</p>
	<p>
		<label>PUBLIC KEY:</label>
		<?= $openpay_publickey ?>
	</p>

	<hr>
	<div class="card">
	  <div class="card-header">
	    Tarjeta de crédito o débito
	  </div>
	  <div class="card-body">
			<?= form_open('Welcome/openpay', array("id" => "payment-form")) ?>

			<form action="#" method="POST" id="payment-form">
			    <input type="hidden" name="token_id" id="token_id">
			    <input type="hidden" name="use_card_points" id="use_card_points" value="false">

			    <!-- <div class="pymnt-itm card active"> -->
						<div class="row">
							<div class="col-6 mt-4">
								<div class="credit"><h4>Tarjetas de crédito</h4></div>
								<img src="<?= base_url('assets/img/cards1.png') ?>" alt="" class="img-fluid">
							</div><!-- .col-6 -->
							<div class="col-6 mt-4">
								<div class="debit"><h4>Tarjetas de débito</h4></div>
								<img src="<?= base_url('assets/img/cards2.png') ?>" alt="" class="img-fluid">
							</div><!-- .col-6 -->
						</div><!-- .row -->
						<div class="row">
							<div class="col-6 mt-4">
								<label>Nombre del titular</label>
								<input type="text" placeholder="Como aparece en la tarjeta" autocomplete="off" data-openpay-card="holder_name" class="form-control">
							</div><!-- .col-6 -->
							<div class="col-6 mt-4">
								<label>Número de tarjeta</label>
								<input type="text" autocomplete="off" data-openpay-card="card_number" class="form-control">
							</div><!-- .col-6 -->
						</div><!-- .row -->

						<div class="row">
							<div class="col-6 mt-4">
								<label>Fecha de expiración</label>
								<div class="row">
									<div class="col-6">
										<input type="text" placeholder="Mes" data-openpay-card="expiration_month" class="form-control">
									</div><!-- .col-6 -->
									<div class="col-6">
											<input type="text" placeholder="Año" data-openpay-card="expiration_year" class="form-control">
									</div><!-- .col-6 -->
								</div><!-- .row -->
							</div><!-- .col-6 -->
							<div class="col-6 mt-4">

								<label>Código de seguridad</label>

									<div class="row">
										<div class="col-6">
											<input type="text" placeholder="3 dígitos" autocomplete="off" data-openpay-card="cvv2" class="form-control">
										</div><!-- .col-6 -->
										<div class="col-6">
											<img src="<?= base_url('assets/img/cvv.png') ?>" alt="" class="img-fluid">
										</div><!-- .col-6 -->
									</div><!-- .row -->

							</div><!-- .col-6 -->
						</div><!-- .row -->

						<div class="row">
							<div class="col-6 mt-5">
							</div><!-- .col-6 -->
							<div class="col-6 mt-5">
								<div class="row">
									<div class="col-6 mt-5">
										<small>Transacciones realizadas vía:</small><br>
										<img src="<?= base_url('assets/img/openpay.png') ?>" alt="" class="img-fluid">
									</div><!-- .col-6 -->
									<div class="col-6 mt-5">
										<img src="<?= base_url('assets/img/security.png') ?>" alt="" class="img-fluid">
											<small>Tus pagos se realizan de forma segura con encriptación de 256 bits</small><br>

									</div><!-- .col-6 -->
								</div><!-- .row -->

							</div><!-- .col-6 -->
						</div><!-- .row -->

						<div class="row">
							<div class="col-9 mt-5">
							</div><!-- .col-8 -->
							<div class="col-3 mt-5">
								<button id="pay-button" type="button" class="btn btn-success btn-block">PAGAR</button>
							</div><!-- .col-8 -->
						</div><!-- .row -->

			  <?= form_close() ?>

	  </div><!-- card-body -->
	</div><!-- card -->




</div><!-- .container -->



</body>
</html>
