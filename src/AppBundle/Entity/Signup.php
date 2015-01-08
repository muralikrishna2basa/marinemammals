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
     * @ORM\SequenceGenerator(sequenceName="SIGNUP_SEQNO_seq", allocationSize=1, initialValue=1)
     */
    private $seqno;


}
