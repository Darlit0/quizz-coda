<?php
require '../includes/database.php';
require '../model/list.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $quiz_id = $_POST['quiz_id'] ?? null;
    $status = $_POST['status'] ?? null;

    if ($quiz_id !== null && $status !== null) {
        $status = (int)$status;
        $quiz_id = (int)$quiz_id;
        $result = updateQuizStatus($pdo, $quiz_id, $status);
        echo json_encode(['success' => $result]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid parameters']);
    }
}
?>