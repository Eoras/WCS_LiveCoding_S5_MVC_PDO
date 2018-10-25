<?php
/**
 * Created by PhpStorm.
 * User: pauldossantos
 * Date: 02/10/2018
 * Time: 19:56
 */

namespace App\Model;

abstract class AbstractManager
{
    protected $db;

    public function __construct()
    {
        $this->db = new \PDO(DSN, USER, PASSWORD);
    }
}
