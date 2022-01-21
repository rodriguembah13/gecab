<?php


namespace App\Utils;


class ModelItem
{
private $item1;
    private $item4;
    private $item2;
    private $item3;

    /**
     * @return mixed
     */
    public function getItem1()
    {
        return $this->item1;
    }

    /**
     * @param mixed $item1
     * @return ModelItem
     */
    public function setItem1($item1)
    {
        $this->item1 = $item1;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getItem4()
    {
        return $this->item4;
    }

    /**
     * @param mixed $item4
     * @return ModelItem
     */
    public function setItem4($item4)
    {
        $this->item4 = $item4;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getItem2()
    {
        return $this->item2;
    }

    /**
     * @param mixed $item2
     * @return ModelItem
     */
    public function setItem2($item2)
    {
        $this->item2 = $item2;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getItem3()
    {
        return $this->item3;
    }

    /**
     * @param mixed $item3
     * @return ModelItem
     */
    public function setItem3($item3)
    {
        $this->item3 = $item3;
        return $this;
    }

}