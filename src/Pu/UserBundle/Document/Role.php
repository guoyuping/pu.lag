<?php 
namespace Pu\UserBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\Role\RoleInterface;
use Pu\UserBundle\Document\User;
/**
 * @MongoDB\Document(collection="roles")
 */
class Role implements RoleInterface
{
    /**
     * @MongoDB\Id()
     */
    protected $id;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $name;

    /**
     * @MongoDB\Field(type="string")
     * @MongoDB\UniqueIndex(order="asc")
     */
    protected $role;
    /**
     * @MongoDB\ReferenceMany(targetDocument="User",mappedBy="roles")
     */
    protected $users = array();

    /**
     * @see RoleInterface
     */
    public function getRole()
    {
        return $this->role;
    }
    public function __construct()
    {
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set name
     *
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get name
     *
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set role
     *
     * @param string $role
     * @return $this
     */
    public function setRole($role)
    {
        $this->role = $role;
        return $this;
    }

    /**
     * Add user
     *
     * @param Pu\UserBundle\Document\User $user
     */
    public function addUser(\Pu\UserBundle\Document\User $user)
    {
        $this->users[] = $user;
    }

    /**
     * Remove user
     *
     * @param Pu\UserBundle\Document\User $user
     */
    public function removeUser(\Pu\UserBundle\Document\User $user)
    {
        $this->users->removeElement($user);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection $users
     */
    public function getUsers()
    {
        return $this->users;
    }
}