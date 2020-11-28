<?php

use function PHPSTORM_META\type;

class loginController extends controller
{

    public function index()
    {
        $data = array(
            'error' => '',
            'nome' => ''
        );

        if (!empty($_SESSION['errorMsg'])) {
            $data['error'] = $_SESSION['errorMsg'];
            $_SESSION['errorMsg'] = '';
        }


        $this->loadView('login', $data);
    }

    public function index_action()
    {
        if (!empty($_POST['email']) && !empty($_POST['pass'])) {
            $email = strtolower($_POST['email']);

            $pass = $_POST['pass'];
            $users = new Users();
            $userDao = new UsersDao();

            $users->setEmail($email);
            $users->setPass($pass);
            if ($userDao->validateUser($users)) {
                header("Location: " . BASE_URL);
                exit;
            } else {
                $_SESSION['errorMsg'] = 'E-mail e/ou senha inválidos';
                header("Location: " . BASE_URL . 'login?error=1');
                exit;
            }
        } else {
            $_SESSION['errorMsg'] = 'Preencha todos os campos';
        }
        header("Location:" . BASE_URL . "login");
        exit;
    }




    public function logout()
    {
        $users = new Users();
        $users->clearLoginHash();

        header("Location: " . BASE_URL . 'login');
    }
}
