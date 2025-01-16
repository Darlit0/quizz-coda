<?php
/**
 * @var PDO $pdo
 */
require "model/list.php";
const LIST_PERSONS_ITEMS_PER_PAGE = 20;

if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
    $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest'
){

    $page = cleanString($_GET['page']) ?? 1;
    [$persons, $count] = getPersons($pdo, $page, LIST_PERSONS_ITEMS_PER_PAGE);

    if (!is_array($persons)) {
        $errors[] = $persons;
    }
    header('Content-Type: application/json');
    echo json_encode(['results' => $persons, 'count' => $count]);
    exit();
}
require "view/list.php";