<?php

use function PHPSTORM_META\type;

class visitorsController extends controller
{
    private $userDao;
    public function __construct()
    {
        parent::__construct();
        $this->user = new Users();
        $this->userDao = new UsersDao();
        if (!$this->userDao->verifyLogin()) {
            header("Location: " . BASE_URL . "/login");
            exit;
        }
    }

    public function index()
    {
        $visitorsDao = new VisitorsDAO();

        $data = array(
            'filter' => array('data' => ''),

        );
        if (!empty($_GET['data'])) {
            $data['filter']['data'] = $_GET['data'];
        }

        $data['pag'] = array('currentpage' => 0, 'total' => 0, 'per_page' => 40);
        if (!empty($_GET['p'])) {
            $data['pag']['currentpage'] = intval($_GET['p']) - 1;
        }
        // echo $data['pag']['currentpage'];
        // exit;

        $data['list'] =  $visitorsDao->getAll($data['filter'], $data['pag']);
        $data['pag']['total'] = $visitorsDao->getTotal($data['filter']);
        $data['user'] = $this->userDao->findBy();
        $data['quantity'] = $this->userDao->getNewUsers();

        // print_r($data['list']);
        // exit;

        $this->loadTemplate('visitors', $data);
    }
}
