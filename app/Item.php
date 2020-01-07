<?php
namespace App;


class Item
{
    private $name;
    private $price;
    private $qty;

    public function __construct($name = '', $qty = 1, $price = '')
    {
        $this->name = $name;
        $this->price = $price;
        $this->qty = $qty;
    }

    public function __toString()
    {
        $col = 10;

        $name = str_pad($this->name, $col) ;
        $qty = str_pad($this->qty, $col, ' ', STR_PAD_LEFT);
        $price = str_pad($this->price, $col, ' ', STR_PAD_LEFT);
        return "$name$qty$price\n";
    }
}