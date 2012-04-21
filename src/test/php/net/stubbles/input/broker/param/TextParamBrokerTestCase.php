<?php
/**
 * This file is part of stubbles.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package  net\stubbles\input
 */
namespace net\stubbles\input\broker\param;
use net\stubbles\input\filter\ValueFilter;
require_once __DIR__ . '/MultipleSourceParamBrokerTestCase.php';
/**
 * Tests for net\stubbles\input\broker\param\TextParamBroker.
 *
 * @group  broker
 * @group  broker_param
 */
class TextParamBrokerTestCase extends MultipleSourceParamBrokerTestCase
{
    /**
     * set up test environment
     */
    public function setUp()
    {
        $this->paramBroker = new TextParamBroker();
    }

    /**
     * returns name of filter annotation
     *
     * @return  string
     */
    protected function getFilterAnnotationName()
    {
        return 'TextFilter';
    }

    /**
     * returns expected filtered value
     *
     * @return  string
     */
    protected function getExpectedFilteredValue()
    {
        return 'Do you expect me to talk?';
    }

    /**
     * @test
     */
    public function usesDefaultFromAnnotationIfParamNotSet()
    {
        $this->assertEquals('No Mr Bond, I expect you to die!',
                            $this->paramBroker->handle($this->mockRequest(ValueFilter::mockForValue(null)),
                                                       $this->createFilterAnnotation(array('default' => 'No Mr Bond, I expect you to die!'))
                          )
        );
    }

    /**
     * @test
     */
    public function returnsNullIfParamNotSetAndRequired()
    {
        $this->assertNull($this->paramBroker->handle($this->mockRequest(ValueFilter::mockForValue(null)),
                                                     $this->createFilterAnnotation(array('required' => true))
                          )
        );
    }

    /**
     * @test
     */
    public function returnsNullIfShorterThanMinLength()
    {
        $this->assertNull($this->paramBroker->handle($this->mockRequest(ValueFilter::mockForValue('Do <u>you</u> expect me to <b>talk</b>?')),
                                                     $this->createFilterAnnotation(array('minLength' => 40))
                          )
        );
    }

    /**
     * @test
     */
    public function returnsNullIfLongerThanMaxLength()
    {
        $this->assertNull($this->paramBroker->handle($this->mockRequest(ValueFilter::mockForValue('Do <u>you</u> expect me to <b>talk</b>?')),
                                                     $this->createFilterAnnotation(array('maxLength' => 10))
                          )
        );
    }

    /**
     * @test
     */
    public function returnsValueIfInRange()
    {
        $this->assertEquals('Do you expect me to talk?',
                            $this->paramBroker->handle($this->mockRequest(ValueFilter::mockForValue('Do <u>you</u> expect me to <b>talk</b>?')),
                                                       $this->createFilterAnnotation(array('minLength' => 10,
                                                                                           'maxLength' => 40
                                                                                     )
                                                       )
                            )
        );
    }

    /**
     * @test
     */
    public function returnsValueWithTagsIfAllowed()
    {
        $this->assertEquals('Do <u>you</u> expect me to <b>talk</b>?',
                            $this->paramBroker->handle($this->mockRequest(ValueFilter::mockForValue('Do <u>you</u> expect me to <b>talk</b>?')),
                                                       $this->createFilterAnnotation(array('minLength'   => 10,
                                                                                           'maxLength'   => 40,
                                                                                           'allowedTags' => 'b, u'
                                                                                     )
                                                       )
                            )
        );
    }
}
?>