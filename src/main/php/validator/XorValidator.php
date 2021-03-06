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
 * Class that combines differant validators where one has to be true.
 *
 * If no validator or more than one validator returns false the XorValidator
 * will return false as well. It only returns true if one validator returns true
 * and any other validator returns false.
 *
 * @api
 * @deprecated  since 3.0.0, use predicates instead, will be removed with 4.0.0
 */
class XorValidator extends AbstractCompositeValidator
{
    /**
     * validate the given value
     *
     * If no validator or more than one validator returns false it
     * will return false as well. It only returns true if one
     * validator returns true and any other validator returns false.
     *
     * @param   mixed  $value
     * @return  bool   true if value is ok, else false
     */
    protected function doValidate($value)
    {
        $trueCount = 0;
        foreach ($this->validators as $validator) {
            if ($validator->validate($value)) {
                $trueCount++;
                if (1 < $trueCount) {
                    // more than one true received,
                    // can not return with true any more
                    return false;
                }
            }
        }

        return (1 === $trueCount);
    }
}
