<?php
require_once(__DIR__ . '/../config/db.php');
class Calendar extends Db
{

    // les atrributs *****************************************************************************************************************************************
    private int $id_presentation;
    private int $id_student;
    private $date_event;


    // Constructeur *****************************************************************************************************************************************
    public function __construct($id_presentation = null, $id_student = null, $date_event = null)
    {
        parent::__construct();

        $this->$id_presentation = $id_presentation;
        $this->$id_student = $id_student;
        $this->$date_event = $date_event;
    }

    // Getters *****************************************************************************************************************************************
    public function getIdPresentation()
    {
        return $this->id_presentation;
    }

    public function getIdStudent()
    {
        return $this->id_student;
    }

    public function getDateEvent()
    {
        return $this->date_event;
    }

    // Setters *****************************************************************************************************************************************
    public function setIdPresentation($id_presentation)
    {
        $this->id_presentation = $id_presentation;
    }

    public function setIdStudent($id_student)
    {
        $this->id_student = $id_student;
    }

    public function setDateEvent($date_event)
    {
        $this->date_event = $date_event;
    }


    // *****************************************************************************************************************************************
    public function addToCalendar()
    {
        try {
            $sql = "INSERT INTO calendriers(id_presentation, id_etudiant, date_de_presentation) VALUES (?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$this->id_presentation, $this->id_student, $this->date_event]);

            return $this->conn->lastInsertId();
        } catch (PDOException $e) {
            echo "Erreur PDO : " . $e->getMessage();
        } catch (Exception $e) {
            echo "Erreur générale : " . $e->getMessage();
        }
    }


    // public function AllPresentationCalendar()
    // {
    //     try {
    //         $sql = "SELECT c.id_etudiant, c.id_presentation, date_format(c.date_de_presentation, '%Y-%m-%d') as date, u.nom, p.titre 
    //                 FROM calendriers c
    //                 JOIN users u ON c.id_etudiant = u.id_user
    //                 JOIN presentations p ON c.id_presentation = p.id_presentation";
    //         $stmt = $this->conn->prepare($sql);
    //         $stmt->execute();

    //         return json_encode($stmt->fetchAll(PDO::FETCH_OBJ));
    //     } catch (PDOException $e) {
    //         echo "Erreur PDO : " . $e->getMessage();
    //     } catch (Exception $e) {
    //         echo "Erreur générale : " . $e->getMessage();
    //     }
    // }

   



    public function AllPresentationCalendar()
{
    try {
        $sql = "SELECT 
                    c.id_presentation, 
                    DATE_FORMAT(c.date_de_presentation, '%Y-%m-%d') AS start, 
                    u.nom, 
                    p.titre 
                FROM calendriers c
                JOIN users u ON c.id_etudiant = u.id_user
                JOIN presentations p ON c.id_presentation = p.id_presentation";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $presentations = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $events = [];
        foreach ($presentations as $row) {
            $events[] = [
                'id' => $row['id_presentation'],
                'title' => $row['titre'] . " - " . $row['nom'], // Format : "Titre - Nom"
                'start' => $row['start'],
            ];
        }

        return json_encode($events);

    } catch (PDOException $e) {
        echo json_encode(['error' => "Erreur PDO : " . $e->getMessage()]);
    } catch (Exception $e) {
        echo json_encode(['error' => "Erreur générale : " . $e->getMessage()]);
    }
}

}
