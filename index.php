<html>
  <head>
    <meta charset="utf-8" />
    <title>App demonstrativo de vendas</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <style type="text/css">
      .card-login {
        padding: 30px 0 0 0;
        width: 350px;
        margin: 0 auto;
        
      }
      .card-header {
        background: #4d0c5f;
      }      
      navbard-brand {
        background: #4d0c5f;
        text-decoration: none;
      }
      nav.navbar {
        background: #4d0c5f;
      }


    </style>
  </head>

  <body>

    <nav  class="navbar">
        <a class="navbar-brand text-white" href="index.php">
          Santo Grau
        </a>
    </nav>

    <div class="container">    
      <div class="row">

        <div class="card-login navbar navbar-brand">
          <div class="card">
            <div class="card-header text-white">
              Login
            </div>
            <div class="card-body">
              <form action="valida_login.php" method="post">
                <div class="form-group">
                  <input name="email" type="email" class="form-control" placeholder="E-mail">
                </div>
                <div class="form-group">
                  <input name="senha" type="password" class="form-control" placeholder="Senha">
                </div>

                <?php if(isset($_GET['login']) && $_GET['login'] == 'erro'){?>

                <div class="text-danger">
                  Usuário ou senha inválido(s)
                </div>

                <?php } ?>
                <?php if(isset($_GET['login']) && $_GET['login'] == 'erro2'){?>

                <div class="text-danger">
                  Por favor, faça login antes de acessar as páginas protegidas
                </div>

                <?php } ?>
                <button class="btn btn-lg btn-info btn-block btn-warning" type="submit">Entrar</button>
              </form>
            </div>
          </div>
        </div>
    </div>
  </body>
</html>