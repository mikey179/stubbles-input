<?php
/**
 * This file is part of stubbles.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package  stubbles\input
 */
namespace stubbles\input\broker;
use stubbles\lang;
require_once __DIR__ . '/BrokerClass.php';
/**
 * Tests for stubbles\input\broker\RequestBroker.
 *
 * @group  broker
 * @group  broker_core
 */
class RequestBrokerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * instance to test
     *
     * @type  RequestBroker
     */
    private $requestBroker;
    /**
     * mocked param broker map
     *
     * @type  \PHPUnit_Framework_MockObject_MockObject
     */
    private $mockParamBrokerMap;
    /**
     * mocked request instance
     *
     * @type  \PHPUnit_Framework_MockObject_MockObject
     */
    private $mockRequest;

    /**
     * set up test environment
     */
    public function setUp()
    {
        $this->mockParamBrokerMap = $this->getMockBuilder('stubbles\input\broker\ParamBrokerMap')
                                         ->disableOriginalConstructor()
                                         ->getMock();
        $this->requestBroker = new RequestBroker(new RequestBrokerMethods(), $this->mockParamBrokerMap);
        $this->mockRequest   = $this->getMock('stubbles\input\Request');
    }

    /**
     * @test
     */
    public function annotationsPresentOnClass()
    {
        $this->assertTrue(lang\reflect($this->requestBroker)->hasAnnotation('Singleton')
        );
    }

    /**
     * @test
     */
    public function annotationsPresentOnConstructor()
    {
        $this->assertTrue(lang\reflectConstructor($this->requestBroker)->hasAnnotation('Inject'));
    }

    /**
     * @test
     * @expectedException  stubbles\lang\exception\IllegalArgumentException
     */
    public function procureNonObjectThrowsIllegalArgumentException()
    {
        $this->requestBroker->procure($this->mockRequest, 313);
    }

    /**
     * creats mock param broker
     *
     * @param   string  $returnValue
     * @return  \PHPUnit_Framework_MockObject_MockObject
     */
    private function getMockParamBroker($returnValue)
    {
        $mockParamBroker = $this->getMock('stubbles\input\broker\param\ParamBroker');
        $mockParamBroker->expects($this->once())
                        ->method('procure')
                        ->will($this->returnValue($returnValue));
        return $mockParamBroker;
    }

    /**
     * @test
     */
    public function procuresOnlyThoseInGivenGroup()
    {
        $this->mockParamBrokerMap->expects($this->once())
                                 ->method('getBroker')
                                 ->with($this->equalTo('String'))
                                 ->will($this->returnValue($this->getMockParamBroker('just some string value')));
        $object = new BrokerClass();
        $this->requestBroker->procure($this->mockRequest, $object, 'main');
        $this->assertEquals('just some string value', $object->getBar());
        $this->assertNull($object->getBaz());
    }

    /**
     * @test
     */
    public function procuresAllIfNoGroupGiven()
    {
        $this->mockParamBrokerMap->expects($this->at(0))
                                 ->method('getBroker')
                                 ->with($this->equalTo('Bool'))
                                 ->will($this->returnValue($this->getMockParamBroker('just some string value')));
        $this->mockParamBrokerMap->expects($this->at(1))
                                 ->method('getBroker')
                                 ->with($this->equalTo('String'))
                                 ->will($this->returnValue($this->getMockParamBroker('just some string value')));
        $this->mockParamBrokerMap->expects($this->at(2))
                                 ->method('getBroker')
                                 ->with($this->equalTo('Mock'))
                                 ->will($this->returnValue($this->getMockParamBroker('just another string value')));
        $object = new BrokerClass();
        $this->requestBroker->procure($this->mockRequest, $object);
        $this->assertEquals('just some string value', $object->getBar());
        $this->assertEquals('just another string value', $object->getBaz());
    }

    /**
     * @test
     */
    public function getMethodsReturnsListOfAllMethodsWithRequestAnnotation()
    {
        $methods = $this->requestBroker->getMethods(new BrokerClass());
        $this->assertCount(3, $methods);
        foreach ($methods as $method) {
            $this->assertInstanceOf('stubbles\lang\\reflect\ReflectionMethod',
                                    $method
            );
        }
    }

    /**
     * @test
     */
    public function getMethodsReturnsListOfAllMethodsWithRequestAnnotationInGivenGroup()
    {
        $methods = $this->requestBroker->getMethods(new BrokerClass(), 'main');
        $this->assertCount(1, $methods);
        foreach ($methods as $method) {
            $this->assertInstanceOf('stubbles\lang\\reflect\ReflectionMethod',
                                    $method
            );
        }
    }

    /**
     * @test
     */
    public function getAnnotationsReturnsListOfAllRequestAnnotation()
    {
        $annotations = $this->requestBroker->getAnnotations(new BrokerClass());
        $this->assertCount(3, $annotations);
        foreach ($annotations as $annotation) {
            $this->assertInstanceOf('stubbles\lang\\reflect\annotation\Annotation',
                                    $annotation
            );
        }
    }

    /**
     * @test
     */
    public function getAnnotationsReturnsListOfAllRequestAnnotationInGivenGroup()
    {
        $annotations = $this->requestBroker->getAnnotations(new BrokerClass(), 'main');
        $this->assertCount(1, $annotations);
        foreach ($annotations as $annotation) {
            $this->assertInstanceOf('stubbles\lang\\reflect\annotation\Annotation',
                                    $annotation
            );
        }
    }
}
