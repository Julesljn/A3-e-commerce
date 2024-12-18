<?php

namespace App\Controllers;

use App\Models\User;
use App\Repositories\UserRepository;

class UserController extends BaseController
{
    private UserRepository $userRepository;

    public function __construct()
    {
        parent::__construct();
        $this->userRepository = new UserRepository();
    }

    public function showRegisterPage(): void
    {
        $this->render('register.twig');
    }

    public function handleRegister(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

            $user = new User($firstname, $lastname, $email, $phone);

            $existingUser = $this->userRepository->findByEmail($email);
            if ($existingUser) {
                die('Erreur : cet email est déjà utilisé.');
            }

            $this->userRepository->createUser($user, $password);
            echo 'Compte créé avec succès !';
        }
    }

    public function showLoginPage(): void
    {
        $this->render('login.twig');
    }

    public function handleLogin(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $user = $this->userRepository->findByEmail($email);
            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['userId'] = $user['id'];
                $_SESSION['firstname'] = $user['firstname'];
                echo 'Connexion réussie ! Bienvenue ' . $user['firstname'];
            } else {
                die('Erreur : Email ou mot de passe incorrect.');
            }
            
        }
    }
}
