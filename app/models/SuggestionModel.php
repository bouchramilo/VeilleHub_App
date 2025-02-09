<?php
require_once(__DIR__ . '/../config/db.php');
require_once('PresentationModel.php');
class Suggestion extends Db
{
    // **********************************************************************************************************************************************************************
    private int $id_sujet;
    private int $id_student;
    private int $id_teacher;
    private string $title;
    private string $description;
    private string $status = 'Proposé';
    private string $date_proposition;


    // **********************************************************************************************************************************************************************
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

    // Getters  **********************************************************************************************************************************************************************
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


    // Setters  **********************************************************************************************************************************************************************
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


    // **********************************************************************************************************************************************************************
    public function addSuggestion()
    {
        try {
            $sql = "INSERT INTO sujets (titre, description, id_etudiant) VALUES (?, ?, ?)";
            $result = $this->conn->prepare($sql);
            $result->execute([$this->title, $this->description, $_SESSION['user_loged_in_id']]);

            return $this->conn->lastInsertId();
        } catch (PDOException $e) {
            echo "Erreur PDO : " . $e->getMessage();
        } catch (Exception $e) {
            echo "Erreur générale : " . $e->getMessage();
        }
    }


    // **********************************************************************************************************************************************************************
    public function updateSuggestion()
    {
        try {
            $sql = "UPDATE sujets SET titre = :titre, description = :description WHERE id_sujet = :id_sujet";
            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(":titre", $this->title, PDO::PARAM_STR);
            $stmt->bindParam(":description", $this->description, PDO::PARAM_STR);
            $stmt->bindParam(":id_sujet", $this->id_sujet, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->rowCount();
        } catch (PDOException $e) {
            error_log("Erreur PDO : " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            error_log("Erreur générale : " . $e->getMessage());
            return false;
        }
    }



    // **********************************************************************************************************************************************************************
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

            $newTopic->addTopic();

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


    // **********************************************************************************************************************************************************************
    public function deleteSuggestion()
    {
        try {
            $sql = "DELETE FROM sujets WHERE id_sujet = ? AND id_etudiant = ?";
            $result = $this->conn->prepare($sql);
            $result->execute([$this->id_sujet, $_SESSION['user_loged_in_id']]);

            return $result->rowCount();
        } catch (PDOException $e) {
            echo "Erreur PDO : " . $e->getMessage();
        } catch (Exception $e) {
            echo "Erreur générale : " . $e->getMessage();
        }
    }



    // **********************************************************************************************************************************************************************
    public function deleteSujet()
    {
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


    // **********************************************************************************************************************************************************************
    public function getStatistique()
    {
        try {
            // ++++++++++++++++++++++++++++++++++++++++++++++++++++++
            $sql1 = "SELECT COUNT(*) as total_suggestions FROM sujets WHERE id_etudiant = ?";

            // ++++++++++++++++++++++++++++++++++++++++++++++++++++++
            $sql2 = "SELECT 
                    SUM(CASE WHEN p.status = 'Passé' THEN 1 ELSE 0 END) AS passe,
                    SUM(CASE WHEN p.status = 'A venir' THEN 1 ELSE 0 END) AS a_venir
                 FROM calendriers c
                 JOIN presentations p ON c.id_presentation = p.id_presentation
                 WHERE c.id_etudiant = ?";

            // ++++++++++++++++++++++++++++++++++++++++++++++++++++++
            $sql3 = "SELECT 
                    (COUNT(CASE WHEN status = 'Validé' THEN 1 END) / COUNT(*)) * 100 AS taux_acceptation
                 FROM sujets
                 WHERE id_etudiant = ?";

            // ++++++++++++++++++++++++++++++++++++++++++++++++++++++
            $sql4 = "SELECT 
                    c.id_etudiant, 
                    u.nom, 
                    u.prenom, 
                    COUNT(c.id_presentation) AS total_presentations
                 FROM calendriers c
                 JOIN users u ON c.id_etudiant = u.id_user
                 GROUP BY c.id_etudiant, u.nom, u.prenom
                 ORDER BY total_presentations DESC";

            // ++++++++++++++++++++++++++++++++++++++++++++++++++++++
            $stmt1 = $this->conn->prepare($sql1);
            $stmt1->execute([$_SESSION['user_loged_in_id']]);
            $suggestions = $stmt1->fetch(PDO::FETCH_ASSOC)['total_suggestions'];

            $stmt2 = $this->conn->prepare($sql2);
            $stmt2->execute([$_SESSION['user_loged_in_id']]);
            $presentations = $stmt2->fetch(PDO::FETCH_ASSOC);

            $stmt3 = $this->conn->prepare($sql3);
            $stmt3->execute([$_SESSION['user_loged_in_id']]);
            $taux_acceptation = $stmt3->fetch(PDO::FETCH_ASSOC)['taux_acceptation'] ?? 0;

            $stmt4 = $this->conn->query($sql4);
            $classement = $stmt4->fetchAll(PDO::FETCH_ASSOC);

            // Retourner les résultats sous forme de tableau associatif ++++++++++++++++++++++++++++++++++++++++++++++++
            return [
                'total_suggestions' => $suggestions,
                'presentations_A_venir' => $presentations['a_venir'],
                'presentations_Passe' => $presentations['passe'],
                'taux_acceptation' => round($taux_acceptation, 2),
                'classement' => $classement
            ];
        } catch (PDOException $e) {
            echo "Erreur PDO : " . $e->getMessage();
            return [];
        }
    }


    // **********************************************************************************************************************************************************************
    public function AllSuggestions($filter, $suggToSearch = '')
    {
        try {
            // Début de la requête SQL
            $sql = "SELECT 
                    s.id_sujet, 
                    s.titre, 
                    s.description, 
                    DATE_FORMAT(s.date_proposer, '%d-%m-%Y') AS date_proposer, 
                    s.status, 
                    s.id_enseignant, 
                    s.id_etudiant,
                    u.nom AS nom,
                    u.prenom AS prenom
                FROM sujets s
                JOIN users u ON s.id_etudiant = u.id_user";

            // Tableau pour stocker les valeurs des paramètres
            $params = [];
            $conditions = [];

            // Appliquer les conditions selon le rôle de l'utilisateur
            if ($_SESSION['user_loged_in_role'] == 'Enseignant') {
                $conditions[] = "s.status != 'Rejeté'";
            } elseif ($_SESSION['user_loged_in_role'] == 'Etudiant') {
                $conditions[] = "s.id_etudiant = ?";
                $params[] = $_SESSION['user_loged_in_id'];
            }

            // Ajouter le filtre par statut (enseignants et étudiants)
            if ($filter == 'Proposé' || $filter == 'Validé' || $filter == 'Rejeté') {
                $conditions[] = "s.status = ?";
                $params[] = $filter;
            }

            // Ajouter la recherche par titre
            if (!empty($suggToSearch)) {
                $conditions[] = "s.titre LIKE ?";
                $params[] = "%$suggToSearch%";
            }

            // Ajouter les conditions à la requête
            if (!empty($conditions)) {
                $sql .= " WHERE " . implode(" AND ", $conditions);
            }

            // Préparation et exécution de la requête
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($params);

            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            error_log("Erreur PDO : " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            error_log("Erreur générale : " . $e->getMessage());
            return false;
        }
    }


    // **********************************************************************************************************************************************************************
}
