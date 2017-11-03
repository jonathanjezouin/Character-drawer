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
    public function statusProvider()
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
    
//     /**
//      * @dataProvider statusProvider
//      * @expectedException \TypeError
//      */
//     public function testSetStatus($status, $reason)
//     {
//         $response = $this->getResponse()->setStatus($status, $reason);
//     }
}
