<?php 
namespace Pu\UserBundle\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;
use Pu\UserBundle\Document\User;

/**
* 
*/
class Registration
{
	/**
	 * @Assert\Type(type="Pu\UserBundle\Document\User")
	 */
	protected $user;
	/**
	 * @Assert\NotBlank()
	 */
	protected $termsAccepted;

	/**
	* Get user
	* @return  
	*/
	public function getUser()
	{
	    return $this->user;
	}
	
	/**
	* Set user
	* @return $this
	*/
	public function setUser(User $user)
	{
	    $this->user = $user;
	    return $this;
	}
	/**
	* Get termsAccepted
	* @return  
	*/
	public function getTermsAccepted()
	{
	    return $this->termsAccepted;
	}
	
	/**
	* Set termsAccepted
	* @return $this
	*/
	public function setTermsAccepted($termsAccepted)
	{
	    $this->termsAccepted = (boolean)$termsAccepted;
	    return $this;
	}
}