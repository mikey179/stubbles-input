<?php
/**
 * This file is part of stubbles.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package  stubbles\input
 */
namespace stubbles\input\validator;
/**
 * Base class for composite validator tests.
 *
 * @deprecated  since 3.0.0, will be removed with 4.0.0
 */
abstract class CompositeValidatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * instance to test
     *
     * @type  CompositeValidator
     */
    protected $compositeValidator;

    /**
     * set up test environment
     */
    public function setUp()
    {
        $this->compositeValidator = $this->getTestInstance();
    }

    /**
     * creates instance to test
     *
     * @return  CompositeValidator
     */
    protected abstract function getTestInstance();

    /**
     * @test
     * @expectedException  stubbles\lang\exception\IllegalStateException
     */
    public function validateThrowsRuntimeExceptionIfNoValidatorsAddedBefore()
    {
        $this->compositeValidator->validate('foo');
    }

    /**
     * creates mocked validator instance
     *
     * @param   bool  $validateResult
     * @return  \PHPUnit_Framework_MockObject_MockObject
     */
    protected function createMockValidatorWhichValidatesTo($validateResult)
    {
        $mockValidator = $this->getMock('stubbles\input\Validator');
        $mockValidator->expects($this->once())
                      ->method('validate')
                      ->will($this->returnValue($validateResult));
        return $mockValidator;
    }

    /**
     * creates mocked validator instance
     *
     * @return  \PHPUnit_Framework_MockObject_MockObject
     */
    protected function createMockValidatorWhichIsNeverCalled()
    {
        $mockValidator = $this->getMock('stubbles\input\Validator');
        $mockValidator->expects($this->never())
                      ->method('validate');
        return $mockValidator;
    }
}
