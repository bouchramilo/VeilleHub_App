<?php
require_once(__DIR__ . '/../config/db.php');
require_once('PresentationModel.php');
class Suggestion extends Db
{

    private int $id_sujet;
    private int $id_student;
    private int $id_teacher;
    private string $title;
    private string $description;
    private string $status = 'Proposé';
    private string $date_proposition;

    public function __construct($title = null, $description = null, $status = null, $date_proposition = null, $id_teacher = null, $id_student = null, $id_sujet = null)
    {
        parent::__construct();

        $this->$id_sujet = $id_sujet;
        $this->$id_teacher = $id_teacher;
        $this->$id_student = $id_student;
        $this->$title = $title;
        $this->$description = $description;
        $this->$status = $status;
        $this->$date_proposition = $date_proposition;
    }

    // Getters
    public function getIdSujet()
    {
        return $this->id_sujet;
    }
    public function getIdStudent()
    {
        return $this->id_student;
    }
    public function getIdTeacher()
    {
        return $this->id_teacher;
    }
    public function getTitle()
    {
        return $this->title;
    }
    public function getDescription()
    {
        return $this->description;
    }
    public function getStatus()
    {
        return $this->status;
    }
    public function getDate_proposition()
    {
        return $this->date_proposition;
    }
    // Setters
    public function setIdSujet($id_sujet)
    {
        $this->id_sujet = $id_sujet;
    }
    public function setIdStudent($id_student)
    {
        $this->id_student = $id_student;
    }
    public function setIdTeacher($id_teacher)
    {
        $this->id_teacher = $id_teacher;
    }
    public function setTitle($title)
    {
        $this->title = $title;
    }
    public function setDescription($description)
    {
        $this->description = $description;
    }
    public function setStatus($status)
    {
        $this->status = $status;
    }
    public function setDate_proposition($date_proposition)
    {
        $this->date_proposition = $date_proposition;
    }

    // public function addTopic()
    // {

    //     try {

    //         $sql = "INSERT INTO presentations (titre, description, date_proposition, id_teacher) VALUES (?, ?, ?, ?)";
    //         $result = $this->conn->prepare($sql);
    //         $result->execute([$this->title, $this->description, $this->date_proposition, $_SESSION['user_loged_in_id']]);
    //         return $this->conn->lastInsertId();
    //     } catch (PDOException $e) {
    //         echo "Erreur PDO : " . $e->getMessage();
    //     } catch (Exception $e) {
    //         echo "Erreur générale : " . $e->getMessage();
    //     }
    // }



    public function changeStatusSujet()
    {
        try {
            $this->conn->beginTransaction();
            $sql = "UPDATE sujets SET status = ? WHERE id_sujet = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$this->status, $this->id_sujet]);

            $query = "SELECT * FROM sujets WHERE id_sujet = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->execute([$this->id_sujet]);
            $sujet = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$sujet) {
                throw new Exception("Aucun sujet trouvé avec cet ID.");
            }

            $newTopic = new Presentation();
            $newTopic->setTitle($sujet['titre']);
            $newTopic->setDescription($sujet['description']);
            // $newTopic->setDate_realisation('');

            $lastInsertId = $newTopic->addTopic();
            $this->conn->commit();
            return $stmt->rowCount();
        } catch (PDOException $e) {
            $this->conn->rollBack();
            echo "Erreur PDO : " . $e->getMessage();
        } catch (Exception $e) {
            $this->conn->rollBack();
            echo "Erreur générale : " . $e->getMessage();
        }
    }



    public function deleteSujet()
    {
        // try {

        //     $sql = "DELETE FROM sujets WHERE id_sujet = ?";
        //     $result = $this->conn->prepare($sql);
        //     $result->execute([$this->id_sujet]);
        //     return $result->rowCount();
        // } catch (PDOException $e) {
        //     echo "Erreur PDO : " . $e->getMessage();
        // } catch (Exception $e) {
        //     echo "Erreur générale : " . $e->getMessage();
        // }





        try {
            $sql = "UPDATE sujets SET status = ? WHERE id_sujet = ?";
            $result = $this->conn->prepare($sql);
            $result->execute(['Rejeté', $this->id_sujet]);
            return $result->rowCount();
        } catch (PDOException $e) {
            echo "Erreur PDO : " . $e->getMessage();
        } catch (Exception $e) {
            echo "Erreur générale : " . $e->getMessage();
        }
    }

    public function AllSuggestions()
    {
        try {
            $sql = "SELECT id_sujet, titre, description, DATE_FORMAT(date_proposer, '%d-%m-%Y') as date_proposer, status, id_enseignant, id_etudiant FROM sujets ";

            // add filter to query
            if ($_SESSION['user_loged_in_role'] == 'Enseignant') {
                $sql .= " where status != 'Rejeté'";
            }

            $result =  $this->conn->prepare($sql);
            $result->execute();

            return $result->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            echo "Erreur PDO : " . $e->getMessage();
        } catch (Exception $e) {
            echo "Erreur générale : " . $e->getMessage();
        }
    }
}
