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
 * Validator that denies validaty of values.
 *
 * @api
 * @deprecated  since 3.0.0, use predicates instead, will be removed with 4.0.0
 */
class DenyValidator implements Validator
{
    /**
     * validate that the given value complies with the regular expression
     *
     * @param   mixed  $value
     * @return  bool   always false
     */
    public function validate($value)
    {
        return false;
    }

}
