<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class User
 *
 * @property User_model $user_model
 */
class User extends AppController
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->library('user_agent');
    }

    public function index()
    {
        show_404();
    }

    public function login()
    {
        if ($this->session->userdata('login'))
            redirect('/');

        parent::validation();
        $this->form_validation->set_error_delimiters('<div class="alert alert-error" style="margin-top:5px;font-size:14px">', '</div>');
        if ($this->input->post() && $this->form_validation->run('login')):
            $this->user_model->key = $this->config->config['encryption_key'];

            $q = $this->user_model->login();
            if (!empty($q->num_rows)):

                $data = array(
                    'user' => $this->input->post('user', TRUE),
                    'uid' => $q->row()->id, 'login' => TRUE,
                    'admin' => $q->row()->admin
                );

                // Update JotunAuth
                \Jotun\JotunAuth::instance()->login($data['uid']);

                $this->session->set_userdata($data);

                redirect('/admincp/dashboard');

            else:
                $this->session->set_flashdata('error', 'Lỗi đăng nhập, thử lại');
            endif;
        endif;

        $this->data['captTime'] = parent::captcha();
        $this->layout = false;
        $this->render('user/login', null, array('back'));
    }

    public function admin_logout()
    {
        $this->session->sess_destroy();
        redirect('/');
    }

    public function admin_edit()
    {
        $this->validation();
        if ($this->input->post() && $this->form_validation->run('userEdit')):
            $this->user_model->key = $this->config->config['encryption_key'];

            if ($this->user_model->edit())
                $this->session->set_flashdata('success', 'Thay đổi mật khẩu thành công');
            else
                $this->session->set_flashdata('error', 'Lổi sql, thử lại');

            redirect('/admincp/dashboard');
        endif;

        $this->data['captTime'] = parent::captcha();
        $this->render('user/admin_edit', null, array('back'));
    }

    public function checkCapt($str)
    {
        if (!$this->captValid($str)):
            $this->form_validation->set_message('checkCapt', 'Sai Captcha, nhập lại');
            return false;
        endif;
        return true;
    }

    public function admin_index()
    {
        $this->render('user/admin_index', null, array('back'));
    }

    public function admin_apiGet()
    {
        $offset = $this->getInput('start');
        $quantity = $this->getInput('length');
        $sortableColumns = [
            'u.id',
            'u.roles',
            'u.user',
            'u.name',
            'u.email'
        ];

        $orders = $this->getInput('order');
        $search = $this->getInput('search');

        $usersQuery = $this->entityManager->createQueryBuilder()
            ->select('u')
            ->from('Entity\User', 'u')
            ->setFirstResult($offset)
            ->setMaxResults($quantity);

        foreach ($orders as $order) {
            $usersQuery->orderBy($sortableColumns[$order['column']], $order['dir']);
        }

        $usersQuery->where('u.user LIKE ?1');
        $usersQuery->orWhere('u.name LIKE ?1');
        $usersQuery->orWhere('u.email LIKE ?1');

        $usersQuery->setParameter('1', '%' . $search['value'] . '%');


        $countQuery = $this->entityManager->createQueryBuilder();
        $countQuery->select('count(u.id)')
            ->from('Entity\User', 'u');
        $countQuery->where('u.user LIKE ?1');
        $countQuery->orWhere('u.name LIKE ?1');
        $countQuery->orWhere('u.email LIKE ?1');

        $countQuery->setParameter('1', '%' . $search['value'] . '%');
        $count = $countQuery->getQuery()->getSingleScalarResult();

        $jsonResponse = [
            'data' => [],
            'recordsTotal' => $count,
            'recordsFiltered' => $count,
        ];
        $users = $usersQuery->getQuery()->getResult();
        /** @var Entity\User $u */
        foreach ($users as $u) {
            $jsonData = [
                $u->getId(),
                $u->getUser(),
                $u->getName(),
                $u->getEmail(),
                $u->getRolesString(),
                $u->hasRole(ROLE_RESELLER) ? '<code class="reseller_code">' . $u->reseller_code . '</code>' : '',
                $this->buildUserControls($u),
            ];

            $jsonResponse['data'][] = $jsonData;
        }

        $this->jsonResponse($jsonResponse);
    }

    public function admin_apiEdit($id)
    {
        $u = $this->entityManager->getRepository('Entity\User')
            ->find($id);
        if ($this->input->server('REQUEST_METHOD') == 'GET') {
            $this->load->view('back/user/form_edit', compact('u'));
        } else {
            $this->updateUser($u);
        }
    }

    public function admin_apiDestroy($id)
    {
        $u = $this->entityManager->getReference('Entity\User', $id);
        $this->entityManager->remove($u);
        $this->jsonResponse(['code' => 0]);
    }

    /**
     * Update an User
     * @param Entity\User|Object $u
     */
    protected function updateUser($u)
    {
        $this->setUserValidation();
        if (!$this->form_validation->run()) {
            $this->jsonResponse([
                'code' => -1,
                'errors' => validation_errors(),
            ], 500);
        } else {
            $u->setUser($this->getInput('username'));

            $password = $this->getInput('password');
            if (strlen($password) > 0) {
                $password = JotunUtils::passwordHash($password);
                $u->setPass($password);
            }
            $u->setName($this->getInput('name'));
            $u->setRoles($this->getInput('roles'));

            if ($u->hasRole(ROLE_RESELLER) && strlen($u->reseller_code) == 0) {
                $u->getResellerCode();
            }

            $this->entityManager->persist($u);
            $this->entityManager->flush($u);

            $this->jsonResponse(['code' => 0]);
        }
    }

    protected function setUserValidation()
    {
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('name', 'Name', 'required');
    }

    /**
     * @param Entity\User $u
     * @return string
     */
    protected function buildUserControls($u)
    {
        $edit = '<button class="edit btn btn-warning control" data-id="'. $u->getId() .'"><i class="icon-edit  icon-white"></i></button>';
        $del = '<button class="delete btn btn-danger control" data-id="'. $u->getId() .'" data-username="' . $u->getUser() . '"><i class="icon-remove  icon-white"></i></button>';
        $reseller = '<button disabled class="reseller btn btn-success control" data-id="'. $u->getId() .'"><i class="fa fa-money"></i></button>';

        if ($u->hasRole(ROLE_RESELLER)) {
            $reseller = '<button class="reseller btn btn-success control" data-id="'. $u->getId() .'"><i class="fa fa-money"></i></button>';
        }
        if ($u->getId() == $this->auth->getUser()->getId()) {
            $del = '<button disabled class="edit btn btn-danger" data-id="'. $u->getId() .'"><i class="icon-remove  icon-white"></i></button>';
        }



        return $edit . $reseller . $del;
    }
}