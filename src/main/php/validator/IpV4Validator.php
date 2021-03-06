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
use stubbles\input\Validator;
/**
 * Class for validating that something is an ip v4 address.
 *
 * @since  1.7.0
 * @api
 * @deprecated  since 3.0.0, use stubbles\predicate\IsIpV4Address instead, will be removed with 4.0.0
 */
class IpV4Validator implements Validator
{
    /**
     * validates if given value is an ip v4 address
     *
     * @param   mixed  $value
     * @return  bool
     */
    public static function validateAddress($value)
    {
        return (bool) preg_match('/^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$/', $value);
    }

    /**
     * validate that the given value is eqal in content and type to the expected value
     *
     * @param   mixed  $value
     * @return  bool   true if value is equal to expected value, else false
     */
    public function validate($value)
    {
        return self::validateAddress($value);
    }
}
