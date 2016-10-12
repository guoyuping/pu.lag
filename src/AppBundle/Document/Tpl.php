<?php 
namespace AppBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @MongoDB\Document(collection="tpl")
 */
class Tpl 
{
    /**
     * @MongoDB\Id()
     */
    protected $id;
    /**
     * @MongoDB\Field(type="string")
     * @MongoDB\UniqueIndex()
     */
    protected $name;
    /**
     * @MongoDB\Field(type="string")
     */
    protected $description;
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
     * Set description
     *
     * @param string $description
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Get description
     *
     * @return string $description
     */
    public function getDescription()
    {
        return $this->description;
    }
}
