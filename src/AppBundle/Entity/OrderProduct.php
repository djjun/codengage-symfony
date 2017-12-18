<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OrderProduct
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\OrderProductRepository")
 * @ORM\Table(name="order_products", uniqueConstraints={
 *     @ORM\UniqueConstraint(name="order_product_quantity_unique", columns={"quantity"}),
 *     @ORM\UniqueConstraint(name="order_product_price_unique", columns={"price"}),
 *     @ORM\UniqueConstraint(name="order_product_discount_unique", columns={"discount"}),
 *     @ORM\UniqueConstraint(name="order_product_total_unique", columns={"total"})
 * })
 */
class OrderProduct
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
     * @ORM\Column(name="quantity", type="float")
     *
     * @var float
     */
    private $quantity;

    /**
     * @ORM\Column(name="price", type="decimal", scale=2)
     *
     * @var float
     */
    private $price;

    /**
     * @ORM\Column(name="discount", type="float")
     *
     * @var float
     */
    private $discount;

    /**
     * @ORM\Column(name="total", type="decimal", scale=2)
     *
     * @var float
     */
    private $total;

    /**
     * @ORM\OneToOne(targetEntity="Order", fetch="LAZY", cascade={"all"})
     * @ORM\JoinColumn(name="order_id", referencedColumnName="id")
     *
     * @var Order
     */
    private $order;

    /**
     * @ORM\OneToOne(targetEntity="Product", fetch="LAZY", cascade={"all"})
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     *
     * @var Product
     */
    private $product;

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return OrderProduct
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return float
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param float $quantity
     * @return OrderProduct
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
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
     * @return OrderProduct
     */
    public function setPrice($price)
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return float
     */
    public function getDiscount()
    {
        return $this->discount;
    }

    /**
     * @param float $discount
     * @return OrderProduct
     */
    public function setDiscount($discount)
    {
        $this->discount = $discount;
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
     * @return OrderProduct
     */
    public function setTotal($total)
    {
        $this->total = $total;
        return $this;
    }

    /**
     * @return Order
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param Order $order
     * @return OrderProduct
     */
    public function setOrder(Order $order)
    {
        $this->order = $order;
        return $this;
    }

    /**
     * @return Product
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @param Product $product
     * @return OrderProduct
     */
    public function setProduct(Product $product)
    {
        $this->product = $product;
        return $this;
    }
}
