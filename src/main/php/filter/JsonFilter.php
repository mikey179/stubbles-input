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
 * Class for decoding JSON.
 *
 * @link  http://www.json.org/
 * @link  http://www.ietf.org/rfc/rfc4627.txt
 */
class JsonFilter implements Filter
{
    use ReusableFilter;

    /**
     * apply filter on given param
     *
     * @param   Param  $param
     * @return  \stdClass|array
     */
    public function apply(Param $param)
    {
        if ($param->isEmpty()) {
            return null;
        }

        if ($param->length() > 20000) {
            $param->addError('JSON_INPUT_TOO_BIG');
            return null;
        }

        $value = $param->value();
        if (!$this->isValidJsonStructure($value)) {
            $param->addError('JSON_INVALID');
            return null;
        }

        $decodedJson = json_decode($value);
        $errorCode   = json_last_error();
        if (JSON_ERROR_NONE !== $errorCode) {
            $param->addError('JSON_SYNTAX_ERROR', ['errorCode' => $errorCode]);
            return null;
        }

        return $decodedJson;
    }

    /**
     * checks if given json is valid a valid structure
     *
     * JSON can only be an object or an array structure (see JSON spec & RFC),
     * but json_decode() lacks this restriction.
     *
     * @param   mixed  $json
     * @return  bool
     */
    private function isValidJsonStructure($json)
    {
        if ('{' === $json[0] && $json[strlen($json) - 1] !== '}') {
            return false;
        } elseif ('[' === $json[0] && $json[strlen($json) - 1] !== ']') {
            return false;
        } elseif ('{' !== $json[0] && '[' !== $json[0]) {
            return false;
        }

        return true;
    }
}
