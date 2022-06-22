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
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <!-- Bootstrap core JS-->
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>


</head>
<body>
    <input type="checkbox" id="check">
    <!--header começo-->
    <header>
        <label for="check">
            <ion-icon name="menu-outline" id="sidebar_btn"></ion-icon>
        </label>
        <div class="left">
            <h3>Ótica <span>Santo Grau</span></h3>
        </div>
        <div class="">
            <a href="index.php" class="sair_btn">Sair</a>
        </div>
    </header>
    <!--header final-->
    <!--sidebar começo-->
    <div class="sidebar">
        <center>
            
            <h2>Menu</h2>
        </center>
        <a href="home1.php"><ion-icon name="desktop-outline"></ion-icon><span>Dashboard</span></a>

        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a href="" class="nav-link dropdown-toggle" data-toggle="dropdown">Relatórios</a>
                </li>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="consulta_quantidade_produtos.php"><ion-icon name="calendar-clear-outline"></ion-icon><span>Quantidade total produto</span></a>
                         <a class="dropdown-item" href="consulta_venda_produtos.php"><ion-icon name="calendar-clear-outline"></ion-icon><span>Venda por produto</span></a>
                    </div>
            </ul>    
        </div>

        <a href="#"><ion-icon name="camera-outline"></ion-icon><span>exemplo 1</span></a>
        <a href="#"><ion-icon name="information-circle-outline"></ion-icon><span>exemplo 2</span></a>
        <a href="#"><ion-icon name="settings-outline"></ion-icon><span>exemplo 3</span></a>
    </div>
    <!--sidebar final-->
    <div class="content">
        <div class="conteudoVenda">Venda à receber: $$$$</div>
        <div class="conteudoVenda">Venda total liquida: $$$$$</div>
        <div class="conteudoVenda">Venda mensal: $$$$$</div>
    </div>
    
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
     
     <!-- Core theme JS-->
     <script src="js/scripts.js"></script>
</body>
</html>