<?php
/**
 * This file is part of stubbles.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package  stubbles\input
 */
namespace stubbles\input;
use stubbles\input\errors\ParamError;
/**
 * Container for a parameter and its value.
 *
 * @since  2.0.0
 */
class Param
{
    /**
     * name of param
     *
     * @type  string
     */
    private $name;
    /**
     * original value
     *
     * @type  string
     */
    private $value;
    /**
     * list of error ids for this param
     *
     * @type  ParamError[]
     */
    private $errors = [];

    /**
     * constructor
     *
     * @param  string  $name   name of param
     * @param  string  $value  original value
     */
    public function __construct($name, $value)
    {
        $this->name  = $name;
        $this->value = $value;
    }

    /**
     * returns name of param
     *
     * @return  string
     * @since   3.0.0
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * returns name of param
     *
     * @return  string
     * @deprecated since 3.0.0, use name() instead, will be removed with 4.0.0
     */
    public function getName()
    {
        return $this->name();
    }

    /**
     * returns value of param
     *
     * @return  string
     * @since   3.0.0
     */
    public function value()
    {
        return $this->value;
    }

    /**
     * returns value of param
     *
     * @return  string
     * @deprecated since 3.0.0, use value() instead, will be removed with 4.0.0
     */
    public function getValue()
    {
        return $this->value();
    }

    /**
     * checks if parameter is null
     *
     * @return  bool
     */
    public function isNull()
    {
        return null === $this->value;
    }

    /**
     * checks if parameter is empty
     *
     * Parameter is empty if its value is null or an empty string.
     *
     * @return  bool
     */
    public function isEmpty()
    {
        return $this->isNull() || $this->length() === 0;
    }

    /**
     * returns length of value
     *
     * @return  int
     */
    public function length()
    {
        return strlen($this->value);
    }

    /**
     * adds error with given id
     *
     * @param   ParamError|string  $error    id of error or an instance of ParamError
     * @param   array              $details  details of what caused the error
     * @return  ParamError
     */
    public function addError($error, array $details = [])
    {
        $error = ParamError::fromData($error, $details);
        $this->errors[$error->id()] = $error;
        return $error;
    }

    /**
     * checks if param has error with given id
     *
     * @param   string  $errorId
     * @return  bool
     */
    public function hasError($errorId)
    {
        return isset($this->errors[$errorId]);
    }

    /**
     * checks if param has any errors
     *
     * @return  bool
     */
    public function hasErrors()
    {
        return count($this->errors) > 0;
    }

    /**
     * returns list of error ids
     *
     * @return  ParamError[]
     * @since   3.0.0
     */
    public function errors()
    {
        return $this->errors;
    }

    /**
     * returns list of error ids
     *
     * @return  ParamError[]
     * @deprecated since 3.0.0, use errors() instead, will be removed with 4.0.0
     */
    public function getErrors()
    {
        return $this->errors();
    }
}
