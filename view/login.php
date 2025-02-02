<?php
   require("../_partials/errors.php")
?>

<?php require '../_partials/header.php'; ?>

<div class="container vh-100 d-flex justify-content-center align-items-center">
    <div class="row justify-content-center w-100">
        <div class="col-3">
            <div id="errors"></div>
            <form method="POST" autocomplete="off" id="login-form">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required autocomplete="off">
                </div>
                <div class="mb-3">
                    <label for="pass" class="form-label">Password</label>
                    <input type="password" class="form-control" id="pass" name="pass" required autocomplete="off">
                </div>
                <div class="d-flex justify-content-between">
                    <a href="../index.php" class="btn btn-primary">Retour</a>
                    <button type="button" class="btn btn-primary" name="valid_login" id="valid-login-btn">Valider</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="../assets/js/services/login.js" type="module"></script>
<script type="module">
    import {login} from "../assets/js/services/login.js";

    document.addEventListener('DOMContentLoaded', () => {
        const validLoginBtn = document.querySelector('#valid-login-btn')
        const loginForm = document.querySelector('#login-form')
        const errorElement = document.querySelector('#errors')

        validLoginBtn.addEventListener('click', async () => {
            if (!loginForm.checkValidity()) {
                loginForm.reportValidity()
                return false
            }

            const loginResult = await login(loginForm.elements['username'].value, loginForm.elements.pass.value)

            console.log('Login result:', loginResult);

            if (loginResult.hasOwnProperty('authentication')) {
                document.location.href = '../index.php'
            } else if (loginResult.hasOwnProperty('errors')) {
                const errors = []
                for (let i = 0; i < loginResult.errors.length; i++) {
                    errors.push(`<div class="alert alert-danger" role="alert">${loginResult.errors[i]}</div>`)
                }

                errorElement.innerHTML = errors.join('')
            }
        })
    })
</script>