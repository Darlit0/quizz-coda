<?php

function getQuizById(PDO $pdo, int $quiz_id): array {
    $query = "SELECT * FROM quiz WHERE id = :quiz_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':quiz_id', $quiz_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getQuestionsByQuizId(PDO $pdo, int $quiz_id): array {
    $query = "SELECT * FROM questions WHERE quiz_id = :quiz_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':quiz_id', $quiz_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>