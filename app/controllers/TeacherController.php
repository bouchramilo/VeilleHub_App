<?php

use App\Models\MailerModel;

require_once(__DIR__ . '/../models/UserModel.php');
require_once(__DIR__ . '/../models/PresentationModel.php');
require_once(__DIR__ . '/../models/SuggestionModel.php');
require_once(__DIR__ . '/../models/CalendarModel.php');
require_once(__DIR__ . '/../models/MailerModel.php');

class TeacherController extends BaseController
{
   // *****************************************************************************************************************************************
   private $UserModel;
   private $TopicModel;
   private $suggModel;
   private $CalendarModel;
   private $mailModel;


   // *****************************************************************************************************************************************
   public function __construct()
   {
      $this->UserModel = new User();
      $this->TopicModel = new Presentation();
      $this->suggModel = new Suggestion();
      $this->CalendarModel = new Calendar();
      $this->mailModel = new MailerModel();
   }


   // *****************************************************************************************************************************************
   public function showCalendar()
   {
      $calendar = $this->CalendarModel->AllPresentationCalendar();
      $students = $this->UserModel->getAllStudent();
      $presentations = $this->TopicModel->getAllpresentations();

      // var_dump($presentations);


      $this->renderDashboard('teacher/calendar', ["calendarEvents" => $calendar, "students" => $students, "presentations" => $presentations]);
   }


   // *****************************************************************************************************************************************
   public function addToCalendar()
   {
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
         if (isset($_POST['addToCalendrier'])) {
            $title = $_POST['titre'];
            $students = $_POST['students'] ?? [];
            $date = $_POST['date'];

            if (empty($title) || empty($students) || empty($date)) {
               die("Erreur : Tous les champs doivent être remplis !");
            }

            $this->CalendarModel->setIdPresentation($title);
            $this->CalendarModel->setDateEvent($date);


            foreach ($students as $student) {
               $this->CalendarModel->setIdStudent($student);
               $lastInsertId = $this->CalendarModel->addToCalendar();

               $student = $this->UserModel->getUserById($student);
               $email = $student->email;
               $nom = $student->nom;
               $prenom = $student->prenom;
               $sujet = "Nouvelle présentation assignée";
               $message = "Un enseignant a été assigné à une nouvelle présentation intitulée \"$title\", prévue pour le $date.";
               $body = "<p>Bonjour <strong>$prenom $nom</strong>,<br></p><p>$message</p><br><p>Cordialement, VeilleHub.</p>";

               $this->mailModel->envoyerEmail($email, $nom, $prenom, $sujet, $body);
            }

            header('Location: /teacher/calendar');
         }
      }
   }






   // *****************************************************************************************************************************************
   public function showStudents()
   {
      // Get filter and search values from GET
      $filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';
      $userToSearch = isset($_GET['userToSearch']) ? $_GET['userToSearch'] : '';

      $users = $this->UserModel->getAllUsers($filter, $userToSearch);
      $this->renderDashboard('teacher/students', ["users" => $users]);
   }


   // *****************************************************************************************************************************************
   public function statistiques()
   {
      $statistics = $this->UserModel->getStatistics();
      $this->renderDashboard('teacher/statistiques', ["statistics" => $statistics]);
   }


   // *****************************************************************************************************************************************
   public function subjects()
   {

      $filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';
      $subToSearch = isset($_GET['subToSearch']) ? $_GET['subToSearch'] : '';

      $subjects = $this->TopicModel->AllPresentaion($filter, $subToSearch);
      $this->renderDashboard('teacher/subjects', ["subjects" => $subjects]);
      // $subjects = $this->TopicModel->AllPresentaion();
      // $this->renderDashboard('teacher/subjects', ["subjects" => $subjects]);
   }


   // *****************************************************************************************************************************************
   public function updatePresentation()
   {
      if ($_SERVER["REQUEST_METHOD"] == "GET") {

         $idPresentation = $_GET['id'];
         $this->TopicModel->setId($idPresentation);
         $subject = $this->TopicModel->getPresentationById();
         $this->renderDashboard('/teacher/actions/update', ["subject" => $subject]);
      }
   }


   // *****************************************************************************************************************************************
   public function suggestions()
   {

      $filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';
      $suggToSearch = isset($_GET['suggToSearch']) ? $_GET['suggToSearch'] : '';

      $suggestions = $this->suggModel->AllSuggestions($filter, $suggToSearch);
      $this->renderDashboard('teacher/suggestions', ["suggestions" => $suggestions]);
   }


   // *****************************************************************************************************************************************
   public function handleSubject()
   {
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
         if (isset($_POST['btn_add_subject'])) {

            $title = $_POST['titre'];
            $description = $_POST['description'];
            $date = $_POST['date'];

            $this->TopicModel->setTitle($title);
            $this->TopicModel->setDescription($description);
            $this->TopicModel->setdate_realisation($date);

            $lastInsertId = $this->TopicModel->addTopic();

            if ($lastInsertId) {
               header('Location: /teacher/subjects');
               //   echo "vous aver ajoutez un TOPIC avec succes .";
            }
         }


         if (isset($_POST['btn_delete_subject'])) {

            $id_presentation = $_POST['id_delete'];

            $this->TopicModel->setId($id_presentation);

            $deleteSub = $this->TopicModel->deleteTopic();

            if ($deleteSub) {
               header('Location: /teacher/subjects');
               //   echo "vous aver supprimer un TOPIC avec succes .";
            }
         }
      }
   }



   public function saveUpdatePresentation()
   {
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
         if (isset($_POST['btn_update_subject'])) {
            $id_update = $_POST['id_presentation_update'];
            $title = trim($_POST['titre']);
            $description = trim($_POST['description']);
            $date = $_POST['date'];
            $status = $_POST['status'];

            $this->TopicModel->setId($id_update);

            // Vérifie si "lien" est défini, sinon met à NULL
            $lien = !empty($_POST['lien']) ? $_POST['lien'] : null;

            // Exécute la mise à jour et vérifie le résultat
            $updateSuccess = $this->TopicModel->updatePresentation($title, $description, $date, $status, $lien);

            if ($updateSuccess) {
               header('Location: /teacher/subjects');
               exit; // Assure que la redirection est bien exécutée
            } else {
               echo "Erreur : La mise à jour a échoué.";
            }
         }
      }
   }


   // *****************************************************************************************************************************************
   public function handleSuggestions()
   {
      if ($_SERVER["REQUEST_METHOD"] == "POST") {

         // delete suggestion 
         if (isset($_POST['btn_delete_sugg'])) {

            $id_sugg = $_POST['id_delete'];

            $this->suggModel->setIdSujet($id_sugg);

            $deleteSub = $this->suggModel->deleteSujet();

            if ($deleteSub) {
               header('Location: /teacher/suggestions');
               //   echo "vous aver supprimer un sujet proposer avec succes .";
            }
         }


         // status
         if (isset($_POST['btn_status_sugg'])) {

            $id_sugg = $_POST['id_sugg'];
            $status_sugg = $_POST['status_sugg'];

            if ($status_sugg == 'Proposé') {
               $newStatus = 'Validé';
            }

            $this->suggModel->setIdSujet($id_sugg);
            $this->suggModel->setStatus($newStatus);

            $updateStatus = $this->suggModel->changeStatusSujet();

            if ($updateStatus) {
               header('Location: /teacher/suggestions');
            }
         }
      }
   }


   // **********************************************************************************************************************************************************************
   public function deleteUsers()
   {

      if ($_SERVER["REQUEST_METHOD"] == "POST") {

         if (isset($_POST['delete_user'])) {

            $id_user = $_POST['remove_user'];

            $deleteSub = $this->UserModel->deleteUser($id_user);

            if ($deleteSub) {
               header('Location: /teacher/students');
               //   echo "vous aver supprimer un sujet proposer avec succes .";
            }
         }
      }
   }


   // **********************************************************************************************************************************************************************
   public function changeStatus()
   {
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
         if (isset($_POST['bnt_user_block'])) {
            $id_user = (int) $_POST['block_user_id'];
            $oldStatus = (int) $_POST['status_user'];

            $newStatus = ($oldStatus === 1) ? 0 : 1;

            $updatedRows = $this->UserModel->changeStatusUser($id_user, $newStatus);

            $student = $this->UserModel->getUserById($id_user);
            $email = $student->email;
            $nom = $student->nom;
            $prenom = $student->prenom;
            $sujet = "Status de Compte";
            $stt = ($newStatus === 1) ? "Valider" : "Bloquer";
            $message = "Votre Compte est $stt.";
            $body = "<p>Bonjour <strong>$prenom $nom</strong>,<br></p><p>$message</p><br><p>Cordialement, VeilleHub.</p>";

            $this->mailModel->envoyerEmail($email, $nom, $prenom, $sujet, $body);

            if ($updatedRows > 0) {
               header('Location: /teacher/students');
               exit();
            }
         }
      }
   }








   // **********************************************************************************************************************************************************************
}
