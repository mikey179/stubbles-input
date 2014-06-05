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
use stubbles\input\Filter;
use stubbles\input\Param;
/**
 * Class for filtering passwords.
 *
 * This filter allows to check password inputs and if they comply with the rules
 * for a password. It is possible to check against a list of non-allowed passwords
 * (e.g. the username or the login name).
 * If the value is an array the fields with key 0 and 1 are compared. If they are
 * not equal the password is not allowed (can be used to prevent mistyped
 * passwords in register or password change forms).
 */
class PasswordFilter implements Filter
{
    const MIN_DIFF_CHARS_DEFAULT = 5;
    /**
     * minimum amount of different characters in the password
     *
     * @type  int
     */
    private $minDiffChars        = self::MIN_DIFF_CHARS_DEFAULT;
    /**
     * list of values that are not allowed as password
     *
     * @type  string[]
     */
    private $nonAllowedValues    = [];

    /**
     * set a list of values that are not allowed as password
     *
     * @param   string[]  $values  list of values that are not allowed as password
     * @return  PasswordFilter
     */
    public function disallowValues(array $values)
    {
        $this->nonAllowedValues = $values;
        return $this;
    }

    /**
     * set minimum amount of different characters within password
     *
     * Set the value with NULL to disable the check.
     *
     * @param   int  $minDiffChars
     * @return  PasswordFilter
     */
    public function minDiffChars($minDiffChars)
    {
        $this->minDiffChars = $minDiffChars;
        return $this;
    }

    /**
     * apply filter on given param
     *
     * @param   Param  $param
     * @return  string  secured password
     */
    public function apply(Param $param)
    {
        $value = $param->value();
        if (is_array($value)) {
            if ($value[0] !== $value[1]) {
                $param->addError('PASSWORDS_NOT_EQUAL');
                return null;
            }

            $value = $value[0];
        }

        if (in_array($value, $this->nonAllowedValues)) {
            $param->addError('PASSWORD_INVALID');
            return null;
        }

        if (null !== $this->minDiffChars) {
            if (count(count_chars($value, 1)) < $this->minDiffChars) {
                $param->addError('PASSWORD_TOO_LESS_DIFF_CHARS');
                return null;
            }
        }

        if (strlen($value) > 0) {
            return $value;
        }

        return null;
    }
}
