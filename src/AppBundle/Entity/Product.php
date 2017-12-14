<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Product
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProductRepository")
 * @ORM\Table(name="products", uniqueConstraints={
 *     @ORM\UniqueConstraint(name="product_code_unique", columns={"code"}),
 *     @ORM\UniqueConstraint(name="product_name_unique", columns={"name"}),
 *     @ORM\UniqueConstraint(name="product_price_unique", columns={"price"})
 * })
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="string")
     * @ORM\GeneratedValue(strategy="UUID")
     *
     * @var string
     */
    private $id;

    /**
     * @ORM\Column(name="code", type="string")
     *
     * @var string
     */
    private $code;

    /**
     * @ORM\Column(name="name", type="string")
     *
     * @var string
     */
    private $name;

    /**
     * @ORM\Column(name="price", type="float")
     *
     * @var float
     */
    private $price;

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return Product
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param string $code
     * @return Product
     */
    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Product
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param float $price
     * @return Product
     */
    public function setPrice($price)
    {
        $this->price = $price;
        return $this;
    }
}
