<?php
/**
 * Created by PhpStorm.
 * User: bios90
 * Date: 2019-04-20
 * Time: 23:01
 */

class Model_News
{
    public $id;
    public $title;
    public $text;
    public $image;
    public $date;

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