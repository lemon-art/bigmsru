<?php
// @codingStandardsIgnoreStart

class CRoistatUtils {

    /**
     * @param string $charset
     * @param array|string $data
     * @param int $stackDepth
     * @param int $maxStackDepth
     * @return array|string
     */
    function convertToUTF8($charset, $data, $stackDepth = 0, $maxStackDepth = 200) {
        try {
            if ($stackDepth > $maxStackDepth) {
                return null;
            }
            $stackDepth++;

            if (is_array($data)) {
                $result = array();
                foreach ($data as $key => $value) {
                    $convertedKey = iconv($charset, 'UTF-8', $key);
                    $convertedValue = $this->convertToUTF8($charset, $value, $stackDepth, $maxStackDepth);
                    $result[$convertedKey] = $convertedValue;
                }
                return $result;
            } else {
                return iconv($charset, 'UTF-8', $data);
            }
        } catch (\Exception $e) {
            $data = null;
        }
        return $data;
    }

    /**
     * @param mixed $data
     * @return string
     */
    function jsonResponse($data) {
        $result = json_encode($data, JSON_UNESCAPED_UNICODE);
        $error  = json_last_error();

        switch ($error) {
            case JSON_ERROR_NONE:
                return $result;
            case JSON_ERROR_DEPTH:
                return 'JSON encode error: Max stack depth exceeded';
            case JSON_ERROR_STATE_MISMATCH:
                return 'JSON encode error: Syntax error';
            case JSON_ERROR_CTRL_CHAR:
                return 'JSON encode error: Incorrect control character';
            case JSON_ERROR_SYNTAX:
                return 'JSON encode error: Syntax error';
            case JSON_ERROR_UTF8:
                return 'JSON encode error: Incorrect UTF-8 symbol, maybe encoding error';
            case JSON_ERROR_RECURSION:
                return 'JSON encode error: One or more recursive references to be encoded';
            case JSON_ERROR_INF_OR_NAN:
                return 'JSON encode error: One or more NaN or infinity values to be encoded';
            case JSON_ERROR_UNSUPPORTED_TYPE:
                return 'JSON encode error: Unsupported value type was given';
            default:
                return 'JSON encode error: Unknown error';
        }
    }

}
// @codingStandardsIgnoreEnd