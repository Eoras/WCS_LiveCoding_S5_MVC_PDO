<?php
/**
 * Created by PhpStorm.
 * User: pauldossantos
 * Date: 03/10/2018
 * Time: 16:26
 */

namespace App\Model;

class PersonneManager extends AbstractManager
{

    /**
     * Récupère un tableau avec toutes les personnes
     * @return array
     */
    public function getAllPersonne()
    {
        $query = $this->db->query("SELECT p.*, s.name session_name, s.ville session_ville from personne p
                                             INNER JOIN session s
                                             ON p.session_id = s.id");
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function addNewPersonne($nom, $prenom, $email, $session_id): bool
    {
        $req = $this->db->prepare(
            "INSERT INTO personne (nom, prenom, email, session_id) VALUE (:nom, :prenom, :email, :session_id)"
        );

        $req->bindParam(":nom", $nom, \PDO::PARAM_STR);
        $req->bindParam(":prenom", $prenom, \PDO::PARAM_STR);
        $req->bindParam(":email", $email, \PDO::PARAM_STR);
        $req->bindParam(":session_id", $session_id, \PDO::PARAM_INT);

        // La méthode execute retourne un booleen true si tout se passe bien, ou false si ça ne se passe bien.
        return $req->execute();
    }

    public function deletePersonne(int $id)
    {
        $req = $this->db->prepare("DELETE FROM personne WHERE id = :id");
        $req->bindParam(":id", $id);
        return $req->execute();
    }

    public function editPersonne($id, $nom, $prenom, $email, $session_id)
    {
        $req = $this->db->prepare(
            "UPDATE personne SET nom = :nom, prenom = :prenom, email = :email, session_id = :session_id
                      WHERE id = :id"
        );

        $req->bindParam(":id", $id, \PDO::PARAM_INT);
        $req->bindParam(":nom", $nom, \PDO::PARAM_STR);
        $req->bindParam(":prenom", $prenom, \PDO::PARAM_STR);
        $req->bindParam(":email", $email, \PDO::PARAM_STR);
        $req->bindParam(":session_id", $session_id, \PDO::PARAM_INT);

        // La méthode execute retourne un booleen true si tout se passe bien, ou false si ça ne se passe bien.
        return $req->execute();
    }

    public function getPersonne(int $id)
    {
        $query = $this->db->query("SELECT * from personne WHERE id = $id");
        return $query->fetch(\PDO::FETCH_ASSOC);
    }
}
