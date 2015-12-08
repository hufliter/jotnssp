<?php namespace Jotun;

use Doctrine\ORM\EntityManager;
use Entity\User;
use Facebook\GraphObject;

class JotunAuth
{
    protected $ci;

    /** @var  EntityManager */
    protected $entityManager;
    protected static $instance;

    const SESS_PREFIX = 'jotun_auth_';
    protected function __construct()
    {
        $this->entityManager = \Doctrine::getEntityManager();
    }

    /**
     * @return \AppController
     */
    protected function getCI()
    {
        if (!$this->ci) {
            $this->ci = &get_instance();
        }

        return $this->ci;
    }

    protected function getUserId()
    {
        return $this->getCI()->session->userdata(static::SESS_PREFIX  . 'user_id');
    }

    public function check()
    {
        return $this->getCI()->session->userdata(static::SESS_PREFIX . 'user_id') != false;
    }

    public function login($id)
    {
        $this->getCI()->session->set_userdata(static::SESS_PREFIX  . 'user_id', $id);
    }

    /**
     * @return static
     */
    public static function instance()
    {
        if (!static::$instance) {
            static::$instance = new static;
        }

        return static::$instance;
    }

    /**
     * Get logged-in user
     *
     * @return null|User
     */
    public function getUser()
    {
        $userId = $this->getUserId();
        return \Doctrine::getEntityManager()->getRepository('Entity\User')
            ->find($userId);
    }

    public function logout()
    {
        $this->getCI()->session->unset_userdata(static::SESS_PREFIX  . 'user_id');
    }

    public function loginViaFacebook(GraphObject $object)
    {
        $user = $this->entityManager->getRepository('Entity\User')
            ->findOneBy(['fb_user_id' => $object->getProperty('id')]);
        if (!$user) {
            // Create new user via Facebook
            $user = new User();
            $user->fb_user_id = $object->getProperty('id');
            $user->setName($object->getProperty('name'));
            $user->setEmail($object->getProperty('email'));
            $user->setAdmin(false);
            $user->setUser('fb_' . $object->getProperty('id'));
            $user->setDate(new \DateTime());
            $user->setDelete(false);
            $user->setPass('~');
            $user->setRoles(ROLE_USER);

            $this->entityManager->persist($user);
            $this->entityManager->flush();
        }

        $this->getCI()->session->set_userdata(static::SESS_PREFIX  . 'user_id', $user->getId());
    }

    public function hasRole($role)
    {
        return $this->check() && $this->getUser()->hasRole($role);
    }
}