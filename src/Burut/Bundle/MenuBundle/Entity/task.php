<?php
// src/Acme/TaskBundle/Entity/Task.php
namespace Burut\Bundle\MenuBundle\Entity;

class Task
{
    protected $name;

    protected $address;

    protected $phone;

    public function getName()
    {
        return $this->name;
    }
    public function setName($name)
    {
        $this->name = $name;
    }

    public function getAddress()
    {
        return $this->address;
    }
    public function setAddress()
    {
        $this->address = $address;
    }

    public function getPhone()
    {
        return $this->phone;
    }
    public function setPhone()
    {
        $this->phone = $phone;
    }
}