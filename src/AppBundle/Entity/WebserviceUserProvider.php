<?php

namespace AppBundle\Entity;

use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

/**
 * Description of WebserviceUserProvider
 *
 * @author jdsantana
 */
class WebserviceUserProvider implements UserProviderInterface {

    private $container;

    public function __construct($container) {
        $this->container = $container;
    }

    public function loadUserByUsername($username) {
        $username = $this->container->get('request')->get('_username');
        $password = $this->container->get('request')->get('_password');

//        $ws = new \SoapClient();

        $user = $this->container->get('besimple.soap.client.autenticacion')->autenticarUsuario($username, $password, 'uci.cu', true);

        if ($user->Usuario === $username && $user->Autenticado) {
            $roles = array('ROLE_USER');

            return new WebserviceUser($username, $password, '', $roles);
        }

        throw new UsernameNotFoundException(sprintf('Username "%s" does not exist.', $username));
    }

    public function refreshUser(UserInterface $user) {
        if (!$user instanceof WebserviceUser) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', get_class($user)));
        }

        //return $this->loadUserByUsername($user->getUsername());
        return $user;
    }

    public function supportsClass($class) {
        return $class === 'AppBundle\Entity\WebserviceUser';
    }

}

?>