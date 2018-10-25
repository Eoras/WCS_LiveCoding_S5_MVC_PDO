<?php
/**
 * Created by PhpStorm.
 * User: pauldossantos
 * Date: 02/10/2018
 * Time: 20:11
 */

namespace App\Model;

class SessionManager extends AbstractManager
{

    public function getAllSession()
    {
        $query = $this->db->query("SELECT * from session");
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }
}
