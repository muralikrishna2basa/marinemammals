<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Signup
 *
 * @ORM\Table(name="SIGNUP", uniqueConstraints={@ORM\UniqueConstraint(name="signup__login_uk", columns={"LOGIN"}), @ORM\UniqueConstraint(name="signup_confirm_code_uk", columns={"CONFIRM_CODE"}), @ORM\UniqueConstraint(name="signup_email_uk", columns={"EMAIL"})})
 * @ORM\Entity
 */
class Signup
{
    /**
     * @var string
     *
     * @ORM\Column(name="ADDRESS", type="string", length=250, nullable=true)
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="CONFIRM_CODE", type="string", length=40, nullable=true)
     */
    private $confirmCode;

    /**
     * @var integer
     *
     * @ORM\Column(name="CREATED", type="integer", nullable=true)
     */
    private $created;

    /**
     * @var string
     *
     * @ORM\Column(name="EMAIL", type="string", length=50, nullable=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="FIRST_NAME", type="string", length=50, nullable=true)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="LAST_NAME", type="string", length=50, nullable=true)
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="LOGIN", type="string", length=50, nullable=false)
     */
    private $login;

    /**
     * @var string
     *
     * @ORM\Column(name="PASSWORD", type="string", length=50, nullable=false)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="PHONE_NUMBER", type="string", length=20, nullable=true)
     */
    private $phoneNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="SEX", type="string", length=1, nullable=true)
     */
    private $sex;

    /**
     * @var string
     *
     * @ORM\Column(name="TITLE", type="string", length=5, nullable=true)
     */
    private $title;

    /**
     * @var integer
     *
     * @ORM\Column(name="SEQNO", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="SIGNUP_SEQ", allocationSize=1, initialValue=1)
     */
    private $seqno;



    /**
     * Set address
     *
     * @param string $address
     * @return Signup
     */
    public function setAddress($address)
    {
        $this->address = $address;
    
        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set confirmCode
     *
     * @param string $confirmCode
     * @return Signup
     */
    public function setConfirmCode($confirmCode)
    {
        $this->confirmCode = $confirmCode;
    
        return $this;
    }

    /**
     * Get confirmCode
     *
     * @return string 
     */
    public function getConfirmCode()
    {
        return $this->confirmCode;
    }

    /**
     * Set created
     *
     * @param integer $created
     * @return Signup
     */
    public function setCreated($created)
    {
        $this->created = $created;
    
        return $this;
    }

    /**
     * Get created
     *
     * @return integer 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Signup
     */
    public function setEmail($email)
    {
        $this->email = $email;
    
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     * @return Signup
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    
        return $this;
    }

    /**
     * Get firstName
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     * @return Signup
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    
        return $this;
    }

    /**
     * Get lastName
     *
     * @return string 
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set login
     *
     * @param string $login
     * @return Signup
     */
    public function setLogin($login)
    {
        $this->login = $login;
    
        return $this;
    }

    /**
     * Get login
     *
     * @return string 
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return Signup
     */
    public function setPassword($password)
    {
        $this->password = $password;
    
        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set phoneNumber
     *
     * @param string $phoneNumber
     * @return Signup
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    
        return $this;
    }

    /**
     * Get phoneNumber
     *
     * @return string 
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * Set sex
     *
     * @param string $sex
     * @return Signup
     */
    public function setSex($sex)
    {
        $this->sex = $sex;
    
        return $this;
    }

    /**
     * Get sex
     *
     * @return string 
     */
    public function getSex()
    {
        return $this->sex;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Signup
     */
    public function setTitle($title)
    {
        $this->title = $title;
    
        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Get seqno
     *
     * @return integer 
     */
    public function getSeqno()
    {
        return $this->seqno;
    }
}
