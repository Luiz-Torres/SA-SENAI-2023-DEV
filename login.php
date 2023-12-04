<!doctype html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Login | LTControl</title>

        <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/sign-in/">

        

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">


        <link href="assets/css/login.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    </head>
    <body class="d-flex align-items-center py-4 bg-body-tertiary mx-auto">
        <main class="form-signin w-25 mx-auto">
            <form method="POST" action="application/fazer-login.php">
                <h1 class="h3 mb-3 fw-normal">Login</h1>

                <div class="form-floating">
                    <input type="text" class="form-control" id="txt_usuario" name="txt_usuario" placeholder="Usuário">
                    <label for="txt_usuario">Usuário</label>
                </div>
                <div class="form-floating">
                    <input type="password" class="form-control" id="txt_senha" name="txt_senha" placeholder="Senha">
                    <label for="txt_senha">Senha</label>
                </div>

                <button class="btn btn-primary w-100 py-2" type="submit">Entrar</button>
                <p class="mt-5 mb-3 text-body-secondary mx-auto"> Luiz Torres &copy; 2023</p>
            </form>
        </main>
    </body>
</html>



