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
use net\stubbles\input\filter\ValueFilter;
use net\stubbles\input\filter\range\NumberRange;
use net\stubbles\lang\reflect\annotation\Annotation;
/**
 * Filter integer values based on a @Request[Integer] annotation.
 */
class IntegerParamBroker extends MultipleSourceFilterBroker
{
    /**
     * handles single param
     *
     * @param   ValueFilter  $valueFilter  instance to filter value with
     * @param   Annotation   $annotation   annotation which contains filter metadata
     * @return  int
     */
    protected function filter(ValueFilter $valueFilter, Annotation $annotation)
    {
        return $valueFilter->asInt($annotation->getDefault(),
                                   new NumberRange($annotation->getMinValue(),
                                                  $annotation->getMaxValue()
                                   )
        );
    }
}
?>