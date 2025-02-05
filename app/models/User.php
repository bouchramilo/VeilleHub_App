<?php
require_once(__DIR__ . '/../config/db.php');
class User extends Db
{

    public function __construct()
    {
        parent::__construct();
    }

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



    public function login($userData)
    {

        try {
            // var_dump($userData);
            
            $result = $this->conn->prepare("SELECT * FROM users WHERE email=?");
            $result->execute([$userData[0]]);
            $user = $result->fetch(PDO::FETCH_ASSOC);
            // var_dump($user);
        
            if ($user && password_verify($userData[1], $user['password'])) {
                return  $user;
            }
            return false;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function getStatistics()
    {
        $statistics = [];

        // Total number of users
        $query = $this->conn->prepare("SELECT COUNT(*) AS total_users FROM users");
        $query->execute();
        $statistics['total_users'] = $query->fetch(PDO::FETCH_ASSOC)['total_users'];

        // Total number of published projects
        $query = $this->conn->prepare("SELECT COUNT(*) AS total_projects FROM projets");
        $query->execute();
        $statistics['total_projects'] = $query->fetch(PDO::FETCH_ASSOC)['total_projects'];

        // Total number of freelancers
        $query = $this->conn->prepare("SELECT COUNT(*) AS total_freelancers FROM users WHERE role = '3'");
        $query->execute();
        $statistics['total_freelancers'] = $query->fetch(PDO::FETCH_ASSOC)['total_freelancers'];

        // Number of ongoing offers (status = 2)
        $query = $this->conn->prepare("SELECT COUNT(*) AS ongoing_offers FROM offres WHERE status = 2");
        $query->execute();
        $statistics['ongoing_offers'] = $query->fetch(PDO::FETCH_ASSOC)['ongoing_offers'];

        return $statistics;
    }

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
