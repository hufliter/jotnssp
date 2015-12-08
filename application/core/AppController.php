<?php
/**
 * @author nam J
 * @authorurl ngonam22
 * @copyright 2013
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Class AppController
 *
 * @property CI_DB_active_record $db              This is the platform-independent base Active Record implementation class.
 * @property CI_DB_forge $dbforge                 Database Utility Class
 * @property CI_Benchmark $benchmark              This class enables you to mark points and calculate the time difference between them.<br />  Memory consumption can also be displayed.
 * @property CI_Calendar $calendar                This class enables the creation of calendars
 * @property CI_Cart $cart                        Shopping Cart Class
 * @property CI_Config $config                    This class contains functions that enable config files to be managed
 * @property CI_Controller $controller            This class object is the super class that every library in.<br />CodeIgniter will be assigned to.
 * @property CI_Email $email                      Permits email to be sent using Mail, Sendmail, or SMTP.
 * @property CI_Encrypt $encrypt                  Provides two-way keyed encoding using XOR Hashing and Mcrypt
 * @property CI_Exceptions $exceptions            Exceptions Class
 * @property CI_Form_validation $form_validation  Form Validation Class
 * @property CI_Ftp $ftp                          FTP Class
 * @property CI_Hooks $hooks                      //dead
 * @property CI_Image_lib $image_lib              Image Manipulation class
 * @property CI_Input $input                      Pre-processes global input data for security
 * @property CI_Lang $lang                        Language Class
 * @property CI_Loader $load                      Loads views and files
 * @property CI_Log $log                          Logging Class
 * @property CI_Model $model                      CodeIgniter Model Class
 * @property CI_Output $output                    Responsible for sending final output to browser
 * @property CI_Pagination $pagination            Pagination Class
 * @property CI_Parser $parser                    Parses pseudo-variables contained in the specified template view,<br />replacing them with the data in the second param
 * @property CI_Profiler $profiler                This class enables you to display benchmark, query, and other data<br />in order to help with debugging and optimization.
 * @property CI_Router $router                    Parses URIs and determines routing
 * @property CI_Session $session                  Session Class
 * @property CI_Sha1 $sha1                        Provides 160 bit hashing using The Secure Hash Algorithm
 * @property CI_Table $table                      HTML table generation<br />Lets you create tables manually or from database result objects, or arrays.
 * @property CI_Trackback $trackback              Trackback Sending/Receiving Class
 * @property CI_Typography $typography            Typography Class
 * @property CI_Unit_test $unit_test              Simple testing class
 * @property CI_Upload $upload                    File Uploading Class
 * @property CI_URI $uri                          Parses URIs and determines routing
 * @property CI_User_agent $user_agent            Identifies the platform, browser, robot, or mobile devise of the browsing agent
 * @property CI_Xmlrpc $xmlrpc                    XML-RPC request handler class
 * @property CI_Xmlrpcs $xmlrpcs                  XML-RPC server class
 * @property CI_Zip $zip                          Zip Compression Class
 * @property CI_Javascript $javascript            Javascript Class
 * @property CI_Jquery $jquery                    Jquery Class
 * @property CI_Utf8 $utf8                        Provides support for UTF-8 environments
 * @property CI_Security $security                Security Class, xss, csrf, etc...
 * @property CI_Driver_Library $driver            CodeIgniter Driver Library Class
 * @property CI_Cache $cache                      CodeIgniter Caching Class
 */
class AppController extends CI_Controller
{
    protected $entityManager;

    /** @var Jotun\JotunAuth */
    protected $auth;

    protected $inputData = [];
    public $data = array();
    public $layout = 'back/layout';
    public $paginate = array(
        'per_page' => 21, 'uri_segment' => 4, 'num_links' => 3,
        'full_tag_open' => '<div class="pagination span12"><ul>',
        'full_tag_close' => '</ul></div>',
        'first_link' => 'Trang đầu', 'last_link' => 'Trang cuối',
        'first_tag_open' => '<li class="first">',
        'first_tag_close' => '</li>',
        'last_tag_open' => '<li class="last">',
        'last_tag_close' => '</li>',
        'next_tag_open' => '<li class="next round">',
        'next_tag_close' => '</li>',
        'prev_tag_open' => '<li class="prev round">',
        'prev_tag_close' => '</li>',
        'cur_tag_open' => '<li class="active"><a href="#"">',
        'cur_tag_close' => '</a></li>',
        'num_tag_open' => '<li>',
        'num_tag_close' => '</li>'
    );

    public function __construct()
    {
        parent::__construct();

        // Doctrine Entity Manager
        $this->entityManager = Doctrine::getEntityManager();
        $this->auth = Jotun\JotunAuth::instance();
        $this->load->library('form_validation');

//$this->load->view('offline');
//exit($this->output->get_output());
        $this->load->library('site', array('x' => $this));
        $this->load->model('dashboard_model');
        $this->cache->x = $this;

        $this->data['orderStatus'] = array(
            0 => 'Cancel by system', 1 => 'Success',
            2 => 'Waiting', 4 => 'Delay', 8 => 'Cancel by admin',
        );

        $this->data['bs_modal'] = $this->load->view('shared/bootstrap_modal', null, true);

        $this->inputData = array_merge($_GET, $_POST);
    }

    public function isAjax()
    {
        if ($this->input->is_ajax_request()):
            $this->layout = false;
            $this->data['ajax'] = true;
        endif;
    }

    public function paginate($table = null, $field = '*', $uri = 4, $base_url = null)
    {
        if (empty($table))
            return false;

        $this->load->library('pagination');
        $this->load->model('pagination_model');

        $this->pagination_model->table = $table;
        $this->pagination_model->field = $field;

        $this->paginate['uri_segment'] = $uri;
        $this->paginate['base_url'] = base_url($base_url);
    }

    public function _remap($method, $params = array())
    {
        // replace "-" in method
        $method = str_replace('-', '_', $method);
        if (strpos($method, 'admin_') === 0):
            if ($this->uri->segment(1) == 'admincp')
                $this->isLogin();
            else
                show_404();
        else:
            $this->front();
        endif;

        if (method_exists($this, $method))
            return call_user_func_array(array($this, $method), $params);
        return show_404();
    }

    public function front()
    {
        $this->load->library('user_agent');
        $this->load->helper('cookie');

        $this->data = array_merge($this->data, $this->site->back('config'));
        $this->data = array_merge($this->data, $this->site->back('lastNews'));
        $this->data = array_merge($this->data, $this->site->back('category'));
        $this->data = array_merge($this->data, $this->site->back('mainAds'));
        $this->data['ads_under_search'] = $this->dashboard_model->ads_find('under_search', false);
        $this->data['checkAuth'] = !\Jotun\JotunAuth::instance()->check();
        $this->data['numberCart'] = 0;
        if ($this->session->userdata('cart'))
            $this->data['numberCart'] = count($this->session->userdata('cart'));
        $ads_close = get_cookie('ads_close');
        if (!$ads_close)
            $this->data['ads_bottom'] = $this->dashboard_model->ads_find('bottom', false);

        //$loaded = get_cookie('loaded',TRUE);

        if ($this->uri->uri_string == 'user/login'):

        elseif (!$this->data['config']->status):
            $this->load->view('front/maintain', $this->data);
            exit($this->output->get_output());

            //elseif($this->uri->uri_string == 'page/loadding' || $this->uri->uri_string == 'page'):
            //elseif(!$loaded && !$this->agent->is_robot() && !$this->agent->mobile() && $this->agent->browser()):
            //	redirect('/page/loadding');
        endif;

        $this->layout = 'front/layout';

        $this->paginate['full_tag_open'] = '<div class="pagination row-fluid"><div class="span11 text-right"><ul>';
        $this->paginate['full_tag_close'] = '</ul></div></div>';
        $this->paginate['next_link'] = '';
        $this->paginate['prev_link'] = '';
    }

    public function isLogin()
    {
        if (!$this->session->userdata('login'))
            redirect('/user/login');
        else
            if ($this->session->userdata('admin'))
                return true;
        exit(show_404());
    }

    public function isAdmin()
    {
        //TODO: fix check admin permission
    }

    public function validation()
    {
        $CI =& get_instance();
        $this->load->library('form_validation');

        $this->form_validation->set_message('is_natural_no_zero', '%s must not null');
        $this->form_validation->set_error_delimiters('<p><small class="text-error">', '</small></p>');
    }

    public function captcha()
    {
        $this->load->helper('captcha');
        $conf = array(
            'word' => substr(strtolower(md5(time())), 0, 4),
            'img_path' => './assets/images/captcha/',
            'img_url' => base_url() . 'assets/images/captcha/',
            'font_path' => './assets/font/monofont.ttf',
            'img_width' => '110',
            'img_height' => '40',
            'expiration' => 60
        );

        $cap = create_captcha($conf);
        $this->session->set_userdata(array('captcha' => $cap['word']));
        return $cap['time'];
    }

    public function captValid($str = null)
    {
        if (empty($str) || $this->session->userdata('captcha') == false)
            return false;

        $capt = $this->session->userdata('captcha');
        $this->session->unset_userdata('captcha');
        if (strcmp($capt, $str) == 0)
            return true;
        return false;
    }

    public function render($temp = null, $js = null, $css = null, $cache = 0)
    {
        if (!empty($css) && is_array($css))
            $this->data['css'] = $css;

        if (!empty($js) && is_array($js))
            $this->data['js'] = $js;

        if (!empty($this->layout)):
            if (!empty($temp) && is_string($temp))
                $this->data['temp'] = $this->load->view($temp, $this->data, true);
            else
                $this->data['temp'] = null;
            $this->load->view($this->layout, $this->data);
        else:
            $this->load->view($temp, $this->data);
        endif;
    }

    public function getInput($key, $default = null)
    {
        if (array_key_exists($key, $this->inputData)) {
            return $this->inputData[$key];
        } else {
            return $default;
        }

    }

    /**
     * Set header text/json & encode data
     *
     * @param string|array $data
     * @param int $code
     */
    public function jsonResponse($data, $code = 200)
    {
        http_response_code($code);
        header('Content-Type: text/json');
        echo is_array($data) ? json_encode($data) : $data;
    }
}