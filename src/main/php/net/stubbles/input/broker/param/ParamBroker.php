<?php
/**
 * This file is part of stubbles.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package  net\stubbles\input
 */
namespace net\stubbles\input\broker\param;
use net\stubbles\input\Request;
use net\stubbles\lang\Object;
use net\stubbles\lang\reflect\annotation\Annotation;
/**
 * Broker to be used to filter parameters based on annotations.
 */
interface ParamBroker extends Object
{
    /**
     * handles single param
     *
     * @param   Request      $request     instance to handle value with
     * @param   Annotation   $annotation  annotation which contains filter metadata
     * @return  mixed
     * @throws  RuntimeException
     */
    public function handle(Request $request, Annotation $annotation);
}
?>