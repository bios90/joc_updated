<?php
/**
 * Created by PhpStorm.
 * User: bios90
 * Date: 2019-02-27
 * Time: 20:19
 */

class Model_Cafe
{
    public $id;
    public $email;
    public $name;
    public $ooo;
    public $okpo;
    public $adress_ur;
    public $adress_fact;
    public $dirfio;
    public $phone;
    public $inn;
    public $hour_ot;
    public $minute_ot;
    public $hour_do;
    public $minute_do;
    public $logo_name;
    public $status;

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

    /**
     * Model_Cafe constructor.
     */
    public function __construct()
    {

    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function public ()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getOoo()
    {
        return $this->ooo;
    }

    /**
     * @param mixed $ooo
     */
    public function setOoo($ooo)
    {
        $this->ooo = $ooo;
    }

    /**
     * @return mixed
     */
    public function getAdressUr()
    {
        return $this->adress_ur;
    }

    /**
     * @param mixed $adress_ur
     */
    public function setAdressUr($adress_ur)
    {
        $this->adress_ur = $adress_ur;
    }

    /**
     * @return mixed
     */
    public function getAdressFact()
    {
        return $this->adress_fact;
    }

    /**
     * @param mixed $adress_fact
     */
    public function setAdressFact($adress_fact)
    {
        $this->adress_fact = $adress_fact;
    }

    /**
     * @return mixed
     */
    public function getDirfio()
    {
        return $this->dirfio;
    }

    /**
     * @param mixed $dirfio
     */
    public function setDirfio($dirfio)
    {
        $this->dirfio = $dirfio;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param mixed $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return mixed
     */
    public function getInn()
    {
        return $this->inn;
    }

    /**
     * @param mixed $inn
     */
    public function setInn($inn)
    {
        $this->inn = $inn;
    }

    /**
     * @return mixed
     */
    public function getHourOt()
    {
        return $this->hour_ot;
    }

    /**
     * @param mixed $hour_ot
     */
    public function setHourOt($hour_ot)
    {
        $this->hour_ot = $hour_ot;
    }

    /**
     * @return mixed
     */
    public function getMinuteOt()
    {
        return $this->minute_ot;
    }

    /**
     * @param mixed $minute_ot
     */
    public function setMinuteOt($minute_ot)
    {
        $this->minute_ot = $minute_ot;
    }

    /**
     * @return mixed
     */
    public function getHourDo()
    {
        return $this->hour_do;
    }

    /**
     * @param mixed $hour_do
     */
    public function setHourDo($hour_do)
    {
        $this->hour_do = $hour_do;
    }

    /**
     * @return mixed
     */
    public function getMinuteDo()
    {
        return $this->minute_do;
    }

    /**
     * @param mixed $minute_do
     */
    public function setMinuteDo($minute_do)
    {
        $this->minute_do = $minute_do;
    }

    /**
     * @return mixed
     */
    public function getLogoName()
    {
        return $this->logo_name;
    }

    /**
     * @param mixed $logo_name
     */
    public function setLogoName($logo_name)
    {
        $this->logo_name = $logo_name;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getOkpo()
    {
        return $this->okpo;
    }

    /**
     * @param mixed $okpo
     */
    public function setOkpo($okpo)
    {
        $this->okpo = $okpo;
    }





}