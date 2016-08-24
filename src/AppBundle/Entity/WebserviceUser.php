<?php

namespace AppBundle\Entity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Description of WebserviceUser
 *
 * @author jdsantana
 */
class WebserviceUser implements UserInterface, \Serializable {

    private $username;
    private $password;
    private $salt;
    private $roles;

    public function __construct($username, $password, $salt, array $roles) {
        $this->username = $username;
        $this->password = $password;
        $this->salt = $salt;
        $this->roles = $roles;
    }

    public function getRoles() {
        return $this->roles;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getSalt() {
        return '';
    }

    public function getUsername() {
        return $this->username;
    }

    public function eraseCredentials() {

    }

    public function equals(UserInterface $user) {
        if (!$user instanceof WebserviceUser) {
            return false;
        }

        if ($this->password !== $user->getPassword()) {
            return false;
        }

        if ($this->getSalt() !== $user->getSalt()) {
            return false;
        }

        if ($this->username !== $user->getUsername()) {
            return false;
        }

        return true;
    }

    public function serialize() {
        return serialize(array(
            $this->username,
            $this->password,
            $this->salt
        ));
    }

    public function unserialize($serialized) {
        list(
            $this->username,
            $this->password,
            $this->salt) = unserialize($serialized);
    }

}

?>