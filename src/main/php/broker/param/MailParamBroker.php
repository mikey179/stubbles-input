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
 * Filter mail addresses based on a @Request[Mail] annotation.
 */
class MailParamBroker extends MultipleSourceParamBroker
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
        return $valueReader->asMailAddress();
    }

    /**
     * whether a default value for this param is supported
     *
     * @return  bool
     */
    protected function supportsDefault()
    {
        return false;
    }
}
