<?php
/**
 * This file is part of stubbles.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package  stubbles\input
 */
namespace stubbles\input\filter\range;
use stubbles\lang\exception\MethodNotSupportedException;
/**
 * Interface for range definitions.
 *
 * Range definitions can be used to set up valid ranges for values.
 *
 * @since  2.0.0
 */
interface Range
{
    /**
     * checks if range contains given value
     *
     * @param   mixed  $value
     * @return  bool
     */
    public function contains($value);

    /**
     * returns list of errors when range does not contain given value
     *
     * @param   mixed  $value
     * @return  array
     */
    public function errorsOf($value);

    /**
     * checks whether value can be truncated to maximum value
     *
     * @param   mixed  $value
     * @return  bool
     * @since   2.3.1
     */
    public function allowsTruncate($value);

    /**
     * truncates given value to max border
     *
     * @param   string  $value
     * @return  string
     * @since   2.3.1
     */
    public function truncateToMaxBorder($value);
}
/**
 * Trait for ranges that don't support truncation.
 *
 * @since  3.0.0
 */
trait NonTruncatingRange
{
    /**
     * checks whether value can be truncated to maximum value
     *
     * @param   mixed  $value
     * @return  bool
     */
    public function allowsTruncate($value)
    {
        return false;
    }

    /**
     * truncates given value to max border, which is not supported for numbers
     *
     * @param   string  $value
     * @return  string
     * @throws  MethodNotSupportedException
     */
    public function truncateToMaxBorder($value)
    {
        throw new MethodNotSupportedException('Truncating is not supported');
    }
}
