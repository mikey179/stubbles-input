<?php
/**
 * This file is part of stubbles.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package  stubbles\input
 */
namespace stubbles\input\filter;
require_once __DIR__ . '/FilterTest.php';
/**
 * Tests for stubbles\input\filter\MailFilter.
 *
 * @group  filter
 */
class MailFilterTest extends FilterTest
{
    /**
     * instance to test
     *
     * @var  MailFilter
     */
    private $mailFilter;

    /**
     * create test environment
     *
     */
    public function setUp()
    {
        $this->mailFilter = MailFilter::instance();
        parent::setUp();
    }

    /**
     * @test
     */
    public function returnsNullWhenValueIsNull()
    {
        $this->assertNull($this->mailFilter->apply($this->createParam(null)));
    }

    /**
     * @test
     */
    public function returnsNullWhenValueIsEmpty()
    {
        $this->assertNull($this->mailFilter->apply($this->createParam('')));
    }

    /**
     * @test
     */
    public function returnsFilteredValue()
    {
        $this->assertEquals('example@example.org',
                            $this->mailFilter->apply($this->createParam('example@example.org'))
        );
    }

    /**
     * @test
     */
    public function returnsNullIfParamIsNullAndRequired()
    {
        $this->assertNull($this->createValueReader(null)->required()->asMailAddress());
    }

    /**
     * @test
     */
    public function addsParamErrorIfParamIsNullAndRequired()
    {
        $this->createValueReader(null)->required()->asMailAddress();
        $this->assertTrue($this->paramErrors->existForWithId('bar', 'MAILADDRESS_MISSING'));
    }

    /**
     * @test
     */
    public function returnsNullWhenSpaceInValue()
    {
        $this->assertNull($this->mailFilter->apply($this->createParam('space in@mailadre.ss')));
    }

    /**
     * @test
     */
    public function addsErrorToParamWhenSpaceInValue()
    {
        $param = $this->createParam('space in@mailadre.ss');
        $this->mailFilter->apply($param);
        $this->assertTrue($param->hasError('MAILADDRESS_CANNOT_CONTAIN_SPACES'));
    }

    /**
     * @test
     */
    public function returnsNullWhenGermanUmlautInValue()
    {
        $this->assertNull($this->mailFilter->apply($this->createParam('föö@mailadre.ss')));
    }

    /**
     * @test
     */
    public function addsErrorToParamWhenGermanUmlautInValue()
    {
        $param = $this->createParam('föö@mailadre.ss');
        $this->mailFilter->apply($param);
        $this->assertTrue($param->hasError('MAILADDRESS_CANNOT_CONTAIN_UMLAUTS'));
    }

    /**
     * @test
     */
    public function returnsNullWhenMoreThanOneAtCharacterInValue()
    {
        $this->assertNull($this->mailFilter->apply($this->createParam('foo@bar@mailadre.ss')));
    }

    /**
     * @test
     */
    public function addsErrorToParamWhenMoreThanOneAtCharacterInValue()
    {
        $param = $this->createParam('foo@bar@mailadre.ss');
        $this->mailFilter->apply($param);
        $this->assertTrue($param->hasError('MAILADDRESS_MUST_CONTAIN_ONE_AT'));
    }

    /**
     * @test
     */
    public function returnsNullWhenIllegalCharsInValue()
    {
        $this->assertNull($this->mailFilter->apply($this->createParam('foo&/4@mailadre.ss')));
    }

    /**
     * @test
     */
    public function addsErrorToParamWhenIllegalCharsInValue()
    {
        $param = $this->createParam('foo&/4@mailadre.ss');
        $this->mailFilter->apply($param);
        $this->assertTrue($param->hasError('MAILADDRESS_CONTAINS_ILLEGAL_CHARS'));
    }

    /**
     * @test
     */
    public function returnsNullWhenTwoFollowingDotsInValue()
    {
        $this->assertNull($this->mailFilter->apply($this->createParam('foo..bar@mailadre.ss')));
    }

    /**
     * @test
     */
    public function addsErrorToParamWhenTwoFollowingDotsInValue()
    {
        $param = $this->createParam('foo..bar@mailadre.ss');
        $this->mailFilter->apply($param);
        $this->assertTrue($param->hasError('MAILADDRESS_CONTAINS_TWO_FOLLOWING_DOTS'));
    }

    /**
     * @since  3.0.0
     * @test
     */
    public function asMailAddressReturnsEmptyStringIfParamIsNullAndNotRequired()
    {
        $this->assertEquals('', $this->createValueReader(null)->asMailAddress());
    }

    /**
     * @since  3.0.0
     * @test
     */
    public function asMailAddressReturnsDefaultIfParamIsNullAndNotRequired()
    {
        $this->assertEquals('baz@example.org',
                            $this->createValueReader(null)->defaultingTo('baz@example.org')->asMailAddress()
        );
    }

    /**
     * @since  3.0.0
     * @test
     */
    public function asMailAddressReturnsNullIfParamIsNullAndRequired()
    {
        $this->assertNull($this->createValueReader(null)->required()->asMailAddress());
    }

    /**
     * @since  3.0.0
     * @test
     */
    public function asMailAddressAddsParamErrorIfParamIsNullAndRequired()
    {
        $this->createValueReader(null)->required()->asMailAddress();
        $this->assertTrue($this->paramErrors->existForWithId('bar', 'MAILADDRESS_MISSING'));
    }

    /**
     * @since  3.0.0
     * @test
     */
    public function asStringReturnsNullIfParamIsInvalid()
    {
        $this->assertNull($this->createValueReader('foo')
                               ->asMailAddress()
        );
    }

    /**
     * @since  3.0.0
     * @test
     */
    public function asMailAddressAddsParamErrorIfParamIsInvalid()
    {
        $this->createValueReader('foo')->asMailAddress();
        $this->assertTrue($this->paramErrors->existFor('bar'));
    }

    /**
     * @since  3.0.0
     * @test
     */
    public function asMailAddressReturnsValidValue()
    {
        $this->assertEquals('foo@example.org', $this->createValueReader('foo@example.org')->asMailAddress());

    }
}
