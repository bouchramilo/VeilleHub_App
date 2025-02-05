<?php

class HomeController extends BaseController
{


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
      $this->render('home');
   }
}
