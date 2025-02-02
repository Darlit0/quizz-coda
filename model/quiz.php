<?php
function getUsers(PDO $pdo): array|string
{
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query="SELECT *  FROM users ORDER BY username LIMIT 10";
    $prep = $pdo->prepare($query);
    try
    {
        $prep->execute();
    }
    catch (PDOException $e)
    {
        return "Error: ".$e->getCode() .' : '. $e->getMessage();
    }

    $res = $prep->fetchAll();
    $prep->closeCursor();

    return $res;
}

function getAllQuizzes(PDO $pdo): array {
    $query = "SELECT * FROM quiz WHERE enabled = 1";
    $stmt = $pdo->query($query);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getQuestionsByQuizId(PDO $pdo, int $quiz_id): array {
    $query = "SELECT * FROM questions WHERE quiz_id = :quiz_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':quiz_id', $quiz_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getTotalQuizzes(PDO $pdo): int {
    $query = "SELECT COUNT(*) FROM quiz WHERE enabled = 1";
    $stmt = $pdo->query($query);
    return $stmt->fetchColumn();
}
?>