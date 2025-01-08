<?php
try {
    $pdo = new PDO('mysql:host=localhost;dbname=quizz_coda','root','');
} catch (Exception $e) {
    $errors[] = "Erreur de connexion à la bdd {$e->getMessage()}";
}
?>