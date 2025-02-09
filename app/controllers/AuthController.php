<?php

use App\Models\MailerModel;

require_once(__DIR__ . '/../models/UserModel.php');
require_once(__DIR__ . '/../models/MailerModel.php');

class AuthController extends BaseController
{

    // **********************************************************************************************************************************************************************
    private $UserModel;
    private $mailModel;


    // **********************************************************************************************************************************************************************
    public function __construct()
    {

        $this->UserModel = new User();
        $this->mailModel = new MailerModel();
    }


    // **********************************************************************************************************************************************************************
    public function showRegister()
    {
        $this->render('auth/register');
    }


    // **********************************************************************************************************************************************************************
    public function showleLogin()
    {
        $this->render('auth/login');
    }


    // **********************************************************************************************************************************************************************
    public function forgotPassword()
    {
        $this->render('auth/forgotPassword');
    }


    // **********************************************************************************************************************************************************************
    public function initialPsswd()
    {
        $this->render('auth/initialPsswd');
    }


    // **********************************************************************************************************************************************************************
    public function handleRegister()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['signup'])) {

                $first_name = $_POST['nom'];
                $last_name = $_POST['prenom'];
                $email = $_POST['email'];
                $role = $_POST['role'];
                $password = $_POST['password'];
                $password2 = $_POST['password2'];
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                $user = [$first_name, $last_name, $hashed_password, $email, $role];

                $lastInsertId = $this->UserModel->register($user);

                $_SESSION['user_loged_in_id'] = $lastInsertId;
                $_SESSION['user_loged_in_role'] = $role;

                if ($lastInsertId) {
                    header('Location: /login');
                    // echo "vous etes registrer avec succes comme un Enseignant.";
                }
            }
        }
    }


    // **********************************************************************************************************************************************************************
    public function resetPassword()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['forgotPsswd'])) {
                $email = $_POST['email'];

                $user = $this->UserModel->getIdByemail($email);

                if ($user) {
                    $token = bin2hex(random_bytes(16));
                    $expiry = date("Y-m-d H:i:s", strtotime("+1 hour"));

                    $res = $this->UserModel->addToken($email, $token, $expiry);

                    if ($res) {
                        $resetLink = "http://localhost:8000/initialPsswd?token=$token";
                        $sujet = "Réinitialisation de mot de passe";
                        $body = "<p>Bonjour,</p>  
                                 <p>Cliquez sur ce lien pour réinitialiser votre mot de passe : <a href='$resetLink'>Click ici</a></p>  
                                 <p>Cordialement,<br>  
                                 <strong>VeilleHub</strong></p>";

                        $this->mailModel->envoyerEmail($email, "", "", $sujet, $body);

                        header("Location: /forgotPassword");
                    }
                }
            }
        }
    }


    // **********************************************************************************************************************************************************************
    public function restartPsswd()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['resetpsswd'])) {
                // $email = $_POST['email'];
                $token = $_POST['token'];

                $res = $this->UserModel->getEmailByToken($token);

                $password = $_POST['password'];
                $password2 = $_POST['password2'];

                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $userData = [$res->email, $hashed_password];
                // var_dump($userData);
                $user = $this->UserModel->restartPassword($userData);

                if ($user) {
                    $user = $this->UserModel->deleteToken($res->email);

                    header('Location: /login');
                    // echo "vous etes connecter avec succes comme un Enseignant.";
                } else {
                    header('Location: /initialPsswd');
                    // echo "vous etes connecter avec succes comme un Etudiant.";
                }
            }
        }
    }


    // **********************************************************************************************************************************************************************
    public function handleLogin()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['login'])) {
                $email = $_POST['email'];
                $password = $_POST['password'];
                $userData = [$email, $password];
                // var_dump($userData);
                $user = $this->UserModel->login($userData);
                $role = $user['role'];
                // var_dump($user);die();
                $_SESSION['user_loged_in_id'] = $user["id_user"];
                $_SESSION['user_loged_in_role'] = $role;
                $_SESSION['user_loged_in_nome'] = $user['nom'];

                if ($user && $role == 'Enseignant') {
                    header('Location: /teacher/statistiques');
                    // echo "vous etes connecter avec succes comme un Enseignant.";
                } else if ($user && $role == 'Etudiant') {
                    header('Location: /student/calendar');
                    // echo "vous etes connecter avec succes comme un Etudiant.";
                }
            }
        }
    }


    // **********************************************************************************************************************************************************************
    public function logout()
    {
        if (isset($_SESSION['user_loged_in_id']) && isset($_SESSION['user_loged_in_role'])) {
            unset($_SESSION['user_loged_in_id']);
            unset($_SESSION['user_loged_in_role']);
            session_destroy();

            header("Location: /home");
            exit;
        }
    }
}
