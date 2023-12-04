<?php
  session_start();
  if(!isset($_SESSION['logado']) || !$_SESSION['logado']){
    header("LOCATION: login.php");
  }
?>

<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | LTControl - EPI</title>

    <!--JQUERY AJAX --> 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <!-- Principal CSS do Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <!-- Estilos customizados para esse template -->
    <link href="assets/css/index.css" rel="stylesheet">
    
    <!--ICONS FONTAWESOME -->
    <script src="https://kit.fontawesome.com/3f654a72b6.js" crossorigin="anonymous"></script>
  </head>

  <!---->
  <body>
    <nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
      <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="index.php?tela=estoque">LTControl - EPI</a>
      <input hidden class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">
      <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap">
          <a class="nav-link" href="application/fazer-logoff.php">Sair</a>
        </li>
      </ul>
    </nav>

    <div class="container-fluid">
      <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
          <div class="sidebar-sticky">
            <ul class="nav flex-column">
              <?php
                $telaMenu = isset($_GET['tela']) ? $_GET['tela'] : '';
                $indexAtual;

                switch ($telaMenu) {
                  case 'dashboard':
                    $indexAtual = "dashboard";
                    break;
                  case 'estoque':
                    $indexAtual = "estoque";
                    break;
                  case 'cadastro-epi':
                    $indexAtual = "estoque";
                    break;
                  case 'emprestimos':
                    $indexAtual = "emprestimos";
                    break;
                  case 'novo-emprestimo':
                    $indexAtual = "emprestimos";
                    break;
                  case 'colaboradores':
                    $indexAtual = "colaboradores";
                    break;
                  case 'cadastro-colaborador':
                    $indexAtual = "colaboradores";
                    break;
                  case 'usuarios':
                    $indexAtual = "usuarios";
                    break;
                  case 'cadastro-usuario':
                    $indexAtual = "usuarios";
                    break;
                }
                  print("
                    <input type='hidden' id='actualIndex' name='actualIndex' value='{$indexAtual}'>
                  ")
              ?>
              
              <li hidden class="nav-item">
                <a class="nav-link active" href="index.php?tela=dashboard" id="indexDashboard" name="indexDashboard">
                  <span data-feather="home"></span>
                  Dashboard <span class="sr-only"></span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href='index.php?tela=estoque' id="indexEstoque" name="indexEstoque">
                  <span data-feather="box"></span>
                  EPIs - Estoque
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href='index.php?tela=emprestimos' id="indexEmprestimos" name="indexEmprestimos">
                  <span data-feather="shopping-cart"></span>
                  Empréstimos
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href='index.php?tela=colaboradores' id="indexColaboradores" name="indexColaboradores">
                  <span data-feather="briefcase"></span>
                  Colaboradores
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href='index.php?tela=usuarios' id="indexUsuarios" name="indexUsuarios">
                  <span data-feather="users"></span>
                  Usuários
                </a>
              </li>
            </ul>
          </div>
        </nav>

        <main class="col-md-9 ml-sm-auto col-lg-10 px-4">
          <?php
            // Verifcando qual tela deverá ser mostrada
            $tela = isset($_GET['tela']) ? $_GET['tela'] : '';
            switch ($tela) {
              case 'dashboard':
                include 'tela-dashboard.php';
                break;
              case 'estoque':
                include 'tela-estoque.php';
                break;
              case 'cadastro-epi':
                include 'tela-cadastro-epi.php';
                break;
              case 'emprestimos':
                include 'tela-emprestimos.php';
                break;
              case 'novo-emprestimo':
                include 'tela-cadastro-emprestimo.php';
                break;
              case 'colaboradores':
                include 'tela-colaboradores.php';
                break;
              case 'cadastro-colaborador':
                include 'tela-cadastro-colaborador.php';
                break;
              case 'usuarios':
                include 'tela-usuarios.php';
                break;
              case 'cadastro-usuario':
                include 'tela-cadastro-usuario.php';
                break;
              default:
                include 'tela-estoque.php';
            }
          ?>
        </main>
        
      </div>
    </div>

    <!-- Ícones -->
    <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
    <script>
      feather.replace()
    </script>

    <script onload="gerenciarMenu()">
      function abrirCadastroEPI() {
        window.location = "index.php?tela=cadastro-epi&codigo=novo"
      }
      function abrirCadastroColaborador() {
        window.location = "index.php?tela=cadastro-colaborador&codigo=novo"
      }
      function abrirCadastroUsuario() {
        window.location = "index.php?tela=cadastro-usuario&codigo=novo"
      }
      function novoEmprestimo() {
        window.location = "index.php?tela=novo-emprestimo&codigo=novo"
      }

    </script>
    <script src="assets/javascript/index.js"></script>
  </body>

</html>