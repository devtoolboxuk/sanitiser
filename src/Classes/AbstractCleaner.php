<?php

namespace devtoolboxuk\sanitiser\classes;

abstract class AbstractCleaner
{

    protected $data;

    private $reg_SQL = "/(drop|insert|md5|select|union)/i";
    private $reg_EVAL = "/(eval\()/i";


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



    public function filterSecurity()
    {
        if (preg_match($this->reg_SQL,$this->data)) {
            $this->data = '';
        }

        if (preg_match($this->reg_EVAL,$this->data)) {
            $this->data = str_replace("eval","",$this->data);
        }
        return $this;
    }
}