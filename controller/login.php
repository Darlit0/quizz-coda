<?php
require("../includes/database.php");
require("../model/login.php");

header("Content-Type: application/json");

if (!empty($_SERVER['CONTENT_TYPE']) &&
    (
        $_SERVER['CONTENT_TYPE'] === 'application/json' ||
        str_starts_with($_SERVER['CONTENT_TYPE'], 'application/x-www-form-urlencoded;charset=UTF-8')
    )
) {
    $errors = [];
    $username = $_POST['username'] ?? null;
    $pass = $_POST['password'] ?? null;

    if (null === $username || null === $pass) {
        $errors[] = "Identifiant ou mot de passe vide";
    } else {
        $connexion = connect($pdo, $username);

        if (empty($connexion)) {
            $errors[] = "Erreur d'identification, veuillez essayer à nouveau";
        } elseif (!password_verify($pass, $connexion['password'])) {
            $errors[] = "Mot de passe incorrect";
        } else {
            session_start();
            $_SESSION["auth"] = true;
            $_SESSION["username"] = $connexion['username'];
            $_SESSION["user_role"] = 'admin';
            $previousPage = $_SERVER['HTTP_REFERER'] ?? '../index.php';
            echo json_encode(['authentication' => true, 'redirect' => $previousPage]);
            exit();
        }
    }

    if (!empty($errors)) {
        echo json_encode(['errors' => $errors]);
        exit();
    }
}

echo json_encode(['errors' => ['Invalid request']]);