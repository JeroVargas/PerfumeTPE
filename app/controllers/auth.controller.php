<?php
require_once 'app/models/user.model.php';
require_once 'app/views/templates/auth.view.php'; // usamos la vista que ya existe

class AuthController{
    private $model;
    private $view;

    public function __construct($res){
        $this->model = new UserModel();
        $this->view = new AuthView();
    }

     public function showLogin($error = null){
        $this->view->showLogin($error);
    }

     public function showRegister($error = null){
        require 'app/views/templates/form_register.phtml';
    }

    public function registerUser(){

        $userEmail = $_POST['email'];
        $userPassword = $_POST['password'];

        if (empty($userEmail) || empty($userPassword)) {
            $this->showRegister("Por favor, complete todos los campos.");
            return; // Detiene la ejecución aquí
        }
        //Verificar si el email ya existe
        $userExistente = $this->model->getUserByEmail($userEmail);

        if ($userExistente){
            $this->showRegister("El correo electrónico ya está en uso. Por favor, elija otro.");
        } else {
            // Si no existe, procedemos a crearlo
            $hash = password_hash($userPassword, PASSWORD_ARGON2ID);
            $this->model->addUser($userEmail, $hash);
            // Y lo enviamos a la página de login para que pueda iniciar sesión
            header('Location: ' . BASE_URL . 'login');
        }
    }

    public function verifyLogin()
    {
        if (!empty($_POST['email']) && !empty($_POST['password'])) {
            $userEmail = $_POST['email'];
            $password = $_POST['password'];

            $user = $this->model->getUserByEmail($userEmail);

            if ($user && password_verify($password, $user->password)) {
                session_start();
                $_SESSION['USER_ID'] = $user->id;
                $_SESSION['USER_EMAIL'] = $user->email;
                $_SESSION['USER_LEVEL'] = $user->level;
                if ($_SESSION['USER_LEVEL'] == 'admin') {
                    header('Location: ' . BASE_URL . 'panel_de_control');
                } else {
                    header('Location: ' . BASE_URL . 'index');
                }
            } else {
                $this->view->showLogin("Usuario o contraseña incorrectos.");
            }
        } else {
            $this->view->showLogin("Usuario o contraseña incorrectos.");
        }
    }

   

}
