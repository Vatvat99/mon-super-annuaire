<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="contact", options={"collate"="utf8mb4_unicode_ci", "charset"="utf8mb4"})
 */
class Contact
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $lastname;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=14)
     * @Assert\NotBlank()
     * @Assert\Regex(
     *     pattern="/^0[1-9]( [0-9]{2}){4}$/",
     *     message="Cette valeur doit être un numéro de téléphone valide (ex. 01 23 45 67 89)"
     * )
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="mobile_phone", type="string", length=14)
     * @Assert\NotBlank()
     * @Assert\Regex(
     *     pattern="/^0[1-9]( [0-9]{2}){4}$/",
     *     message="Cette valeur doit être un numéro de téléphone valide (ex. 01 23 45 67 89)"
     * )
     */
    private $mobilePhone;

    /**
     * @var string
     *
     * @ORM\Column(name="county", type="string", length=3)
     * @Assert\NotBlank()
     */
    private $county;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     *
     * @return Contact
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     *
     * @return Contact
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return Contact
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set mobilePhone
     *
     * @param string $mobilePhone
     *
     * @return Contact
     */
    public function setMobilePhone($mobilePhone)
    {
        $this->mobilePhone = $mobilePhone;

        return $this;
    }

    /**
     * Get mobilePhone
     *
     * @return string
     */
    public function getMobilePhone()
    {
        return $this->mobilePhone;
    }


    /**
     * Set county
     *
     * @param string $county
     *
     * @return Contact
     */
    public function setCounty($county)
    {
        $this->county = $county;

        return $this;
    }

    /**
     * Get county
     *
     * @return string
     */
    public function getCounty()
    {
        return $this->county;
    }

}
