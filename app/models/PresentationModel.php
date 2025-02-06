<?php
require_once(__DIR__ . '/../config/db.php');
class Presentation extends Db
{

    // les atrributs *****************************************************************************************************************************************
    private int $id;
    private string $title;
    private string $description;
    private string $status = 'A venir';
    private string $date_realisation;

    // Constructeur *****************************************************************************************************************************************
    public function __construct($title = null, $description = null, $status = null, $date_realisation = null)
    {
        parent::__construct();

        $this->$title = $title;
        $this->$description = $description;
        $this->$status = $status;
        $this->$date_realisation = $date_realisation;
    }

    // Getters *****************************************************************************************************************************************
    public function getId()
    {
        return $this->id;
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
    
    public function getDate_realisation()
    {
        return $this->date_realisation;
    }
    
    // Setters *****************************************************************************************************************************************
    public function setId($id)
    {
        $this->id = $id;
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
    
    public function setDate_realisation($date_realisation)
    {
        $this->date_realisation = $date_realisation;
    }
    

    // fonction d'ajout des presentation : *****************************************************************************************************************************************
    public function addTopic()
    {
        try {
            $sql = "INSERT INTO presentations (titre, description, date_realisation, id_enseignant) VALUES (?, ?, ?, ?)";
            $result = $this->conn->prepare($sql);

            $dateRealisation = empty($this->date_realisation) ? null : $this->date_realisation;

            $result->execute([$this->title, $this->description, $dateRealisation, $_SESSION['user_loged_in_id']]);

            return $this->conn->lastInsertId();
        } catch (PDOException $e) {
            echo "Erreur PDO : " . $e->getMessage();
        } catch (Exception $e) {
            echo "Erreur générale : " . $e->getMessage();
        }
    }

    // fonction de suppression d'un présentation *****************************************************************************************************************************************
    public function deleteTopic()
    {
        try {
            $sql = "DELETE FROM presentations WHERE id_presentation = ?";
            $result = $this->conn->prepare($sql);
            $result->execute([$this->id]);
            return $result->rowCount();
        } catch (PDOException $e) {
            echo "Erreur PDO : " . $e->getMessage();
        } catch (Exception $e) {
            echo "Erreur générale : " . $e->getMessage();
        }
    }

    // fonction qui retourne toutes les presentaion *****************************************************************************************************************************************
    public function AllPresentaion()
    {
        try {
            $sql = "SELECT id_presentation, titre, description, DATE_FORMAT(date_realisation, '%d-%m-%Y') as date_realisation, lien_presentation, status, id_enseignant FROM presentations WHERE id_enseignant = ?";
            $result =  $this->conn->prepare($sql);
            $result->execute([$_SESSION['user_loged_in_id']]);

            return $result->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            echo "Erreur PDO : " . $e->getMessage();
        } catch (Exception $e) {
            echo "Erreur générale : " . $e->getMessage();
        }
    }
}
