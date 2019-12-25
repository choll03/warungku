<?php
namespace App;


class CoreItem
{
    private $key;
    private $value;

    public function __construct($key = '', $value = '')
    {
        $this->key = $key;
        $this->value = $value;
    }

    public function __toString()
    {
        $rightCols = 10;
        $leftCols = 20;
        $left = str_pad($this->key, $leftCols) ;

        $right = str_pad($this->value, $rightCols, ' ', STR_PAD_LEFT);
        return "$left$right\n";
    }
}