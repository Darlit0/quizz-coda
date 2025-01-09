<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<div class="container vh-100 d-flex justify-content-center align-items-center">
    <div class="row justify-content-center w-100">
        <div class="col-3">
            <div id="errors"></div>
            <form method="POST" autocomplete="off" id="login-form">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required  autocomplete="off" >
                </div>
                <div class="mb-3">
                    <label for="pass" class="form-label">Password</label>
                    <input type="password" class="form-control" id="pass" name="pass" required  autocomplete="off" >
                </div>
                <div class="d-flex justify-content-between">
                    <a href="../index.php" class="btn btn-primary">Retour</a>
                    <button type="button" class="btn btn-primary" name="valid_login" id="valid-login-btn">Valider</button>
                </div>
            </form>
        </div>
    </div>
</div>