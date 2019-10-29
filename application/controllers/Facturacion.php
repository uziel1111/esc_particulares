<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Facturacion extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        // $this->load->library('Utilerias');
    } // __construct()

	public function index()
    {
        $data = array();

        // "Create" the document.
        $xml = new DOMDocument( "1.0", "utf-8" );

        // Create some elements.
        $xml_comprobante = $xml->createElement( "cfdi:Comprobante" );
        $xml_relacionados = $xml->createElement( "cfdi:CfdiRelacionados");

        // Set the attributes.
        $xml_relacionados->setAttribute( "TipoRelacion", "01" );

        // Create another element, just to show you can add any (realistic to computer) number of sublevels.
        $xml_relacionado = $xml->createElement( "cfdi:CfdiRelacionado");
        $xml_relacionado->setAttribute( "UUID", "A39DA66B-52CA-49E3-879B-5C05185B0EF7" );

        // Append the whole bunch.
        $xml_relacionados->appendChild( $xml_relacionado );
        $xml_comprobante->appendChild( $xml_relacionados );

        // Repeat the above with some different values..
        $xml_emisor = $xml->createElement( "cfdi:Emisor" );

        $xml_emisor->setAttribute( "Rfc", "LAHH850905BZ4" );
        $xml_emisor->setAttribute( "Nombre", "Luis Sanchez" );
        $xml_emisor->setAttribute( "RegimenFiscal", "2" );

        $xml_comprobante->appendChild( $xml_emisor );

        $xml_receptor = $xml->createElement( "cfdi:Receptor" );

        $xml_receptor->setAttribute( "Rfc", "HEPR930322977" );
        $xml_receptor->setAttribute( "Nombre", "RAFAEL ALEJANDRO HERNÁNDEZ PALACIOS" );
        $xml_receptor->setAttribute( "UsoCFDI", "G01" );

        $xml_comprobante->appendChild( $xml_receptor );

        $xml_conceptos = $xml->createElement( "cfdi:Conceptos");

        $xml_concepto = $xml->createElement( "cfdi:Concepto");
        $xml_concepto->setAttribute( "ClaveProdServ", "01010101" );
        $xml_concepto->setAttribute( "ClaveUnidad", "F52" );
        $xml_concepto->setAttribute( "NoIdentificacion", "00001" );
        $xml_concepto->setAttribute( "Cantidad", "1.5" );
        $xml_concepto->setAttribute( "Unidad", "TONELADA" );
        $xml_concepto->setAttribute( "Descripcion", "ACERO" );
        $xml_concepto->setAttribute( "ValorUnitario", "1500000" );
        $xml_concepto->setAttribute( "Importe", "2250000" );

        $xml_impuestos = $xml->createElement( "cfdi:Impuestos");
        $xml_traslados = $xml->createElement( "cfdi:Traslados");
        $xml_traslado = $xml->createElement( "cfdi:Traslado");
        $xml_traslado->setAttribute( "Base", "2250000");
        $xml_traslado->setAttribute( "Impuesto", "003");
        $xml_traslado->setAttribute( "TipoFactor", "Tasa" );
        $xml_traslado->setAttribute( "TasaOCuota", "0.160000");
        $xml_traslado->setAttribute( "Importe", "360000");
        $xml_traslados->appendChild( $xml_traslado);
        $xml_retenciones = $xml->createElement( "cfdi:Retenciones");
        $xml_retencion = $xml->createElement( "cfdi:Retencion");
        $xml_retenciones->appendChild( $xml_retencion);
        $xml_impuestos->appendChild( $xml_traslados );
        $xml_impuestos->appendChild( $xml_retenciones );
        $xmlcuentapredial = $xml->createElement( "cfdi:CuentaPredial");

        $xml_concepto->appendChild( $xml_impuestos );
        $xml_concepto->appendChild( $xmlcuentapredial );

        $xml_conceptos->appendChild( $xml_concepto );

        $xml_comprobante->appendChild( $xml_conceptos );

        $xml_impuestos = $xml->createElement( "cfdi:Impuestos");
        $xml_retenciones = $xml->createElement( "cfdi:Retenciones");
        $xml_retencion = $xml->createElement( "cfdi:Retencion");
        $xml_retenciones->appendChild( $xml_retencion);
        $xml_impuestos->appendChild( $xml_retenciones );
        $xml_traslados = $xml->createElement( "cfdi:Traslados");
        $xml_traslado = $xml->createElement( "cfdi:Traslado");
        $xml_traslado->setAttribute( "Base", "2250000");
        $xml_traslado->setAttribute( "Impuesto", "003");
        $xml_traslado->setAttribute( "TipoFactor", "Tasa" );
        $xml_traslado->setAttribute( "TasaOCuota", "0.160000");
        $xml_traslado->setAttribute( "Importe", "360000");
        $xml_traslados->appendChild( $xml_traslado);
        $xml_impuestos->appendChild( $xml_traslados );

        $xml_comprobante->appendChild( $xml_impuestos );

        $xml->appendChild( $xml_comprobante );
        $name = date("Y-m-d_H-i-s");
        $ruta = 'XMLFacturas/'.$name.'.xml';
        // Parse the XML.
        print $xml->save($ruta);

        $cadenaOriginal = $this->cadena_original($ruta);
        echo $cadenaOriginal; die();


        carga_pagina_basica($this, "inicio", $data);
    }

    function cadena_original($ruta_archivo){
        //ruta al archivo XML del CFDI
        $xmlFile = 'XMLFacturas/pruebaF.xml';
     
        // Ruta al archivo XSLT
        $xslFile = "XMLFacturas/cadenaoriginal_3_3/cadenaoriginal_3_3.xslt"; 
     
        // Crear un objeto DOMDocument para cargar el CFDI
        $xml = new DOMDocument("1.0","UTF-8"); 
        // Cargar el CFDI
        $xml->load($xmlFile);
     
        // Crear un objeto DOMDocument para cargar el archivo de transformación XSLT
        $xsl = new DOMDocument();
        $xsl->load($xslFile);
     
        // Crear el procesador XSLT que nos generará la cadena original con base en las reglas descritas en el XSLT
        $proc = new XSLTProcessor;
        // Cargar las reglas de transformación desde el archivo XSLT.
        @$proc->importStyleSheet($xsl);
        // Generar la cadena original y asignarla a una variable
        $cadenaOriginal = $proc->transformToXML($xml);
     
        echo $cadenaOriginal;
    }
}
