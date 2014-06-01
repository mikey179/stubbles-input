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
use net\stubbles\input\ValueReader;
use stubbles\lang\reflect\annotation\Annotation;
/**
 * Read string values based on a @Request[File] annotation.
 */
class FileParamBroker extends MultipleSourceParamBroker
{
    /**
     * filters single param
     *
     * @param   ValueReader  $valueReader  instance to filter value with
     * @param   Annotation   $annotation   annotation which contains filter metadata
     * @return  mixed
     */
    protected function filter(ValueReader $valueReader, Annotation $annotation)
    {
        return $valueReader->ifIsFile($annotation->getBasePath(),
                                      $annotation->getDefault()
        );
    }
}
