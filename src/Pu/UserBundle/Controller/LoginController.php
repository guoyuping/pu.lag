<?php

namespace Pu\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
class LoginController extends Controller
{
    public function loginAction(Request $request)
    {

        $session = $request->getSession();
        
        // get the login error if there is one
        if ($request->attributes->has(Security::AUTHENTICATION_ERROR)) 
        {
            $error = $request->attributes->get(
                Security::AUTHENTICATION_ERROR
            );
        } 
        elseif (null !== $session && $session->has(Security::AUTHENTICATION_ERROR)) 
        {
            $error = $session->get(Security::AUTHENTICATION_ERROR);
            $session->remove(Security::AUTHENTICATION_ERROR);
        } 
        else 
        {
            $error = '';
        }

        // last username entered by the user
        $lastUsername = (null === $session) ? '' : $session->get(Security::LAST_USERNAME);

        return $this->render(
            'PuUserBundle:Login:login.html.twig',
            array(
                // last username entered by the user
                'last_username' => $lastUsername,
                'error'         => $error,
            )
        );
    }
    /**
     * login_check
     * @param Request $request
     * @return Response
     */
    public function securityCheckAction(Request $request) 
    {
        $username = $request->get('_username');
        $raw_password = $request->get('_password');
        $is_remember_me = $request->get('_remember_me');
        //firewall name
        $firewall = 'admin';
        $session = $request->getSession();
        $lastUsername = (null === $session) ? '' : $session->get(Security::LAST_USERNAME);
        if(!$user = $this->getUserInterface($username))
        {
            if($request->isXmlHttpRequest()){
                $array = array( 'success' => false, 'message' => "用户不存在！" ); // data to return via JSON
                $response = new Response( json_encode( $array ) );
                $response->headers->set( 'Content-Type', 'application/json' );

                return $response;
            }else{
                $error = new \Symfony\Component\Form\FormError('用户不存在！');
                return $this->render(
                    'LagBundlesAdminBaseBundle:Login:login.html.twig',
                    array(
                        // last username entered by the user
                        'last_username' => $lastUsername,
                        'error'         => $error,
                    )
                );
            }
        }
        if(!$this->checkCredentials($user, $raw_password))
        {
            if($request->isXmlHttpRequest())
            {
                $array = array( 'success' => false, 'message' => "用户名或密码错误！" ); // data to return via JSON
                $response = new Response( json_encode( $array ) );
                $response->headers->set( 'Content-Type', 'application/json' );
                return $response;
            }
            else
            {
                $error = new \Symfony\Component\Form\FormError('用户名或密码错误！');
                return $this->render(
                    'LagBundlesAdminBaseBundle:Login:login.html.twig',
                    array(
                        // last username entered by the user
                        'last_username' => $lastUsername,
                        'error'         => $error,
                    )
                );
            }
            
        }
        // Check if credentials have expired
        $this->container->get('security.user_checker.admin')->checkPostAuth($user);
        
        $token = $this->setToken($user, $firewall);
        $session = $this->setSession($token, $firewall);
        $this->setCookie($request,$is_remember_me, $session);
        if($request->isXmlHttpRequest())
        {
            $array = array( 'success' => true ); // data to return via JSON
            $response = new Response( json_encode( $array ) );
            $response->headers->set( 'Content-Type', 'application/json' );
            return $response;
        }
        return $this->redirectToRoute('lag_bundles_admin_dashboard_homepage');
    }
    /**
     * 检查密码
     * @param UserInterface $user
     * @param type $credentials
     * @return boolean
     */
    private function checkCredentials(UserInterface $user, $credentials) 
    {
        $encoder = $this->container->get('security.password_encoder');
        if($encoder->isPasswordValid($user, $credentials))
        {
            return true;
        }
        return false;
    }
    /**
     * 设置cookie
     * @param Request $request
     * @param type $is_remember_me
     * @param type $session
     */
    private function setCookie(Request $request,$is_remember_me,  \Symfony\Component\HttpFoundation\Session\Session $session) 
    {
        if($is_remember_me)
        {
            $cookie = $request->cookies->get('stream');
            if(!isset($cookie) || $cookie == 0)
            {
                $response = new \Symfony\Component\HttpFoundation\Response();
                $response->headers->setCookie(new cookie($session->getName(), $session->getId(),\time()+86400));
                $response->sendHeaders();
            }
        }
    }
    /**
     * 设置security token
     * @param UserInterface $user
     * @param type $firewall
     * @return UsernamePasswordToken
     */
    private function setToken(UserInterface $user, $firewall) 
    {
        $securityContext = $this->get('security.token_storage');
        $token = new UsernamePasswordToken($user,null,$firewall,$user->getRoles());
        $securityContext->setToken($token);
        return $token;
    }
    /**
     * 设置session
     * @param type $token
     * @param type $firewall
     * @return type
     */
    private function setSession($token, $firewall) 
    {
        $session = $this->get('session');
        $session->set('_security_'.$firewall, serialize($token));
        $session->save();
        return $session;
    }
    /**
     * 获取ser，可以通过电邮或用户名
     * @param $username
     * @return UserInterface
     */
    public function getUserInterface($username)
    {
        $dm = $this->get('doctrine_mongodb')->getManager();
        //if(filter_var($username, FILTER_VALIDATE_EMAIL))
        $user = $dm->getRepository('PuUserBundle:User')->findOneByUsername($username);
        return $user;
    }
}
