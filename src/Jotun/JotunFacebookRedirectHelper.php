<?php namespace Jotun;
use Facebook\FacebookRedirectLoginHelper;

class JotunFacebookRedirectHelper extends FacebookRedirectLoginHelper
{
    /**
     * @return \AppController
     */
    protected function getCI()
    {
        return get_instance();
    }

    protected function storeState($state)
    {
        $this->getCI()->session->set_userdata('state', $state);
    }

    protected function loadState()
    {

        return $this->getCI()->session->userdata('state');
    }
}