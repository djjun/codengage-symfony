<?php

namespace AppBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * Customer
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CustomerRepository")
 * @ORM\Table(name="customers", uniqueConstraints={
 *     @ORM\UniqueConstraint(name="customer_name_unique", columns={"name"})
 * })
 */
class Customer
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
     * @ORM\Column(name="name", type="string")
     *
     * @var string
     */
    private $name;

    /**
     * @ORM\Column(name="born_at", type="date")
     *
     * @var DateTime
     */
    private $bornAt;

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return Customer
     */
    public function setId($id)
    {
        $this->id = $id;
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
     * @return Customer
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getBornAt()
    {
        return $this->bornAt;
    }

    /**
     * @param DateTime $bornAt
     * @return Customer
     */
    public function setBornAt($bornAt)
    {
        if (is_string($bornAt)) {
            $bornAt = new DateTime($bornAt);
        }

        $this->bornAt = $bornAt;

        return $this;
    }
}
