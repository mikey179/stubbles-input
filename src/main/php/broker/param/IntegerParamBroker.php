<?php
/**
 * This file is part of stubbles.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package  stubbles\input
 */
namespace stubbles\input\broker\param;
use stubbles\input\filter\range\NumberRange;
use stubbles\input\valuereader\CommonValueReader;
use stubbles\lang\reflect\annotation\Annotation;
/**
 * Filter integer values based on a @Request[Integer] annotation.
 */
class IntegerParamBroker extends MultipleSourceParamBroker
{
    /**
     * handles single param
     *
     * @param   CommonValueReader  $valueReader  instance to filter value with
     * @param   Annotation         $annotation   annotation which contains filter metadata
     * @return  int
     */
    protected function filter(CommonValueReader $valueReader, Annotation $annotation)
    {
        return $valueReader->asInt(new NumberRange($annotation->getMinValue(),
                                                   $annotation->getMaxValue()
                                   )
        );
    }

    /**
     * parses default value from annotation
     *
     * @param   string  $value
     * @return  int
     */
    protected function parseDefault($value)
    {
        return (int) $value;
    }
}
