<?php
namespace ASCII\Test\Http;

use ASCII\Http\Response;

class ResponseTest extends \PHPUnit\Framework\TestCase
{

    public function getResponse()
    {
        return $this->getMockBuilder(Response::class)->getMock();
    }
    
    // fournit des entrees pour tester une methode
    public function statusProviderException()
    {
        return [
            [null, null],
            [[], []],
            ["Hello", "World"]
        ];
    }
    
    public function constructProvider()
    {
        return [
            ["status", 200],
            ["reason", "OK"],
            ["header", []],
            ["body", ""]
        ];
    }
    
    /**
     * @covers \ASCII\Http\Response::__construct
     * @dataProvider constructProvider
     */
    public function testConstruct($propName, $expectedResult)
    {
        $class = new \ReflectionClass(Response::class);
        // on cherche a acceder a l'attribut prive "status" d'une response
        $prop = $class->getProperty($propName);
        // on change sa visibilite pour y acceder
        $prop->setAccessible(true);
        // on declenche le constructeur de la class (seul newInstanceArgs le fait...)
        $response = $class->newInstanceArgs([]);
        
        // on verifie que l'attribut a bien la valeur attendue
        $this->assertTrue(
            $expectedResult === $prop->getValue($response)
            );
    }
    
    /**
     * @covers \ASCII\Http\Response::__construct
     * @covers \ASCII\Http\Response::getStatus
     * @covers \ASCII\Http\Response::setStatus
     * @dataProvider statusProviderException
     */
    public function testSetStatus($status, $reason)
    {
        $response = (new \ReflectionClass(Response::class))->newInstanceArgs([]);
        $response->setStatus(1, "toto");
        
        // on verifie que l'attribut a bien la valeur attendue
        $this->assertTrue(
            "HTTP/1.1 1 toto" === $response->getStatus()
            );
    }
    
    /**
     * @covers \ASCII\Http\Response::__construct
     * @covers \ASCII\Http\Response::getStatus
     * @covers \ASCII\Http\Response::setStatus
     * @dataProvider statusProviderException
     * @expectedException \TypeError
     */
    public function testSetStatusException($status, $reason)
    {
        $response = $this->getResponse()->setStatus($status, $reason);
    }
    
    
}
