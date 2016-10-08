<?php 
namespace Pu\UserBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Doctrine\Bundle\MongoDBBundle\Validator\Constraints\Unique as MongoDBUnique;

/**
 * @MongoDB\Document(collection="users")
 * @MongoDBUnique(fields="email")
 */
class User implements AdvancedUserInterface, \serializable
{
    /**
     * @MongoDB\Id()
     */
    protected $id;
    /**
     * @MongoDB\Field(type="string")
     * @MongoDb\UniqueIndex(order="asc")
     */
    protected $username;
    /**
     * @MongoDB\Field(type="string")
     * @Assert\NotBlank()
     */
    protected $password;
    /**
     * @MongoDB\ReferenceMany(targetDocument="Role", inversedBy="users", storeAs="dbRef")
     */
    protected $roles = array();
    /**
     * @MongoDB\Field(type="string",nullable=true)
     */
    protected $salt;
    /**
     * @MongoDB\Field(type="boolean")
     */
    protected $isActive;
    /**
     * @MongoDB\Field(type="timestamp")
     */
    protected $createdAt;

    /**
     * @inheritDoc
     */
    public function getUsername()
    {
        return $this->username;
    }
    /**
     * @inheritDoc
     */
    public function getSalt()
    {
        // you *may* need a real salt depending on your encoder
        // see section on salt below
        return $this->salt;
    }

    /**
     * @inheritDoc
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @inheritDoc
     */
    public function getRoles()
    {
        //return array('ROLE_USER');
        return $this->roles->toArray();
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {
    }
    
    /**
     * @see \Serializable::serialize()
     */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            $this->salt,
        ));
    }

    /**
     * @see \Serializable::unserialize()
     */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            $this->salt
        ) = unserialize($serialized);
    }
    public function isAccountNonExpired()
    {
        return true;
    }

    public function isAccountNonLocked()
    {
        return true;
    }

    public function isCredentialsNonExpired()
    {
        return true;
    }

    public function isEnabled()
    {
        return $this->isActive;
    }

    public function __construct()
    {
        $this->roles = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Get id
     *
     * @return id $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return $this
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * Add role
     *
     * @param Pu\UserBundle\Document\Role $role
     */
    public function addRole(\Pu\UserBundle\Document\Role $role)
    {
        $this->roles[] = $role;
    }

    /**
     * Remove role
     *
     * @param Pu\UserBundle\Document\Role $role
     */
    public function removeRole(\Pu\UserBundle\Document\Role $role)
    {
        $this->roles->removeElement($role);
    }

    /**
     * Set salt
     *
     * @param string $salt
     * @return $this
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
        return $this;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return $this
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean $isActive
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set createdAt
     *
     * @param timestamp $createdAt
     * @return $this
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * Get createdAt
     *
     * @return timestamp $createdAt
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set username
     *
     * @param string $username
     * @return $this
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }
}
