<?php
    session_start();
    require 'includes/database.php';

    if (isset($_POST['logout'])) {
        session_unset();
        session_destroy();
        header('Location: index.php');
        exit();
    }
?>

    <?php require '_partials/header.php'; ?>

    <?php include '_partials/navbar.php'; ?>

    <div class="container" style="margin-top: 20px;">
        <?php require 'view/quiz.php'; ?>
    </div>

    <script src="includes/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>