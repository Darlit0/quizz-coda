<?php

function getCategories(PDO $pdo): array {
    $query = "SELECT * FROM category";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function addQuiz(PDO $pdo, string $name_quiz, string $description, string $creator, string $categorie, int $enabled, array $questions): bool {
    try {
        $pdo->beginTransaction();

        $stmt = $pdo->prepare("INSERT INTO quiz (name_quiz, description, creator, categorie, enabled) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$name_quiz, $description, $creator, $categorie, $enabled]);
        $quiz_id = $pdo->lastInsertId();

        $stmtQuestion = $pdo->prepare("INSERT INTO questions (quiz_id, question, good_response, bad_responses, point) VALUES (?, ?, ?, ?, ?)");
        foreach ($questions as $question_data) {
            $stmtQuestion->execute([$quiz_id, $question_data['question'], $question_data['good_response'], $question_data['bad_responses'], $question_data['point'] ?? 1]);
        }

        $pdo->commit();
        return true;
    } catch (Exception $e) {
        $pdo->rollBack();
        return false;
    }
}
?>