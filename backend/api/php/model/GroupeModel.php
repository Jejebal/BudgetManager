<?php

/**
 * 
 * Project : Budget manager
 * Description : Une application de gestion de budget et de dépenses monétaire.
 * File : GroupeModel.php
 * Authors : Jérémy Ballanfat, Illya Nuzhny
 * Date : 8 mars 2024
 * 
 */

namespace Projet\Budgetmanager\api\php\model;

use PDOException;
use Projet\Budgetmanager\api\php\model\BaseModel as BaseModel;

use Projet\Budgetmanager\api\php\model\Database as Database;

class GroupeModel extends BaseModel {

    protected $map = [

        "id_groupe" => "idGroupe",
        "impots" => "impots",
        "loyer" => "loyer",
        "credit" => "credit",
        "mois_budget" => "moisBudget"

    ];

    public int $idGroupe;

    public float $impots;

    public float $loyer;

    public float $credit;

    public string $moisBudget;

    public function __construct(array $init = [])
    {

        $this->idGroupe = $init["id_groupe"] ?? -1;

        $this->impots = $init["impots"] ?? -1;

        $this->loyer = $init["loyer"] ?? -1;

        $this->credit = $init["credit"] ?? -1;

        $this->moisBudget = $init["mois_budget"] ?? "";
        
    }

    public static function selectGroupe($id) : GroupeModel | false | PDOException {

        $query = "SELECT *
        FROM `Groupe`
        WHERE `Groupe`.`id_groupe` = :idGroupe;";

        $param = [

            ":idGroupe" => $id

        ];

        try {

            $statement = DataBase::getDB()->run($query, $param);
            $statement->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, __CLASS__);
            return $statement->fetch();

        }
        catch(PDOException $exception){

            return $exception;

        }

    }

    public static function insertGroupe() : int | false | PDOException {

        $query = "INSERT INTO `Groupe` (`Groupe`.`impots`, `Groupe`.`loyer`, `Groupe`.`credit`, `Groupe`.`mois_budget`) 
        VALUES (0.0, 0.0, 0.0, 0);";

        try{

            Database::getDB()->run($query);
            return DataBase::getDB()->lastInsertId();

        }
        catch(PDOException $exceptiom){

            return $exceptiom;

        }

    }

    public function updateGroupe() : int | PDOException {

        $query = "UPDATE `Groupe`
        SET  `Groupe`.`impots` = :impots, `Groupe`.`loyer` = :loyer, `Groupe`.`credit` = :credit, `Groupe`.`mois_budget` = :moisBudget
        WHERE `Groupe`.`id_groupe` = :idGroupe;";

        $param = [

            ":impots" => $this->impots,
            ":loyer" => $this->loyer,
            ":credit" => $this->credit,
            ":moisBudget" => $this->moisBudget,
            ":idGroupe" => $this->idGroupe

        ];

        try{

            DataBase::getDB()->run($query, $param);

            return $this->idGroupe;

        }
        catch(PDOException $exception){

            return $exception;

        }

    }

}