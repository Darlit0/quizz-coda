<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once '../includes/database.php';
require_once '../model/list.php';

if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header('Location: ../index.php');
    exit();
}

require "../_partials/errors.php";

$quizzes = getAllQuizzes($pdo);
?>

<?php require '../_partials/header.php'; ?>

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
                            <button type="button" class="btn btn-light edit-quiz" data-id="<?= $quiz['id'] ?>"><i class="fas fa-pen"></i></button>
                            <button type="button" class="btn btn-secondary toggle-status" data-id="<?= $quiz['id'] ?>" data-status="<?= $quiz['enabled'] ?>">
                                <i class="fas <?= $quiz['enabled'] ? 'fa-eye' : 'fa-eye-slash' ?>"></i>
                            </button> 
                            <button type="button" class="btn btn-danger delete-quiz" data-id="<?= $quiz['id'] ?>"><i class="fas fa-trash"></i></button>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>Aucun quiz trouvé.</p>
        <?php endif; ?>
    </div>

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

    <script src="../assets/js/services/list.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"></script>
</body>
</html>