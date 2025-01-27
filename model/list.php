<?php

function updateQuizStatus(PDO $pdo, int $quiz_id, int $status): bool {
    $query = "UPDATE quiz SET enabled = :status WHERE id = :quiz_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':status', $status, PDO::PARAM_INT);
    $stmt->bindParam(':quiz_id', $quiz_id, PDO::PARAM_INT);
    return $stmt->execute();
}
?>