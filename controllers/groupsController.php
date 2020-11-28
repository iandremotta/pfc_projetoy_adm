<?php

use function PHPSTORM_META\type;

class groupsController extends controller
{
    private $user;
    private $userDao;
    private $groups;
    private $groupsDao;

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
        $this->groups = new Groups();
        $this->groupsDao = new GroupsDAO();
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

        $data['list'] =  $this->groupsDao->getAll($data['filter'], $data['pag']);
        $data['pag']['total'] = $this->groupsDao->getTotal($data['filter']);

        $data['user'] = $this->userDao->findBy();
        $data['quantity'] = $this->userDao->getNewUsers();
        $this->loadTemplate('groups', $data);
    }

    public function active($id)
    {
        $this->groups = new Groups();
        $this->groupsDao = new GroupsDAO();
        if (!empty($id)) {
            $this->groups->setId($id);
            $this->groupsDao->activeGroup($this->groups);
            header("Location:" . BASE_URL . 'groups');
        }
    }
    public function inactive($id)
    {
        $this->groups = new Groups();
        $this->groupsDao = new GroupsDAO();

        if (!empty($id)) {
            $this->groups->setId($id);
            $this->groupsDao->inactiveGroup($this->groups);
            header("Location:" . BASE_URL . 'groups');
        }
    }
}
