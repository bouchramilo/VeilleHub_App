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
      $this->renderDashboard('teacher/calendar');
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

            if ($updatedRows > 0) {
               header('Location: /teacher/students');
               exit();
            }
         }
      }
   }








   // **********************************************************************************************************************************************************************
}
