<?php

namespace devtoolboxuk\sanitiser;

class SanitiserService
{
    /**
     * @param $data
     * @return string
     */
    public function cleanse($data)
    {
        $data = $this->cleanString($data);
        $data = mb_convert_encoding($data, "utf-8", "auto");
        $data = htmlspecialchars_decode($data);
        $data = $this->cleanString($data);
        return $data;
    }

    /**
     * @param $string
     * @param string $delimiter
     * @return string
     */
    public function cleanseCsv($string, $delimiter = "|")
    {
        return trim(str_replace([$delimiter, "\n", "\r", "\t"], " ", $string));
    }

    /**
     * @param $data
     * @return string
     */
    private function cleanString($data)
    {
        $data = implode("", explode("\\", $data));
        return strip_tags(trim(stripslashes($data)));
    }

    /**
     * @param $data
     * @param string $type
     * @param bool $stringLength
     * @return mixed
     */
    public function disinfect($data, $type = 'special_chars', $stringLength = false)
    {
        $data = $this->cleanString($data);
        $data = $this->stringLength($data, $stringLength);

        switch ($type) {
            case "email":
                $result = filter_var($data, FILTER_SANITIZE_EMAIL);
                break;

            case "encoded":
                $result = filter_var($data, FILTER_SANITIZE_ENCODED);
                break;

            case "number_float":
            case "float":
                $result = filter_var($data, FILTER_SANITIZE_NUMBER_FLOAT);

                break;

            case "number_int":
            case "int":
                $result = filter_var($data, FILTER_SANITIZE_NUMBER_INT);

                break;

            case "full_special_chars":
                $result = filter_var($data, FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_FLAG_NO_ENCODE_QUOTES);
                break;

            case "url":
                $result = filter_var($data, FILTER_SANITIZE_URL);
                break;

            case "string":
                $result = filter_var($data, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
                break;

            default:
            case "special_chars":
                $result = filter_var($data, FILTER_SANITIZE_SPECIAL_CHARS);
                break;
        }

        return $result;
    }

    /**
     * @param $data
     * @param bool $length
     * @return mixed
     */
    private function stringLength($data, $length = false)
    {
        if ($length) {
            if (mb_strlen($data) > $length) {
                $data = substr($data, 0, $length);
            }
        }
        return $data;
    }

}