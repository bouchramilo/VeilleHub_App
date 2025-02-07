<?php
require_once(__DIR__ . '/../models/UserModel.php');
class AuthController extends BaseController
{

    private $UserModel;
    public function __construct()
    {

        $this->UserModel = new User();
    }

    public function showRegister()
    {

        $this->render('auth/register');
    }
    public function showleLogin()
    {

        $this->render('auth/login');
    }

    public function handleRegister()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['signup'])) {
                // echo "<pre>";
                //   var_dump($_POST);die();
                // echo "<pre>";

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
                // else if ($lastInsertId && $role == 'Etudiant') {
                //     //  header('Location: client/dashboard');
                //     echo "vous etes registrer avec succes comme un Etudiant.";
                // }

                exit;
            }
        }
    }


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

    public function logout()
    {


        // if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["logout"])) {
        //  var_dump($_SESSION);die();
        if (isset($_SESSION['user_loged_in_id']) && isset($_SESSION['user_loged_in_role'])) {
            unset($_SESSION['user_loged_in_id']);
            unset($_SESSION['user_loged_in_role']);
            session_destroy();

            header("Location: /home");
            exit;
        }
        //   }
    }
}
