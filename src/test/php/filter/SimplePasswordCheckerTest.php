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
use stubbles\lang\SecureString;
/**
 * Tests for stubbles\input\filter\SimplePasswordChecker.
 *
 * @group  filter
 * @since  3.0.0
 */
class SimplePasswordCheckerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * instance to test
     *
     * @type  SimplePasswordChecker
     */
    private $simplePasswordChecker;

    /**
     * set up test environment
     */
    public function setUp()
    {
        $this->simplePasswordChecker = SimplePasswordChecker::create();
    }

    /**
     * @test
     */
    public function doesNotReportErrorsWithDefaultValuesAndSatisfyingPassword()
    {
        $this->assertEquals(
                [],
                $this->simplePasswordChecker->check(SecureString::create('topsecret'))
        );
    }

    /**
     * @test
     */
    public function reportsErrorsWithDefaultValuesAndNonSatisfyingPassword()
    {
        $this->assertEquals(
                ['PASSWORD_TOO_SHORT'           => ['minLength' => SimplePasswordChecker::DEFAULT_MINLENGTH],
                 'PASSWORD_TOO_LESS_DIFF_CHARS' => ['minDiff'   => SimplePasswordChecker::DEFAULT_MIN_DIFF_CHARS]
                ],
                $this->simplePasswordChecker->check(SecureString::create('ooo'))
        );
    }

    /**
     * @test
     */
    public function reportsErrorsWithChangedValuesAndNonSatisfyingPassword()
    {
        $this->assertEquals(
                ['PASSWORD_TOO_SHORT'           => ['minLength' => 10],
                 'PASSWORD_TOO_LESS_DIFF_CHARS' => ['minDiff'   => 8]
                ],
                $this->simplePasswordChecker->minLength(10)
                                            ->minDiffChars(8)
                                            ->check(SecureString::create('topsecret'))
        );
    }

    /**
     * @test
     */
    public function reportsErrorsWithDisallowedValues()
    {
        $this->assertEquals(
                ['PASSWORD_DISALLOWED' => []],
                $this->simplePasswordChecker->disallowValues(['topsecret'])
                                            ->check(SecureString::create('topsecret'))
        );
    }
}
