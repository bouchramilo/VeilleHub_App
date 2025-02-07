<?php
require_once(__DIR__ . '/../config/db.php');
class User extends Db
{

    // **********************************************************************************************************************************************************************
    public function __construct()
    {
        parent::__construct();
    }


    // **********************************************************************************************************************************************************************
    public function register($user)
    {
        try {

            $sql = "INSERT INTO users (nom, prenom, `password`, email, role) VALUES (?, ?, ?, ?, ?)";
            $result = $this->conn->prepare($sql);
            $result->execute($user);
            return $this->conn->lastInsertId();
        } catch (PDOException $e) {
            echo "Erreur PDO : " . $e->getMessage();
        } catch (Exception $e) {
            echo "Erreur générale : " . $e->getMessage();
        }
    }


    // **********************************************************************************************************************************************************************
    public function login($userData)
    {
        try {
            $result = $this->conn->prepare("SELECT * FROM users WHERE email=?");
            $result->execute([$userData[0]]);
            $user = $result->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($userData[1], $user['password'])) {
                return  $user;
            }
            return false;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }



    // **********************************************************************************************************************************************************************
    public function deleteUser($user)
    {
        try {
            $sql = "DELETE FROM users WHERE id_user = ?";
            $result = $this->conn->prepare($sql);
            $result->execute([$user]);

            return $result->rowCount();
        } catch (PDOException $e) {
            throw new Exception("Erreur PDO : " . $e->getMessage());
        }
    }


    // **********************************************************************************************************************************************************************
    public function changeStatusUser($user, $newStatus)
    {
        try {
            $sql = "UPDATE users SET is_Vlalide = ? WHERE id_user = ?";
            $result = $this->conn->prepare($sql);
            $result->execute([$newStatus, $user]);

            return $result->rowCount();
        } catch (PDOException $e) {
            throw new Exception("Erreur PDO : " . $e->getMessage());
        }
    }



    //    **********************************************************************************************************************************************************************
    public function getStatistics()
    {
        $statistics = [];

        // Total des présentations effectuées
        $sql1 = "SELECT COUNT(*) AS total_presentations FROM presentations WHERE status = 'Passé'";
        $result1 = $this->conn->query($sql1);
        $total_presentations = $result1->fetch(PDO::FETCH_ASSOC)['total_presentations'];

        // Étudiants les plus actifs
        $sql2 = "SELECT u.id_user, u.nom, u.prenom, COUNT(s.id_sujet) AS nombre_sujets
         FROM users u
         JOIN sujets s ON u.id_user = s.id_etudiant
         GROUP BY u.id_user, u.nom, u.prenom
         ORDER BY nombre_sujets DESC
         LIMIT 5";
        $top_students = $this->conn->query($sql2)->fetchAll(PDO::FETCH_ASSOC);

        // Taux de participation des étudiants
        $sql3 = "SELECT (COUNT(DISTINCT s.id_etudiant) / COUNT(DISTINCT u.id_user)) * 100 AS taux_participation
         FROM users u
         LEFT JOIN sujets s ON u.id_user = s.id_etudiant
         WHERE u.role = 'Etudiant'";
        $result3 = $this->conn->query($sql3);
        $taux_participation = $result3->fetch(PDO::FETCH_ASSOC)['taux_participation'];

        $statistics = [$total_presentations, $taux_participation, $top_students];

        return $statistics;
    }


    // **********************************************************************************************************************************************************************
    public function getAllUsers($filter, $userToSearch = '')
    {
        $query = "SELECT * FROM users WHERE role != 'Enseignant'";

        // add filter to query
        if ($filter == 'Etudiant') {
            $query .= " AND role = 'Etudiant'";
        } elseif ($filter == 'Enseignant') {
            $query .= " AND role = 'Enseignant'";
        }

        // add search condition to query
        if ($userToSearch) {
            $query .= " AND nom LIKE ?";
        }

        $resul = $this->conn->prepare($query);
        $resul->execute($userToSearch ? ["%$userToSearch%"] : []);

        // Fetch and return results
        $users = $resul->fetchAll(PDO::FETCH_ASSOC);
        return $users;
    }
}
