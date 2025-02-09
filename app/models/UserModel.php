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
        try {
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
        } catch (PDOException $e) {
            throw new Exception("Erreur PDO : " . $e->getMessage());
        }
    }


    // **********************************************************************************************************************************************************************
    public function getAllUsers($filter = '', $userToSearch = '')
    {
        try {
            $query = "SELECT 
                u.id_user, 
                u.nom, 
                u.prenom, 
                u.email, 
                u.is_Vlalide, 
                u.role, 
                COUNT(c.id_presentation) AS nombre_participations
              FROM users u
              LEFT JOIN calendriers c ON u.id_user = c.id_etudiant
              WHERE u.role != 'Enseignant'";

            $params = [];

            if ($filter == 'Etudiant') {
                $query .= " AND u.role = 'Etudiant'";
            } elseif ($filter == 'Enseignant') {
                $query .= " AND u.role = 'Enseignant'";
            }

            if (!empty($userToSearch)) {
                $query .= " AND u.nom LIKE ?";
                $params[] = "%$userToSearch%";
            }

            $query .= " GROUP BY u.id_user ORDER BY nombre_participations DESC";

            $resul = $this->conn->prepare($query);
            $resul->execute($params);

            return $resul->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Erreur PDO : " . $e->getMessage());
        }
    }



    // **********************************************************************************************************************************************************************
    public function getAllStudent()
    {
        try {
            $query = "SELECT * FROM users WHERE role != 'Enseignant' AND is_Vlalide = 1 ";

            $resul = $this->conn->prepare($query);
            $resul->execute();

            // Fetch and return results
            $users = $resul->fetchAll(PDO::FETCH_OBJ);
            return $users;
        } catch (PDOException $e) {
            throw new Exception("Erreur PDO : " . $e->getMessage());
        }
    }


    // **********************************************************************************************************************************************************************
    public function getUserById($id)
    {
        try {
            $sql = "SELECT * FROM users WHERE id_user = ?";
            $result = $this->conn->prepare($sql);
            $result->execute([$id]);

            return $result->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            throw new Exception("Erreur PDO : " . $e->getMessage());
        }
    }


    // **********************************************************************************************************************************************************************
    public function getIdByemail($email)
    {
        try {
            $sql = "SELECT id_user FROM users WHERE email = ?";
            $result = $this->conn->prepare($sql);
            $result->execute([$email]);

            return $result->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            throw new Exception("Erreur PDO : " . $e->getMessage());
        }
    }


    // **********************************************************************************************************************************************************************
    public function getEmailByToken($token)
    {
        try {
            $sql = "SELECT email FROM resetPassword WHERE token = ? ANd expires_at > NOW()";
            $result = $this->conn->prepare($sql);
            $result->execute([$token]);

            return $result->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            throw new Exception("Erreur PDO : " . $e->getMessage());
        }
    }


    // **********************************************************************************************************************************************************************
    public function addToken($email, $token, $expiry)
    {
        try {
            $sql = "INSERT INTO resetPassword(email, token, expires_at) VALUES (?,?,?)";
            $result = $this->conn->prepare($sql);
            $result->execute([$email, $token, $expiry]);

            return $result->rowCount();
        } catch (PDOException $e) {
            throw new Exception("Erreur PDO : " . $e->getMessage());
        }
    }


    // **********************************************************************************************************************************************************************
    public function restartPassword($userData)
    {
        try {
            $result = $this->conn->prepare("UPDATE users SET password = ? WHERE email=?");
            $result->execute([$userData[1], $userData[0]]);

            return $result->rowCount();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    // **********************************************************************************************************************************************************************
    public function deleteToken($email)
    {
        try {
            $result = $this->conn->prepare("DELETE FROM  resetPassword WHERE email = ? ");
            $result->execute([$email]);

            return $result->rowCount();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
