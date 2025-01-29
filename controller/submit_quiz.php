<?php
// filepath: /c:/xampp/htdocs/quizz_coda/controller/submit_quiz.php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once '../includes/database.php';
require_once '../model/submit_quiz.php';

$quiz_id = $_POST['quiz_id'] ?? null;

if (!$quiz_id) {
    echo json_encode(['success' => false, 'message' => 'ID de quiz non fourni.']);
    exit();
}

$questions = getQuestionsByQuizId($pdo, $quiz_id);
$score = 0;
$totalPoints = 0;

foreach ($questions as $question) {
    $question_id = $question['id'];
    $user_answer = $_POST['question_' . $question_id] ?? null;

    if ($user_answer === $question['good_response']) {
        $score += $question['points'];
    }
    $totalPoints += $question['points'];
}

$correctAnswers = $score;
$wrongAnswers = $totalPoints - $score;

require '../view/submit_quiz.php';
?>