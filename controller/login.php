<?php
/**
 * @var PDO $pdo
 */
require("model/login.php");

if (!empty($_SERVER['CONTENT_TYPE']) &&
    (
        $_SERVER['CONTENT_TYPE'] === 'application/json' ||
        str_starts_with($_SERVER['CONTENT_TYPE'], 'application/x-www-form-urlencoded;charset=UTF-8')
    )
) {
    $errors = [];
    $username = $_POST['username'] ?? null;
    $pass = $_POST['password'] ?? null;

    if(null === $username || null === $pass) {
        $errors[] = "identifiant ou mot de passe vide";
    } else {
        $connexion = connect($pdo, $username, $pass);

        if (empty($connexion) || !password_verify($pass, $connexion['password'])) {
            $errors[] = "Erreur d'identification, veuillez essayer à nouveau";
        } elseif(0 === $connexion['enabled']) {
            $errors[] = "Ce compte est désactivé";
        } else {
            $_SESSION["auth"] = true;
            $_SESSION["username"] = $connexion['username'];
            header("Content-Type: application/json");
            echo json_encode(['authentication' => true]);
            exit();
        }
    }

    if (!empty($errors)) {
        header("Content-Type: application/json");
        echo json_encode(['errors' => $errors]);
        exit();
    }
}

require("view/login.php");