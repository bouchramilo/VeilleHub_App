<?php
// require_once(__DIR__ . '/../models/UserModel.php');
require_once(__DIR__ . '/../models/SuggestionModel.php');
require_once(__DIR__ . '/../models/PresentationModel.php');
require_once(__DIR__ . '/../models/CalendarModel.php');

use App\Models\MailerModel;

class StudentController extends BaseController
{
    // **********************************************************************************************************************************************************************
    private $SuggestionModel;
    private $TopicModel;
    private $CalendarModel;



    // **********************************************************************************************************************************************************************
    public function __construct()
    {
        $this->SuggestionModel = new Suggestion();
        $this->TopicModel = new Presentation();
        $this->CalendarModel = new Calendar();
    }


    // **********************************************************************************************************************************************************************
    public function index()
    {
        if (!isset($_SESSION['user_loged_in_id'])) {
            header("Location: /login ");
            exit;
        }
        $this->render('student/student');
    }


    // **********************************************************************************************************************************************************************
    public function updateForm()
    {
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            if (isset($_GET['updateForm'])) {
                $id_sugg = $_GET['updateForm'];
                $titre = $_GET['titleForm'];
                $description = $_GET['DescriptionForm'];

                $suggestion = [$id_sugg, $titre, $description];
                $this->render('student/actions/updateSgg', ["suggestion" => $suggestion]);
            }
        }
    }


    // **********************************************************************************************************************************************************************
    public function SaveUpdate()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['btn_update_sugg'])) {
                $id_sugg = $_POST['id_sujet'];
                $titre = $_POST['titre'];
                $description = $_POST['description'];

                $this->SuggestionModel->setIdSujet($id_sugg);
                $this->SuggestionModel->setTitle($titre);
                $this->SuggestionModel->setDescription($description);

                $lastInsertId = $this->SuggestionModel->updateSuggestion();

                if ($lastInsertId) {
                    header('Location: /student/my_suggestions');
                    //   echo "vous aver ajoutez un TOPIC avec succes .";
                }
            }
        }
    }


    // **********************************************************************************************************************************************************************
    public function show_Calendar()
    {
        $calendar = $this->CalendarModel->AllPresentationCalendar();
        $this->render('student/calendar', ["calendarEvents" => $calendar]);
        $this->render('student/calendar');
    }


    // **********************************************************************************************************************************************************************
    public function show_my_suggestions()
    {
        $filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';
        $suggToSearch = isset($_GET['suggToSearch']) ? $_GET['suggToSearch'] : '';

        $suggestions = $this->SuggestionModel->AllSuggestions($filter, $suggToSearch);
        $this->render('student/my_suggestions', ["suggestions" => $suggestions]);
    }


    // **********************************************************************************************************************************************************************
    public function show_Subjects()
    {
        $filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';
        $subToSearch = isset($_GET['subToSearch']) ? $_GET['subToSearch'] : '';

        $subjects = $this->TopicModel->AllPresentaion($filter, $subToSearch);
        $this->render('student/subjects', ["subjects" => $subjects]);
    }


    // **********************************************************************************************************************************************************************
    public function show_Notifications()
    {
        $this->render('student/notifications');
    }


    // **********************************************************************************************************************************************************************
    public function show_Statistiques()
    {
        $statistics = $this->SuggestionModel->getStatistique();
      $this->render('student/statistiques', ["statistics" => $statistics]);
    }


    // **********************************************************************************************************************************************************************
    public function add_Suggestion()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['btn_add_sugg'])) {

                $title = $_POST['titre'];
                $description = $_POST['description'];
                $date = $_POST['date'];

                $this->SuggestionModel->setTitle($title);
                $this->SuggestionModel->setDescription($description);

                $lastInsertId = $this->SuggestionModel->addSuggestion();

                if ($lastInsertId) {
                    header('Location: /student/my_suggestions');
                    //   echo "vous aver ajoutez un TOPIC avec succes .";
                }
            }
        }
    }


    // **********************************************************************************************************************************************************************
    public function delete_Suggestion()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['btn_delete_sugg'])) {

                $id_sugg = $_POST['id_sujets'];

                $this->SuggestionModel->setIdSujet($id_sugg);

                $lastInsertId = $this->SuggestionModel->deleteSuggestion();

                if ($lastInsertId) {
                    header('Location: /student/my_suggestions');
                    //   echo "vous aver ajoutez un TOPIC avec succes .";
                }
            }
        }
    }



    public function envoyerNotification($email, $prenom, $nom)
    {
        $mailer = new MailerModel();

        $sujet = "Notification Importante";
        $message = "Votre présentation est prévue pour le 15 décembre à 14h.";

        $resultat = $mailer->envoyerEmail($email, $prenom, $nom, $sujet, $message);

        if ($resultat === true) {
            echo "Email envoyé avec succès à $email.";
        } else {
            echo "Erreur : " . $resultat;
        }
    }
}
