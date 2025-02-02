<?php
// filepath: /c:/xampp/htdocs/quizz_coda/model/modified_quiz.php

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

function updateQuiz(PDO $pdo, int $quiz_id, string $name_quiz, string $description, int $enabled, array $questions): bool {
    try {
        $pdo->beginTransaction();

        $stmt = $pdo->prepare("UPDATE quiz SET name_quiz = ?, description = ?, enabled = ? WHERE id = ?");
        $stmt->execute([$name_quiz, $description, $enabled, $quiz_id]);

        $stmtQuestion = $pdo->prepare("UPDATE questions SET question = ?, good_response = ?, bad_responses = ?, point = ? WHERE id = ?");
        foreach ($questions as $question_id => $question_data) {
            $stmtQuestion->execute([$question_data['question'], $question_data['good_response'], $question_data['bad_responses'], $question_data['point'], $question_id]);
        }

        $pdo->commit();
        return true;
    } catch (Exception $e) {
        $pdo->rollBack();
        return false;
    }
}
?>