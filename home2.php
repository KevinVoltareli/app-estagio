<?php

  session_start();
  if(!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] != 'SIM'){
    header('Location: index.php?login=erro2');
  }


?>      


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
   
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu principal</title>
    <link rel="stylesheet" type="text/css" href="css/estilo.css">
    <!-- Bootstrap core JS-->
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.0/css/all.min.css">

     <script
          src="https://code.jquery.com/jquery-3.6.0.min.js"
          integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
          crossorigin="anonymous">
        </script>

     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>   

     <script src="js.js"></script>
   

</head>
<body>
    <div class='dashboard'> 
    <div class="dashboard-nav"> 
        <header><a href="home2.php" class="menu-toggle"><i class="fas fa-bars"></i></a><a href="#" class="brand-logo"><span>Santo Grau</span></a></header>
        <nav class="dashboard-nav-list"><a href="home2.php" class="dashboard-nav-item"><i class="fas fa-home"></i>
            Home </a><a
                href="dashboard.php" class="dashboard-nav-item active"><i class="fas fa-tachometer-alt"></i> dashboard
        </a>
            <div class='dashboard-nav-dropdown'><a href="#!" class="dashboard-nav-item dashboard-nav-dropdown-toggle"><i
                    class="fas fa-clipboard-list"></i> Relatórios </a>
                <div class='dashboard-nav-dropdown-menu'><a
                        href="consulta_venda_produtos.php" class="dashboard-nav-dropdown-item">Venda por produto</a><a
                        href="consulta_quantidade_produtos.php" class="dashboard-nav-dropdown-item">Total produto</a></div>
            </div>
            
            <div class='dashboard-nav-dropdown'><a href="#!" class="dashboard-nav-item dashboard-nav-dropdown-toggle"><i
                    class="fas fa-money-check-alt"></i> EXEMPLO </a>
                <div class='dashboard-nav-dropdown-menu'><a href="#"
                                                            class="dashboard-nav-dropdown-item">All</a><a
                        href="#" class="dashboard-nav-dropdown-item">EXEMPLO</a><a
                        href="#" class="dashboard-nav-dropdown-item"> EXEMPLO</a>
                </div>
            </div>
            <a href="#" class="dashboard-nav-item"><i class="fas fa-cogs"></i> EXEMPLO </a><a
                    href="#" class="dashboard-nav-item"><i class="fas fa-user"></i> EXEMPLO </a>
          <div class="nav-item-divider"></div>
          <a
                    href="index.php" class="dashboard-nav-item"><i class="fas fa-sign-out-alt"></i> Logout </a>
        </nav>
    </div> 
    <div class='dashboard-app'>
        <header class='dashboard-toolbar'><a href="#!" class="menu-toggle"><i class="fas fa-bars"></i></a>  </header>
        <div class='dashboard-content'> 
            <div class='container'>
                <div class='card'>
                    <div class='card-header'>
                        <h1>Bem vindo!</h1>
                    </div>
                    <div class='card-body'>
                        <p>Web aplicativo versão 1.0</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>