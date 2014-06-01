<?php
/**
 * This file is part of stubbles.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package  net\stubbles\input
 */
namespace net\stubbles\input\filter;
use net\stubbles\input\Filter;
use net\stubbles\input\Param;
use stubbles\peer\http\AcceptHeader;
/**
 * Filters accept headers.
 *
 * @since  2.0.1
 */
class AcceptFilter implements Filter
{
    /**
     * apply filter on given param
     *
     * @param   Param  $param
     * @return  AcceptHeader
     */
    public function apply(Param $param)
    {
        if ($param->isNull() || $param->isEmpty()) {
            return new AcceptHeader();
        }

        try {
            return AcceptHeader::parse($param->getValue());
        } catch (\stubbles\lang\exception\IllegalArgumentException $iae) {
            return new AcceptHeader();
        }
    }
}
