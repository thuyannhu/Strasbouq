<?php

namespace App\Controller;

use App\Model\UserManager;

class ConnecterController extends AbstractController
{
    public function connect(): string
    {
        $message = [];
        $alert = "";
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (count($_POST) < 3) {
                // Connexion compte existant
                $username = $_POST["email"];
                $userManager = new UserManager();
                $userPassword = $userManager->searchUser($username, "userPassword");

                if (isset($userPassword[0]['userPassword'])) {
                    if ($_POST["password"] === $userPassword[0]['userPassword']) {
                        $message = ["vous etes connecté!"];
                        $alert = 'success';
                    } else {
                        $message = ["erreur!! mot de passe erroné"];
                        $alert = 'danger';
                    }
                } else {
                    $message = ["erreur!! email inconnu"];
                    $alert = 'danger';
                }
            } else {
                // Inscription
                if (!isset($_POST['name']) || trim($_POST['name']) === '') {
                    $errors['name'] = "Le nom est obligatoire";
                }
                if (!isset($_POST['firstname']) || trim($_POST['firstname']) === '') {
                    $errors['firstname'] = "Le prénom est obligatoire";
                }
                if (!isset($_POST['adresse']) || trim($_POST['adresse']) === '') {
                    $errors['adresse'] = "L'adresse est obligatoire";
                }
                if (!isset($_POST['code']) || trim($_POST['code']) === '') {
                    $errors['code'] = "Le code postal est obligatoire";
                }
                if (!isset($_POST['ville']) || trim($_POST['ville']) === '') {
                    $errors['ville'] = "La ville est obligatoire";
                }
                if (!isset($_POST['telephone']) || trim($_POST['telephone']) === '') {
                    $errors['telephone'] = "Le numéro de téléphone est obligatoire";
                }
                $userM = new UserManager();
                if (!$userM->phoneCheck($_POST['telephone'])) {
                    $errors['telephone'] = "La syntaxe du numéro de téléphone est mauvaise";
                }
                if (!isset($_POST['email']) || trim($_POST['email']) === '') {
                    $errors['email'] = "L'email est obligatoire";
                }
                if (!isset($_POST['password']) || trim($_POST['password']) === '') {
                    $errors['password'] = "Le mot de passe est obligatoire";
                }
                if ($_POST['confirm'] !== $_POST['password']) {
                    $errors['confirm'] = "Les mots de passe ne correspondent pas.";
                }

                if (empty($errors)) {
                    // traitement du formulaire
                    // puis redirection
                    $userManager = new UserManager();
                    $userManager->insertUser(["firstname" => $_POST["firstname"],"lastname" => $_POST["name"],
                    "address" => $_POST["adresse"],"userPassword" => $_POST["password"],"mail" => $_POST["email"],
                    "fidelity" => 0 ,"isAdmin" => 0, "zipcode" => $_POST["code"],"city" => $_POST["ville"], 
                    "phone" => $_POST["telephone"]]);
                    $message = ["Bravo! Votre inscription a réussi."];
                    $alert = 'success';
                } else {
                    foreach ($errors as $error) {
                        array_push($message, $error);
                    }
                    $alert = 'danger';
                }
            }
        }
        return $this->twig->render('Connecter/connect.html.twig', ['message' => $message, 'alert' => $alert]);
    }
}
