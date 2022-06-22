<?php

  session_start();
  if(!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] != 'SIM'){
    header('Location: index.php?login=erro2');
  }

?>      

<html>
  <head>
    <meta charset="utf-8" />
    <title>Demonstrativo de vendas</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <style>
      .card-home {
        padding: 30px 0 0 0;
        width: 100%;
        margin: 0 auto;
      }
      .navbar {
        background: #6011a1;
      }
      .card-header {
        background: #6011a1;
      }

    </style>
  </head>

  <body>

    <nav class="navbar text-white py-3"> Santo Grau </nav>
      
    <div class="container col-4">    
      <div class="row">

        <div class="card-home">
          <div class="card">
            <div class="card-header py-1">
              <p class="text-center text-white">Menu</p>
            </div>
            <div class="card-body">
              <div class="row">
                <!-- <div class="col-6 d-flex justify-content-center">
                  <img src="formulario_abrir_chamado.png" width="70" height="70">
                </div> //PARA FUTURO UPLOAD --> 
                <div class="col-6 d-flex justify-content-center">
                  <a href="consulta_quantidade_produtos.php"> <img src="formulario_consultar_chamado.png" width="70" height="70"> </a>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
  </body>
</html>