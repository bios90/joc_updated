<?php
/**
 * Created by PhpStorm.
 * User: bios90
 * Date: 2019-03-15
 * Time: 23:25
 */

class Model_Weight
{
    public $id;
    public $item_id;
    public $weight;
    public $price;

    function setData($data)
    {
        foreach ($data as $key => $value)
        {
            if(property_exists($this, $key))
            {
                $this->$key = $value;
            }
        }
    }
}