<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\EntityRepository\UserRepository")
 * @ORM\Table(name="`user`")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @Assert\Length(
     *     min=2,
     *     max=40,
     *     minMessage="Your name is too short.",
     *     maxMessage="Your name seems to be too long."
     * )
     */
    protected $firstName;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @Assert\Length(
     *     min=2,
     *     max=40,
     *     minMessage="Your name is too short.",
     *     maxMessage="Your name seems to be too long."
     * )
     */
    protected $lastName;

    /**
     * @ORM\Column(type="date", nullable=false)
     * @Assert\Date()
     * @Assert\LessThan("-13 years")
     */
    protected $birthday;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\LoginEvent", mappedBy="user")
     */
    protected $logins;

    public function __construct()
    {
        $this->logins = new ArrayCollection();

        parent::__construct();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     *
     * @return $this
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     * @return $this
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * @param \DateTime $birthday
     *
     * @return $this
     */
    public function setBirthday(\DateTime $birthday)
    {
        $this->birthday = $birthday;

        return $this;
    }

    /**
     * Add login
     *
     * @param LoginEvent $login
     *
     * @return User
     */
    public function addLogin(LoginEvent $login)
    {
        $this->logins[] = $login;

        return $this;
    }

    /**
     * Remove login
     *
     * @param LoginEvent $login
     */
    public function removeLogin(LoginEvent $login)
    {
        $this->logins->removeElement($login);
    }

    /**
     * Get logins
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLogins()
    {
        return $this->logins;
    }
}
