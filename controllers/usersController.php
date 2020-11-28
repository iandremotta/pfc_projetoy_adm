<?php

use function PHPSTORM_META\type;

class usersController extends controller
{
    private $user;
    private $userDao;

    public function __construct()
    {
        parent::__construct();
        $this->user = new Users();
        $this->userDao = new usersDao();
        if (!$this->userDao->verifyLogin()) {
            header("Location: " . BASE_URL . "/login");
            exit;
        }
    }

    public function index()
    {

        $data = array(
            'filter' => array('data' => ''),
        );
        if (!empty($_GET['data'])) {
            $data['filter']['data'] = $_GET['data'];
        }

        $data['pag'] = array('currentpage' => 0, 'total' => 0, 'per_page' => 3);
        if (!empty($_GET['p'])) {
            $data['pag']['currentpage'] = intval($_GET['p']) - 1;
        }
        // echo $data['pag']['currentpage'];
        // exit; 

        $data['list'] =  $this->userDao->getAll($data['filter'], $data['pag']);
        $data['pag']['total'] = $this->userDao->getTotal($data['filter']);

        $data['user'] = $this->userDao->findBy();
        $data['quantity'] = $this->userDao->getNewUsers();
        $this->loadTemplate('users', $data);
    }

    public function active($id)
    {
        if (!empty($id)) {
            $this->user->setId($id);
            $this->userDao->activeUser($this->user);
            header("Location:" . BASE_URL . 'users');
        }
    }
    public function inactive($id)
    {
        if (!empty($id)) {

            $this->user->setId($id);
            $this->userDao->inactiveUser($this->user);
            header("Location:" . BASE_URL . 'users');
        }
    }
}
