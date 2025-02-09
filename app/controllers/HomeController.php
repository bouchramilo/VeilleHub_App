<?php

class HomeController extends BaseController
{
   // *****************************************************************************************************************************************
   private $UserModel;
   private $TopicModel;


   // *****************************************************************************************************************************************
   public function __construct()
   {
      $this->UserModel = new User();
      $this->TopicModel = new Presentation();
   }



   public function index()
   {
      // var_dump($_SESSION['user_loged_in_id']);die();
      // if (!isset($_SESSION['user_loged_in_id'])) {
      //    header("Location: /login ");
      //    exit;
      // } elseif ($_SESSION['user_loged_in_role'] == 'Enseignant') {
      //    $this->renderDashboard('teacher/index');
      // }
      // elseif ($_SESSION['user_loged_in_role'] == 'Etudiant') {
      //    $this->renderDashboard('student/student');
      // }

      $filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';
      $subToSearch = isset($_GET['subToSearch']) ? $_GET['subToSearch'] : '';

      $subjects = $this->TopicModel->AllPresentaion($filter, $subToSearch);
      $this->render('home', ["subjects" => $subjects]);


      // $statistics = $this->TopicModel->AllPresentaion();
      // $this->render('home');
   }
}
