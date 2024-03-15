<?php

/**
 * 
 * Project : Budget manager
 * Description : Une application de gestion de budget et de dépenses monétaire.
 * File : DepenseCtrl.php
 * Authors : Jérémy Ballanfat, Illya Nuzhny
 * Date : 8 mars 2024
 * 
 */

namespace Projet\Budgetmanager\controller;

use Projet\Budgetmanager\model\DepenseModel as DepenseModel;

class DepenseCtrl {

    public function createDepense($nom, $montant, $date, $idCategorie, $idUtilisateur) {
        $error = [];

        if ($nom == "" || strlen($nom) >= 100 || strlen($nom) <= 3 || !$nom){

            $error["nom"] = "Le nom de la dépense peut contenir entre 3 et 100 caractères.";

        }

        if ($montant == "" || strlen($montant) > 14 || !$montant){

            $error["montant"] = "Arretez de vous mentir, vous ne gagnez pas autant.";

        }

        if ($date == "" || !validateDate($date, 'd-m-Y') || !$date){
            $error["date"] = "Veuillez saisir une date correcte dans le format d-m-Y, exemple : 15-03-2024.";
        }

        if(empty($error)){

            $depense = new DepenseModel($init = [ 
                "nom_depense" => $nom,
                "montant" => $montant,
                "date" => $date,
                "id_categorie" => $idCategorie,
                "id_utilisateur" => $idUtilisateur
            ]);

            $resultat = $depense->insertDepense();

            if(!$resultat){

                $error["insertion"] = "Un problème est survenu lors de la création de votre dépense veuillez réessayer.";

                return $error;

            }
            else{

                return $resultat;

            }

        }
        
        return $error;
    }

    public function modifyDepense($nom, $montant, $date, $idCategorie, $idUtilisateur) {
        $error = [];

        if ($nom == "" || strlen($nom) >= 100 || strlen($nom) <= 3 || !$nom){

            $error["nom"] = "Le nom de la dépense peut contenir entre 3 et 100 caractères.";

        }

        if ($montant == "" || strlen($montant) > 14 || !$montant){

            $error["montant"] = "Arretez de vous mentir, vous ne gagnez pas autant.";

        }

        if ($date == "" || !validateDate($date, 'd-m-Y') || !$date){
            $error["date"] = "Veuillez saisir une date correcte dans le format d-m-Y, exemple : 15-03-2024.";
        }

        if(empty($error)){

            $depense = DepenseModel::updateDepense($nom, $montant, $date, $idCategorie);

            if (!$depense) {
                $error["modification"] = "Un problème est survenu lors de la modification de votre dépense veuillez réessayer.";
                return $error;
            }
            else{
                return $depense;
            }

        }
        
        return $error;
    }

    public function deleteDepense() {
        $depense = DepenseModel::deleteDepense();

        if(!$depense){
            $error["delete"] = "La dépense que vous essayez de supprimer n'existe pas, veuillez réessayer.";
            return $error;
        }
        else{
            return $depense;
        }
    }
}