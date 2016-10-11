<?php 
namespace AppBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @MongoDB\Document(collection="mod")
 */
class Mod 
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
     * Mod标识符
     * @MongoDB\Field(type="string")
     * @@MongoDB\UniqueIndex(order="asc")
     * 
     */
    protected $uniqueName;
    /**
     * 参数
     * @MongoDB\Field(type="hash",nullable=true)
     */
    protected $param;

    /**
     * 
     * @MongoDB\Field(type="string",nullable=true)
     */
    protected $type;

    /**
     * @MongoDB\Field(type="int")
     */
    protected $status = 0;

    /**
     * @MongoDB\Field(type="boolean")
     */
    protected $isDeleted = false;



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
     * Set param
     *
     * @param hash $param
     * @return $this
     */
    public function setParam($param)
    {
        $this->param = $param;
        return $this;
    }

    /**
     * Get param
     *
     * @return hash $param
     */
    public function getParam()
    {
        return $this->param;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * Get type
     *
     * @return string $type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set status
     *
     * @param int $status
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * Get status
     *
     * @return int $status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set isDeleted
     *
     * @param boolean $isDeleted
     * @return $this
     */
    public function setIsDeleted($isDeleted)
    {
        $this->isDeleted = $isDeleted;
        return $this;
    }

    /**
     * Get isDeleted
     *
     * @return boolean $isDeleted
     */
    public function getIsDeleted()
    {
        return $this->isDeleted;
    }

    /**
     * Set uniqueName
     *
     * @param string $uniqueName
     * @return $this
     */
    public function setUniqueName($uniqueName)
    {
        $this->uniqueName = $uniqueName;
        return $this;
    }

    /**
     * Get uniqueName
     *
     * @return string $uniqueName
     */
    public function getUniqueName()
    {
        return $this->uniqueName;
    }
}
