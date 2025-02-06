<?php
require_once(__DIR__ . '/../models/UserModel.php');
require_once(__DIR__ . '/../models/PresentationModel.php');
require_once(__DIR__ . '/../models/SuggestionModel.php');

class TeacherController extends BaseController
{
   // *****************************************************************************************************************************************
   private $UserModel;
   private $TopicModel;
   private $suggModel;


   // *****************************************************************************************************************************************
   public function __construct()
   {
      $this->UserModel = new User();
      $this->TopicModel = new Presentation();
      $this->suggModel = new Suggestion();
   }


   // *****************************************************************************************************************************************
   public function index()
   {
      if (!isset($_SESSION['user_loged_in_id'])) {
         header("Location: /login ");
         exit;
      }
      $statistics =  $this->UserModel->getStatistics();
      $this->renderDashboard('teacher/index', ["statistics" => $statistics]);
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
      $this->renderDashboard('teacher/statistiques');
   }

   // *****************************************************************************************************************************************
   public function subjects()
   {
      $subjects = $this->TopicModel->AllPresentaion();
      $this->renderDashboard('teacher/subjects', ["subjects" => $subjects]);
   }


   // *****************************************************************************************************************************************
   public function suggestions()
   {
      $suggestions = $this->suggModel->AllSuggestions();
      $this->renderDashboard('teacher/suggestions', ["suggestions" => $suggestions]);
   }


   // *****************************************************************************************************************************************
   // public function addSubject()
   // {
   //    $this->renderDashboard('teacher/subjects/add');
   // }

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

            // $subject = [$title, $description, $date];

            $this->TopicModel->setId($id_presentation);

            $deleteSub = $this->TopicModel->deleteTopic();

            if ($deleteSub) {
               header('Location: /teacher/subjects');
               //   echo "vous aver supprimer un TOPIC avec succes .";
            }
         }
      }
   }

   // *****************************************************************************************************************************************
   public function handleSuggestions()
   {
      if ($_SERVER["REQUEST_METHOD"] == "POST") {

         if (isset($_POST['btn_delete_sugg'])) {

            $id_sugg = $_POST['id_delete'];

            $this->suggModel->setIdSujet($id_sugg);

            $deleteSub = $this->suggModel->deleteSujet();

            if ($deleteSub) {
               header('Location: /teacher/suggestions');
               //   echo "vous aver supprimer un sujet proposer avec succes .";
            }
         }





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

   public function changeStatus()
   {
       if ($_SERVER["REQUEST_METHOD"] == "POST") {
           if (isset($_POST['bnt_user_block'])) {
               $id_user = (int) $_POST['block_user_id'];
               $oldStatus = (int) $_POST['status_user'];
   
               // var_dump($id_user, $oldStatus);
   
               $newStatus = ($oldStatus === 1) ? 0 : 1;
               // echo "Nouveau statut : " . $newStatus;
   
               $updatedRows = $this->UserModel->changeStatusUser($id_user, $newStatus);
   
               if ($updatedRows > 0) {
                   header('Location: /teacher/students');
                   exit();
               } 
               // else {
               //     echo "Aucune mise à jour effectuée.";
               // }
           }
       }
   }






   // function to remove user
   // function removeUser($idUser){
   //     include '../connection.php';
   //     $removeUser = $conn->prepare("DELETE FROM utilisateurs WHERE id_utilisateur=?");
   //     $removeUser->execute([$idUser]);
   // }

   // // check the post request to remove the user
   // if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['remove_user'])) {
   //     $idUser = $_POST['remove_user'];
   //     removeUser($idUser);
   //     // Redirect to avoid form resubmission after page reload
   //     header("Location: users.php");
   //     exit();
   // }

   // // function to block user
   // function changeStatus($idUser){
   //     include '../connection.php';

   //     // get the old status
   //     $stmt = $conn->prepare("SELECT is_active FROM utilisateurs WHERE id_utilisateur = ?");
   //     $stmt->execute([$idUser]);
   //     $currentStatus = $stmt->fetchColumn();

   //     $changeStatus = $conn->prepare("UPDATE utilisateurs SET is_active=? WHERE id_utilisateur=?");
   //     $changeStatus->execute([$currentStatus==0?1:0,$idUser]);
   // }
   // // check the post request to block the user
   // if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['block_user_id'])) {
   //     $idUser = $_POST['block_user_id'];
   //     changeStatus($idUser);
   //     // Redirect to avoid form resubmission after page reload
   //     header("Location: users.php");
   //     exit();
   // }







}
