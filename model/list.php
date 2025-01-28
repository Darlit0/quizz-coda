<?php

function getAllQuizzes(PDO $pdo): array {
    $query = "SELECT * FROM quiz";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function toggleQuizStatus(PDO $pdo, int $quiz_id, int $status): bool {
    $query = "UPDATE quiz SET enabled = :status WHERE id = :quiz_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':status', $status, PDO::PARAM_INT);
    $stmt->bindParam(':quiz_id', $quiz_id, PDO::PARAM_INT);
    return $stmt->execute();
}

function deleteQuiz(PDO $pdo, int $quiz_id): bool {
    $query = "DELETE FROM quiz WHERE id = :quiz_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':quiz_id', $quiz_id, PDO::PARAM_INT);
    return $stmt->execute();
}

?>