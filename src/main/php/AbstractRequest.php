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
use stubbles\input\errors\ParamErrors;
/**
 * Abstract base class for requests.
 */
abstract class AbstractRequest implements Request
{
    /**
     * list of params
     *
     * @type  Params
     */
    private $params;
    /**
     * switch whether request has been cancelled or not
     *
     * @type  bool
     */
    private $isCancelled   = false;

    /**
     * constructor
     *
     * @param  Params  $params
     */
    public function __construct(Params $params)
    {
        $this->params = $params;
    }

    /**
     * cancels the request, e.g. if it was detected that it is invalid
     *
     * @return  Request
     * @deprecated  since 3.0.0, will be removed with 4.0.0
     */
    public function cancel()
    {
        $this->isCancelled = true;
        return $this;
    }

    /**
     * checks whether the request has been cancelled or not
     *
     * @return  bool
     * @deprecated  since 3.0.0, will be removed with 4.0.0
     */
    public function isCancelled()
    {
        return $this->isCancelled;
    }

    /**
     * return a list of all param names registered in this request
     *
     * @return  string[]
     */
    public function paramNames()
    {
        return $this->params->names();
    }

    /**
     * return an array of all param names registered in this request
     *
     * @return  string[]
     * @since   1.3.0
     * @deprecated  since 3.0.0, use paramNames() instead, will be removed with 4.0.0
     */
    public function getParamNames()
    {
        return $this->paramsNames();
    }

    /**
     * returns list of errors for request parameters
     *
     * @return  ParamErrors
     * @since   1.3.0
     */
    public function paramErrors()
    {
        return $this->params->errors();
    }

    /**
     * checks whether a request param is set
     *
     * @param   string  $paramName
     * @return  bool
     * @since   1.3.0
     */
    public function hasParam($paramName)
    {
        return $this->params->contain($paramName);
    }

    /**
     * checks whether a request value from parameters is valid or not
     *
     * @param   string  $paramName  name of parameter
     * @return  ValueValidator
     * @since   1.3.0
     */
    public function validateParam($paramName)
    {
        return new ValueValidator($this->params->get($paramName));
    }

    /**
     * returns request value from params for filtering or validation
     *
     * @param   string  $paramName  name of parameter
     * @return  ValueReader
     * @since   1.3.0
     */
    public function readParam($paramName)
    {
        return new ValueReader($this->params->errors(),
                               $this->params->get($paramName)
        );
    }
}
