<?php

namespace Burut\Bundle\MenuBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Furnit
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Furnit
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="art", type="string", length=50)
     */
    private $art;

    /**
     * @var string
     *
     * @ORM\Column(name="nazv", type="string", length=50)
     */
    private $nazv;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="decimal")
     */
    private $price;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set art
     *
     * @param string $art
     * @return Furnit
     */
    public function setArt($art)
    {
        $this->art = $art;

        return $this;
    }

    /**
     * Get art
     *
     * @return string 
     */
    public function getArt()
    {
        return $this->art;
    }

    /**
     * Set nazv
     *
     * @param string $nazv
     * @return Furnit
     */
    public function setNazv($nazv)
    {
        $this->nazv = $nazv;

        return $this;
    }

    /**
     * Get nazv
     *
     * @return string 
     */
    public function getNazv()
    {
        return $this->nazv;
    }

    /**
     * Set price
     *
     * @param string $price
     * @return Furnit
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string 
     */
    public function getPrice()
    {
        return $this->price;
    }
}
