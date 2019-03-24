<?php
/**
 * Created by PhpStorm.
 * User: bios90
 * Date: 2019-03-15
 * Time: 23:26
 */

class Model_Product
{
    public $id;
    public $cafe_id;
    public $categ;
    public $name;
    public $img_name;
    public $description;
    public $price;

    public $listOfAdds = array();
    public $listOfMilks = array();
    public $listOfWeights = array();

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