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
use stubbles\input\valuereader\CommonValueReader;
use stubbles\lang\reflect\annotation\Annotation;
/**
 * Read string values based on a @Request[Directory] annotation.
 */
class DirectoryParamBroker extends MultipleSourceParamBroker
{
    /**
     * handles single param
     *
     * @param   CommonValueReader  $valueReader  instance to filter value with
     * @param   Annotation         $annotation   annotation which contains filter metadata
     * @return  string
     */
    protected function filter(CommonValueReader $valueReader, Annotation $annotation)
    {
        return $valueReader->ifIsDirectory($annotation->getBasePath(),
                                           $annotation->getDefault()
        );
    }
}
