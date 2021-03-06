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
use org\bovigo\vfs\vfsStream;
/**
 * Tests for stubbles\input\validator\DirectoryValidator.
 *
 * @since  2.0.0
 * @group  validator
 * @group  filesystem
 * @deprecated  since 3.0.0, will be removed with 4.0.0
 */
class DirectoryValidatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * set up test environment
     */
    public function setUp()
    {
        $root = vfsStream::setup();
        vfsStream::newDirectory('basic')
                 ->at($root);
        vfsStream::newFile('foo.txt')
                 ->at($root);
        vfsStream::newDirectory('other')
                 ->at($root);
        vfsStream::newDirectory('bar')
                 ->at($root->getChild('basic'));
    }

    /**
     * @test
     */
    public function validatesToFalseForNull()
    {
        $directoryValidator = new DirectoryValidator();
        $this->assertFalse($directoryValidator->validate(null));
    }

    /**
     * @test
     */
    public function validatesToFalseForEmptyString()
    {
        $directoryValidator = new DirectoryValidator();
        $this->assertFalse($directoryValidator->validate(''));
    }

    /**
     * @test
     */
    public function validatesToTrueForRelativePath()
    {
        $directoryValidator = new DirectoryValidator(vfsStream::url('root/basic'));
        $this->assertTrue($directoryValidator->validate('../other'));
    }

    /**
     * @test
     */
    public function validatesToFalseIfDirDoesNotExistRelatively()
    {
        $directoryValidator = new DirectoryValidator(vfsStream::url('root/basic'));
        $this->assertFalse($directoryValidator->validate('other'));
    }

    /**
     * @test
     */
    public function validatesToFalseIfDirDoesNotExistGlobally()
    {
        $directoryValidator = new DirectoryValidator();
        $this->assertFalse($directoryValidator->validate(__DIR__ . '/../doesNotExist'));
    }

    /**
     * @test
     */
    public function validatesToTrueIfDirDoesExistRelatively()
    {
        $directoryValidator = new DirectoryValidator(vfsStream::url('root/basic'));
        $this->assertTrue($directoryValidator->validate('bar'));
    }

    /**
     * @test
     */
    public function validatesToTrueIfDirDoesExistGlobally()
    {
        $directoryValidator = new DirectoryValidator();
        $this->assertTrue($directoryValidator->validate(__DIR__));
    }

    /**
     * @test
     */
    public function validatesToFalseIfIsRelativeFile()
    {
        $directoryValidator = new DirectoryValidator(vfsStream::url('root'));
        $this->assertFalse($directoryValidator->validate('foo.txt'));
    }

    /**
     * @test
     */
    public function validatesToFalseIfIsGlobalFile()
    {
        $directoryValidator = new DirectoryValidator();
        $this->assertFalse($directoryValidator->validate(__FILE__));
    }
}
