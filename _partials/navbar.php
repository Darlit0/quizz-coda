<nav class="navbar fixed-top navbar-expand-lg bg-body-tertiary" style="background-color:rgb(0, 0, 0);">
  <div class="container-fluid">
  <a class="navbar-brand" href="#">
    <img src="../img/quiz.png" alt="Logo" width="40" height="24" class="d-inline-block align-text-top"> Quiz Coda</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <div class="nav">
          <a class="nav-link active" aria-current="page" href="../index.php">Accueil</a>
          <?php if (isset($_SESSION['auth']) && $_SESSION['auth'] === true): ?>
            <li class="nav-item">
              <form method="POST" action="" style="display: inline;">
                <button type="submit" name="logout" class="btn btn-link nav-link">Déconnexion</button>
              </form>
            </li>
          <?php else: ?>
            <li class="nav-item">
              <a class="nav-link" href="view/login.php">Connexion</a>
            </li>
          <?php endif; ?>
          <?php if (isset($_SESSION['auth']) && $_SESSION['auth'] === true): ?>
            <li class="nav-item">
              <a class="btn btn-outline-dark me-2 <?php if (basename($_SERVER['PHP_SELF']) == 'list.php') echo 'active'; ?>" role="button" data-bs-toggle="button" href="/quizz_coda/view/list.php">Liste des quiz</a>
            </li>
            <li class="nav-item">
              <a class="btn btn-outline-dark me-2 <?php if (basename($_SERVER['PHP_SELF']) == 'add_quiz.php') echo 'active'; ?>" role="button" data-bs-toggle="button" href="/quizz_coda/view/add_quiz.php">Ajouter un quiz</a>
            </li>
          <?php endif; ?>
        </div>
      </ul>
    </div>
  </div>
</nav>
<body class="pt-5"></body>
