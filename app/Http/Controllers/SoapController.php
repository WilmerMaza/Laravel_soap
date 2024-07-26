<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SoapController extends Controller
{

    protected $soapClient;

    public function __construct()
    {
        // Inicializa el cliente SOAP
        $this->soapClient = new \SoapClient('https://www.w3schools.com/xml/tempconvert.asmx?WSDL');
    }

    public function setSoapClient($soapClient)
    {
        $this->soapClient = $soapClient;
    }
    public function handleSoapRequest(Request $request)
    {
        $client = $this->soapClient;

        try {
            $response = $client->FahrenheitToCelsius([
                'Fahrenheit' => 100,
            ]);
            return response()->json($response);
        } catch (\SoapFault $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
