<?php
session_start();
require '../includes/database.php';

if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header('Location: ../index.php');
    exit();
}

require "../_partials/errors.php";

$query = "SELECT * FROM quiz";
$stmt = $pdo->prepare($query);
$stmt->execute();
$quizzes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Quiz</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>

    <?php include '../_partials/navbar.php'; ?>

    <div class="container mt-4">
        <?php if (!empty($quizzes)): ?>
            <ul class="list-group">
                <?php foreach ($quizzes as $quiz): ?>
                    <li class="list-group-item <?= $quiz['enabled'] ? 'list-group-item-success' : 'list-group-item-action' ?> mb-2">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1"><?= htmlspecialchars($quiz['name_quiz']) ?></h5>
                            <small>Crée par <?= htmlspecialchars($quiz['creator']) ?></small>
                        </div>
                        <small><?= htmlspecialchars($quiz['description']) ?></small>
                        <div class="d-grid gap-2 d-md-block">
                            <button type="button" class="btn btn-light edit-quiz" data-id="<?= $quiz['id'] ?>" onclick="window.location.href='modified_quiz.php?id=<?= $quiz['id'] ?>'"><i class="fas fa-pen"></i></button>
                            <button type="button" class="btn btn-secondary toggle-status" data-id="<?= $quiz['id'] ?>" data-status="<?= $quiz['enabled'] ?>">
                                <i class="fas <?= $quiz['enabled'] ? 'fa-eye' : 'fa-eye-slash' ?>"></i>
                            </button> 
                            <button type="button" class="btn btn-danger delete-quiz" data-id="<?= $quiz['id'] ?>"><i class="fas fa-trash"></i></button>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <div class="container mt-5">
                <div class="alert alert-warning d-flex justify-content-center">Veuillez ajouter un quiz</div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Modal de confirmation de suppression -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirmation de suppression</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Êtes-vous sûr de vouloir supprimer ce quiz ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-danger" id="confirmDelete">Supprimer</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.toggle-status').forEach(function(button) {
            button.addEventListener('click', function() {
                var quizId = this.getAttribute('data-id');
                var currentStatus = this.getAttribute('data-status');
                var newStatus = currentStatus == 1 ? 0 : 1;

                fetch('../controller/list.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: 'quiz_id=' + quizId + '&status=' + newStatus
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.reload(); // Recharge la page après la mise à jour réussie
                    } else {
                        alert('Failed to update status');
                    }
                });
            });
        });

        document.querySelectorAll('.edit-quiz').forEach(function(button) {
            button.addEventListener('click', function() {
                var quizId = this.getAttribute('data-id');
                window.location.href = '../view/modified_quiz.php?quiz_id=' + quizId;
            });
        });

        var deleteQuizId = null;

        document.querySelectorAll('.delete-quiz').forEach(function(button) {
            button.addEventListener('click', function() {
                deleteQuizId = this.getAttribute('data-id');
                var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
                deleteModal.show();
            });
        });

        document.getElementById('confirmDelete').addEventListener('click', function() {
            if (deleteQuizId) {
                fetch('delete_quiz.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ id: deleteQuizId })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Erreur lors de la suppression du quiz.');
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    alert('Erreur lors de la suppression du quiz.');
                });
            }
        });
    });
    </script>
</body>
</html>