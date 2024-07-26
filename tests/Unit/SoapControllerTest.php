<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Mockery;
use SoapClient;
use App\Http\Controllers\SoapController;
use Illuminate\Http\Request;

class SoapControllerTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
 
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function testHandleSoapRequest()
    {
        // Crear un mock para el SoapClient
        $soapClientMock = Mockery::mock(SoapClient::class);
        $soapClientMock->shouldReceive('FahrenheitToCelsius')
            ->once()
            ->with(['Fahrenheit' => 100])
            ->andReturn(['FahrenheitToCelsiusResult' => 37.78]);

        // Inyectar el mock en el controlador
        $controller = new SoapController();
        $request = new Request();
        $controller->setSoapClient($soapClientMock);

        // Llamar al método y obtener la respuesta
        $response = $controller->handleSoapRequest($request);

        // Verificar la respuesta
        $this->assertJson($response->getContent());
        $this->assertEquals(200, $response->status());
        $this->assertEquals(['FahrenheitToCelsiusResult' => 37.78], json_decode($response->getContent(), true));
    }
}
