<?php

/**
 * 
 * Project : Budget manager
 * Description : Une application de gestion de budget et de dépenses monétaire.
 * File : UserCtrl.php
 * Authors : Jérémy Ballanfat, Illya Nuzhny
 * Date : 8 mars 2024
 * 
 */

namespace Projet\Budgetmanager\api\php\controller;

use Projet\Budgetmanager\api\php\model\UserModel;

class UserCtrl {

    public function createAdmin($nom, $email, $motPasse, $remediation, $idGroupe) : UserModel | array {

        $error = [];

        if($nom == "" || strlen($nom) < 3 || strlen($nom) > 100 || !$nom){

            $error["nom"] = "Le nom que vous essayez d'utiliser n'est pas valide. Il doit être plus grand que 3 et plus petit que 100.";

        }

        if($email == "" || strlen($email) < 7 ||strlen($email) > 100 || !$email){

            $error["email"] = "L'email que vous essayez d'ajouter n'est pas valide.";

        }
        
        if($motPasse == "" || strlen($motPasse) < 5 || strlen($motPasse) > 50 || !$motPasse){

            $error["mot de passe"] = "Le mot de passe que vous essayez d'utiliser n'est pas valide. Il dois être plus grand que 5 et plus petit que 50.";

        }

        if($remediation <= 0 || $remediation > 29){

            $error["remediation"] = "La remediation que vous essayez d'utiliser n'est pas valide. Elle dois être plus grand que 0 et plus petit que 29.";

        }

        if($idGroupe <= 0){

            $error["groupe"] = "Le groupe que vous essayez d'utiliser ne peut pas exister.";

        }

        if(empty($error)){

            $result = UserModel::selectUserByUsername($nom);

            if(!is_a($result, "Projet\Budgetmanager\api\php\model\UserModel")){

                $user = new UserModel([ 
                    "nom_utilisateur" => $nom,
                    "email" => $email,
                    "mot_passe" => $motPasse,
                    "remediation" => $remediation,
                    "id_groupe" => $idGroupe
                ]);
    
                $resultat = $user->insertUser();
    
                if(!is_string($resultat)){
    
                    $error["insertion"] = "Un problème est survenu lors de la création de votre compte veuillez réessayer.";
    
                    return $error;
    
                }

                $user = UserModel::selectUserByUsername($resultat);

                if(!is_a($user, "Projet\Budgetmanager\api\php\model\UserModel")){

                    $error["insertion"] = "Un problème est survenu lors de la récupération de votre compte veuillez réessayer.";
    
                    return $error;

                }

                $user->motPasse = "";
    
                return $user;

            }

            $error["user"] = "Le nom d'utilisateur que vous essayez de créer existe déjà.";

            return $error;

        }
        
        return $error;

    }

    public function createMember($nom, $motPasse, $remediation, $idGroupe) : UserModel | array{

        $error = [];

        if($nom == "" || strlen($nom) < 3 || strlen($nom) > 100 || !$nom){

            $error["nom"] = "Le nom que vous essayez d'utiliser n'est pas valide. Il dois être plus grand que 3 et plus petit que 100.";

        }
        
        if($motPasse == "" || strlen($motPasse) < 5 || strlen($motPasse) > 50 || !$motPasse){

            $error["mot de passe"] = "Le mot de passe que vous essayez d'utiliser n'est pas valide. Il dois être plus grand que 5 et plus petit que 50.";

        }

        if($remediation <= 0 || $remediation > 29){

            $error["remediation"] = "La remediation que vous essayez d'utiliser n'est pas valide. Elle dois être plus grand que 0 et plus petit que 29.";

        }

        if($idGroupe <= 0){

            $error["groupe"] = "Le groupe que vous essayez d'utiliser ne peut pas exister.";

        }

        if(empty($error)){

            $user = new UserModel([ 
                "nom_utilisateur" => $nom,
                "mot_passe" => password_hash($motPasse, PASSWORD_DEFAULT),
                "remediation" => $remediation,
                "id_groupe" => $idGroupe
            ]);

            $resultat = $user->insertUser();

            if(!is_string($resultat)){

                $error["insertion"] = "Un problème est survenu lors de la création de votre compte veuillez réessayer.";

                return $error;

            }
            
            $user = UserModel::selectUserByUsername($resultat);

            if(!is_a($user, "Projet\Budgetmanager\api\php\model\UserModel")){

                $error["insertion"] = "Un problème est survenu lors de la récupération de votre compte veuillez réessayer.";

                return $error;

            }

            $user->motPasse = "";

            return $user;

        }
        
        return $error;

    }

    public function checkLogin($nom, $motPasse) : UserModel | array {

        $error = [];

        if($nom == "" || strlen($nom) < 3 || strlen($nom) > 100 || !$nom){

            $error["nom"] = "Le nom que vous essayez d'utiliser ne peux pas exister. Il dois être plus grand que 3 et plus petit que 100.";

        }

        if($motPasse == "" || strlen($motPasse) < 5 || strlen($motPasse) > 50 || !$motPasse){

            $error["mot de passe"] = "Le mot de passe que vous essayez d'utiliser ne peux pas exister. Il dois être plus grand que 5 et plus petit que 50.";

        }

        if(empty($error)){

            $user = UserModel::verifyPassword($nom, $motPasse);

            if(!$user){

                $error["login"] = "Le compte que vous essayez d'utiliser n'existe pas ou le mot de passe que vous avez rentré n'est pas le bon, veuillez réessayer.";
                return $error;

            }
            else{

                return $user;

            }

        }
        else{

            return $error;

        }

    }

}