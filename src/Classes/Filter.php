<?php

namespace devtoolboxuk\sanitiser\classes;

class Filter extends AbstractCleaner implements CleanerInterface
{
    function __construct()
    {
        parent::__construct();
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