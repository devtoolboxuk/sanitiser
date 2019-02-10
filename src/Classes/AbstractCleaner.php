<?php

namespace devtoolboxuk\sanitiser\classes;

abstract class AbstractCleaner
{

    protected $data;

    function __construct()
    {
    }

    /**
     * @param string $data
     * @return $this
     */
    public function string($data)
    {
        $this->data = $this->cleanString($data);
        return $this;
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
     * @return string
     */
    public function cleanse()
    {
        $data = mb_convert_encoding($this->data, "utf-8", "auto");
        return htmlspecialchars_decode($data);
    }

    /**
     * @param string $delimiter
     * @return string
     */
    public function cleanseCsv($delimiter = "|")
    {
        return trim(str_replace([$delimiter, "\n", "\r", "\t"], " ", $this->data));
    }

    /**
     * @param int $length
     * @return $this
     */
    public function limitStringLength(int $length)
    {
        if ($length) {
            if (mb_strlen($this->data) > $length) {
                $this->data = substr($this->data, 0, $length);
            }
        }
        return $this;
    }

    /**
     * @return $this
     */
    public function filterEmail()
    {
        $this->data = filter_var($this->data, FILTER_SANITIZE_EMAIL);
        return $this;
    }

    /**
     * @return $this
     */
    public function filterEncoded()
    {
        $this->data = filter_var($this->data, FILTER_SANITIZE_ENCODED);
        return $this;
    }

    /**
     * @return $this
     */
    public function filterFloat()
    {
        $this->data = filter_var($this->data, FILTER_SANITIZE_NUMBER_FLOAT);
        return $this;
    }

    /**
     * @return $this
     */
    public function filterFloatFraction()
    {
        $this->data = filter_var($this->data, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        return $this;
    }

    /**
     * @return $this
     */
    public function filterInt()
    {
        $this->data = filter_var($this->data, FILTER_SANITIZE_NUMBER_INT);
        return $this;
    }

    /**
     * @return $this
     */
    public function filterFullSpecialChar()
    {
        $this->data = filter_var($this->data, FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_FLAG_NO_ENCODE_QUOTES);
        return $this;
    }

    /**
     * @return $this
     */
    public function filterUrl()
    {
        $this->data = filter_var($this->data, FILTER_SANITIZE_URL);
        return $this;
    }

    /**
     * @return $this
     */
    public function filterString()
    {
        $this->data = filter_var($this->data, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
        return $this;
    }

    /**
     * @return $this
     */
    public function filterSpecial()
    {
        $this->data = filter_var($this->data, FILTER_SANITIZE_SPECIAL_CHARS);
        return $this;
    }
}