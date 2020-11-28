<?php

class homeController extends controller
{

    private $user;
    private $userDao;

    /*
        só deixa o usuário entrar no sistema se estiver logado
    */
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
        $data =  array(
            'filter' => array('data' => ''),
        );
        $visitorsDao = new VisitorsDAO();
        $data['user'] = $this->userDao->findBy();
        $data['quantity'] = $this->userDao->getNewUsers();
        $data['list']  = $visitorsDao->getCountryQuantity();


        $this->loadTemplate('home', $data);
    }
}
