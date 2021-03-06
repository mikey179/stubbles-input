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
 * Tests for stubbles\input\filter\BoolFilter.
 *
 * @since  1.2.0
 * @group  filter
 */
class BoolFilterTest extends FilterTest
{
    /**
     * instance to test
     *
     * @type  BoolFilter
     */
    private $boolFilter;

    /**
     * set up test environment
     */
    public function setUp()
    {
        $this->boolFilter = BoolFilter::instance();
        parent::setUp();
    }

    /**
     * @test
     */
    public function filtering1AsIntReturnsTrue()
    {
        $this->assertTrue($this->boolFilter->apply($this->createParam(1)));
    }

    /**
     * @test
     */
    public function filtering1AsStringReturnsTrue()
    {
        $this->assertTrue($this->boolFilter->apply($this->createParam('1')));
    }

    /**
     * @test
     */
    public function filteringTrueAsStringReturnsTrue()
    {
        $this->assertTrue($this->boolFilter->apply($this->createParam('true')));
    }

    /**
     * @test
     */
    public function filteringTrueAsBoolReturnsTrue()
    {
        $this->assertTrue($this->boolFilter->apply($this->createParam(true)));
    }

    /**
     * @test
     * @since  2.4.1
     * @group  issue_49
     */
    public function filteringYesAsStringReturnsTrue()
    {
        $this->assertTrue($this->boolFilter->apply($this->createParam('yes')));
    }

    /**
     * @test
     */
    public function filtering0AsIntReturnsFalse()
    {
        $this->assertFalse($this->boolFilter->apply($this->createParam(0)));
    }

    /**
     * @test
     */
    public function filtering0AsStringReturnsFalse()
    {
        $this->assertFalse($this->boolFilter->apply($this->createParam('0')));
    }

    /**
     * @test
     */
    public function filteringFalseAsStringReturnsFalse()
    {
        $this->assertFalse($this->boolFilter->apply($this->createParam('false')));
    }

    /**
     * @test
     */
    public function filteringFalseAsBoolReturnsFalse()
    {
        $this->assertFalse($this->boolFilter->apply($this->createParam(false)));
    }

    /**
     * @test
     * @since  2.4.1
     * @group  issue_49
     */
    public function filteringNoAsStringReturnsFalse()
    {
        $this->assertFalse($this->boolFilter->apply($this->createParam('no')));
    }

    /**
     * @test
     */
    public function filteringAnyStringReturnsFalse()
    {
        $this->assertFalse($this->boolFilter->apply($this->createParam('a string')));
    }

    /**
     * @since  1.7.0
     * @test
     * @group  bug266
     */
    public function asBoolReturnsDefaultIfParamIsNullAndDefaultIsNotNull()
    {
        $this->assertTrue($this->createValueReader(null)->defaultingTo(true)->asBool());
    }

    /**
     * @since  1.7.0
     * @test
     */
    public function asBoolReturnsNullIfParamIsNull()
    {
        $this->assertNull($this->createValueReader(null)->asBool());
    }

    /**
     * @since  1.7.0
     * @test
     * @group  bug266
     */
    public function asBoolWithFalseValueReturnsFalse()
    {
        $this->assertFalse($this->createValueReader(0)->asBool());
    }

    /**
     * @since  1.7.0
     * @test
     * @group  bug266
     */
    public function asBoolWithTrueValueReturnsTrue()
    {
        $this->assertTrue($this->createValueReader(1)->asBool());
    }
}
