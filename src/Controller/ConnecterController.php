<?php

namespace App\Controller;

use App\Model\UserManager;

class ConnecterController extends AbstractController
{
    private function traduireEntree($entree)
    {
        $tableau = [
            "name" => "Le nom", "firstname" => "Le prénom", "adresse" => "L' adresse",
            "code" => "Le code postal", "ville" => "La ville", "telephone" => "Le numéro de téléphone",
            "email" => "L' e-mail", "password" => "Le mot de passe"
        ];
        return $tableau[$entree];
    }

    private function verifierNumero($errors)
    {
        $userM = new UserManager();
        if (!$userM->phoneCheck($_POST['telephone'])) {
            $errors['telephone'] = "La syntaxe du numéro de téléphone est mauvaise.";
        }
        return $errors;
    }

    private function verifierPasswords($errors)
    {
        if ($_POST['confirm'] !== $_POST['password']) {
            $errors['confirm'] = "Les mots de passe ne correspondent pas.";
        }
        return $errors;
    }

    private function verifierInformation($info, $errors)
    {
        if (!isset($_POST[$info]) || trim($_POST[$info]) === '') {
            $errors[$info] = $this->traduireEntree($info) . " est obligatoire.";
        }
        return $errors;
    }

    private function verificationGlobale()
    {
        $errors = [];
        $errors = $this->verifierInformation('name', $errors);
        $errors = $this->verifierInformation('firstname', $errors);
        $errors = $this->verifierInformation('adresse', $errors);
        $errors = $this->verifierInformation('code', $errors);
        $errors = $this->verifierInformation('ville', $errors);
        $errors = $this->verifierInformation('telephone', $errors);
        $errors = $this->verifierNumero($errors);
        $errors = $this->verifierInformation('email', $errors);
        $errors = $this->verifierInformation('password', $errors);
        $errors = $this->verifierPasswords($errors);
        return $errors;
    }

    private function getPassword()
    {
        $username = $_POST["email"];
        $userManager = new UserManager();
        $userPassword = $userManager->searchUser($username, "userPassword");
        return $userPassword;
    }

    private function isExistingUser($userPassword)
    {
        if (isset($userPassword[0]['userPassword'])) {
            return true;
        } else {
            return false;
        }
    }

    private function isGoodPassword($userPassword)
    {
        if ($_POST["password"] === $userPassword[0]['userPassword']) {
            return true;
        } else {
            return false;
        }
    }

    private function connectAgent()
    {
        $userPassword = $this->getPassword();
        if ($this->isExistingUser($userPassword)) {
            if ($this->isGoodPassword($userPassword)) {
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
        return [$message, $alert];
    }

    private function insertDataIntoDB()
    {
        $userManager = new UserManager();
        $userManager->insertUser([
            "firstname" => $_POST["firstname"], "lastname" => $_POST["name"],
            "address" => $_POST["adresse"], "userPassword" => $_POST["password"], "mail" => $_POST["email"],
            "fidelity" => 0, "isAdmin" => 0, "zipcode" => $_POST["code"], "city" => $_POST["ville"],
            "phone" => $_POST["telephone"]
        ]);
    }

    private function addErrorsToMessage($errors, $message)
    {
        foreach ($errors as $error) {
            array_push($message, $error);
        }
        return $message;
    }

    public function connect(): string
    {
        $message = [];
        $alert = "";
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (count($_POST) < 3) {
                // Connexion compte existant
                $resultConnexion = $this->connectAgent();
                $message = $resultConnexion[0];
                $alert = $resultConnexion[1];
                $_SESSION['user'] = $_POST["email"];
                header('Location: /');
                exit;
            } else {
                // Inscription
                $errors = $this->verificationGlobale();
                if (empty($errors)) {
                    $this->insertDataIntoDB();
                    $message = ["Bravo! Votre inscription a réussi."];
                    $alert = 'success';
                } else {
                    $message = $this->addErrorsToMessage($errors, $message);
                    $alert = 'danger';
                }
            }
        }
        return $this->twig->render('Connecter/connect.html.twig', ['message' => $message, 'alert' => $alert,
        'user' => $_SESSION['user']]);
    }
}
