<?php 
namespace Pu\ModBundle\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;
use Pu\ModBundle\Document\Mod;

/**
* 
*/
class Moudle 
{
	/**
	 * @Assert\Type(type="Pu\ModBundle\Document\Mod")
	 */
	private $mod;
	/**
	 * 
	 */
	private $params;

	/**
	* Get mod
	* @return  
	*/
	public function getMod()
	{
	    return $this->mod;
	}
	
	/**
	* Set mod
	* @return $this
	*/
	public function setMod($mod)
	{
	    $this->mod = $mod;
	    return $this;
	}
	/**
	* Get params
	* @return  
	*/
	public function getParams()
	{
	    return $this->params;
	}
	
	/**
	* Set params
	* @return $this
	*/
	public function setParams($params)
	{
	    $this->params = $params;
	    return $this;
	}
}