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
use net\stubbles\input\validator\ValueReader;
require_once __DIR__ . '/MultipleSourceReaderBrokerTestCase.php';
/**
 * Tests for net\stubbles\input\broker\param\MailParamBroker.
 *
 * @group  broker
 * @group  broker_param
 */
class MailParamBrokerTestCase extends MultipleSourceReaderBrokerTestCase
{
    /**
     * set up test environment
     */
    public function setUp()
    {
        $this->paramBroker = new MailParamBroker();
    }

    /**
     * returns name of request annotation
     *
     * @return  string
     */
    protected function getRequestAnnotationName()
    {
        return 'Mail';
    }

    /**
     * returns expected filtered value
     *
     * @return  string
     */
    protected function getExpectedValue()
    {
        return 'me@example.com';
    }

    /**
     * @test
     */
    public function returnsNullIfParamNotSetAndRequired()
    {
        $this->assertNull($this->paramBroker->procure($this->mockRequest(ValueReader::mockForValue(null)),
                                                      $this->createRequestAnnotation(array('required' => true))
                          )
        );
    }
}
?>