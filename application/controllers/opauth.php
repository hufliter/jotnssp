<?php
use Facebook\FacebookRequest;
use Jotun\JotunFacebookRedirectHelper;

class Opauth extends AppController
{
    public function __construct()
    {
        parent::__construct();

        $this->config->load('facebook');

        $appId = $this->config->config['facebook']['app_id'];
        $secret = $this->config->config['facebook']['secret'];
        \Facebook\FacebookSession::setDefaultApplication($appId, $secret);
    }

    public function facebook()
    {
        if ($this->auth->check()) {
            $this->redirectAfterLogin();
        } else {
            $helper = new JotunFacebookRedirectHelper(base_url() . 'opauth/facebook');
            try {
                $session = $helper->getSessionFromRedirect();
            } catch (\Facebook\FacebookRequestException $e) {
                redirect('opauth/facebook');
                exit();
            }

            if (isset($session)) {
                $request = new FacebookRequest($session, 'GET', '/me');
                $response = $request->execute();
                $graphObj = $response->getGraphObject();

                $this->auth->loginViaFacebook($graphObj);
                $this->redirectAfterLogin();
            } else {
                redirect($helper->getLoginUrl(['email']));
            }
        }
    }

    public function logout()
    {
        $this->auth->logout();
        redirect('/');
    }

    protected function redirectAfterLogin()
    {
        $url = $this->session->userdata('redirect_after_login');
        $this->session->set_flashdata('login_success', 'Đăng nhập thành công!');
        if (false === $url) {
            $url = '/';
        }

        redirect($url);
    }
}