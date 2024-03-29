<?php

/**
 * 
 * Project : Budget manager
 * Description : Une application de gestion de budget et de dépenses monétaire.
 * File : RoleModel.php
 * Authors : Jérémy Ballanfat, Illya Nuzhny
 * Date : 8 mars 2024
 * 
 */

namespace Projet\Budgetmanager\api\php\model;

use PDOException;
use PDORow;
use Projet\Budgetmanager\api\php\model\BaseModel as BaseModel;

use Projet\Budgetmanager\api\php\model\Database as Database;

class RoleModel extends BaseModel {

    protected $map = [

        "id_role" => "idRole",
        "nom_role" => "nomRole"

    ];

    public int $idRole;

    public string $nomRole;

    public function __construct($init = [])
    {

        $this->idRole = $init["id_role"] ?? -1;

        $this->nomRole = $init["nom_role"] ?? "";
        
    }

    public static function selectRole($id) : RoleModel | false | PDOException {

        $query = "SELECT *
        FROM `Role`
        WHERE `Role`.`id_role` = :idRole";

        $param = [

            ":idRole" => $id

        ];

        try {

            $statement = Database::getDB()->run($query, $param);
            $statement->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, static::class);
            return $statement->fetch();

        }
        catch(PDOException $exception){

            return $exception;

        }

    }

}