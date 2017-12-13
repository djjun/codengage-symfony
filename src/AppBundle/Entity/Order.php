<?php

namespace AppBundle\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Order
 *
 * @ORM\Entity
 * @ORM\Table(name="orders", uniqueConstraints={
 *     @ORM\UniqueConstraint(name="order_number_unique", columns={"number"}),
 *     @ORM\UniqueConstraint(name="order_issued_at_unique", columns={"issued_at"}),
 *     @ORM\UniqueConstraint(name="order_total_unique", columns={"total"})
 * })
 */
class Order
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
     * @ORM\Column(name="number", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @var integer
     */
    private $number;

    /**
     * @ORM\Column(name="issued_at", type="datetime")
     *
     * @var DateTime
     */
    private $issuedAt;

    /**
     * @ORM\Column(name="total", type="float")
     *
     * @var float
     */
    private $total;

    /**
     * @ORM\OneToOne(targetEntity="Customer", fetch="LAZY", cascade={"all"})
     * @ORM\JoinColumn(name="customer_id", referencedColumnName="id")
     *
     * @var Customer
     */
    private $customer;

    /**
     * @ORM\OneToMany(targetEntity="OrderProduct", mappedBy="order", fetch="LAZY", cascade={"all"})
     *
     * @var ArrayCollection
     */
    private $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return Order
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param int $number
     * @return Order
     */
    public function setNumber($number)
    {
        $this->number = $number;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getIssuedAt()
    {
        return $this->issuedAt;
    }

    /**
     * @param DateTime $issuedAt
     * @return Order
     */
    public function setIssuedAt($issuedAt)
    {
        $this->issuedAt = $issuedAt;
        return $this;
    }

    /**
     * @return float
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @param float $total
     * @return Order
     */
    public function setTotal($total)
    {
        $this->total = $total;
        return $this;
    }

    /**
     * @return Customer
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * @param Customer $customer
     * @return Order
     */
    public function setCustomer(Customer $customer)
    {
        $this->customer = $customer;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * @param Product $product
     * @return Order
     */
    public function addProduct(Product $product)
    {
        $this->products->add($product);
        return $this;
    }

    /**
     * @param Product $product
     * @return Order
     */
    public function removeProduct(Product $product)
    {
        if ($this->products->contains($product)) {
            $this->products->removeElement($product);
        }
        return $this;
    }
}
