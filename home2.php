<?php 

  if (!isset($_SESSION)):
    session_start();
endif;
  if(!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] != 'SIM'){
    header('Location: index.php?login=erro2');
  }

  
        //"CN=sistema_relatorios,OU=TI,OU=SantoGrau,DC=santograu,DC=local"
         //var_dump($_SESSION['membros']);  
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

     <link rel="icon" type="text/css" href="image/logo_santo_grau_todo.png">

     <script
          src="https://code.jquery.com/jquery-3.6.0.min.js"
          integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
          crossorigin="anonymous">
        </script>

       

     <script src="js.js"></script>
     <script src="controle.js"></script>
    

</head>
<body onLoad="loading()" style="background-color: #efefef;">
      <!--logica de pre loader -->

      <div class="box-load">             
        <div class="pre"></div>
      </div>
      <div class="conteudo-loader">

       <!-- FIM logica de pre loader -->
    <div class='dashboard'> 
    <div  class="dashboard-nav"> 
        <header ><a href="home2.php" class="menu-toggle"><i class="fas fa-bars"></i></a><a href="#" class="brand-logo"><span>Santo Grau</span></a></header>
        <nav class="dashboard-nav-list"><a href="home2.php" class="dashboard-nav-item"><i class="fas fa-home"></i>
            Home </a>

            
            <div class='dashboard-nav-dropdown'><a href="#!" class="dashboard-nav-item dashboard-nav-dropdown-toggle">
                <i class="fas fa-clipboard-list"></i> Relatórios </a>
                <div class='dashboard-nav-dropdown-menu'><!--<a
                        href="consulta_venda_produtos.php" class="dashboard-nav-dropdown-item" id="venda_por_vendedor">Venda por produto</a>--><a
                        href="consulta_quantidade_produtos.php" class="dashboard-nav-dropdown-item">Vendas Macro</a><a
                        href="consulta_quantidade_produtos_detalhada.php" class="dashboard-nav-dropdown-item">Venda detalhado</a><a
                        href="curva_abc.php" class="dashboard-nav-dropdown-item">Estoque</a><a
                        href="curva_abc_detalhado.php" class="dashboard-nav-dropdown-item">Estoque detalhado</a><a
                        href="curva_abc_outlet.php" class="dashboard-nav-dropdown-item">Estoque outlet</a><a
                        href="curva_abc_acessorio.php" class="dashboard-nav-dropdown-item">Acessórios</a><a
                        href="venda_por_vendedor.php" class="dashboard-nav-dropdown-item">Venda por vendedor</a>
                        <a
                        href="Grifes/grifes.php" class="dashboard-nav-dropdown-item">Grifes</a>
                        <a
                        href="Grifes/grifes_detalhada.php" class="dashboard-nav-dropdown-item">Grifes Detalhada</a>
                        <a
                        href="estoque_solar.php" class="dashboard-nav-dropdown-item">Estoque Solar</a>

                        <?php if($_SESSION['login'] == 'kevin.voltareli') { ?>
                            <a
                            href="cadastro_antigo.php" class="dashboard-nav-dropdown-item">Cadastro antigo</a>
                        <?php } ?>  
                </div>
            </div>

            <div class='dashboard-nav-dropdown'><a href="#!" class="dashboard-nav-item dashboard-nav-dropdown-toggle">
                <i class="fas fa-clipboard-list"></i>Grifes Loja</a>
                <div class='dashboard-nav-dropdown-menu'>
                        <a href="Grifes/grifes.php" class="dashboard-nav-dropdown-item">Grifes</a>
                        
                        <a href="Grifes/grifes_detalhada.php" class="dashboard-nav-dropdown-item">Grifes Detalhada</a>
 
                </div>
            </div>
            


            <!--<div class='dashboard-nav-dropdown'><a href="#!" class="dashboard-nav-item dashboard-nav-dropdown-toggle">
                <i class="fas fa-clipboard-list"></i> Relatórios Grife </a>
                <div class='dashboard-nav-dropdown-menu'><a
                        href="grife_venda.php" class="dashboard-nav-dropdown-item">Total produto</a><a
                        href="grife_estoque.php" class="dashboard-nav-dropdown-item">Estoque</a><a
                        href="grife_venda_vendedor.php" class="dashboard-nav-dropdown-item">Venda por vendedor</a></div>
            </div>-->
            
            <div class='dashboard-nav-dropdown'><a href="#!" class="dashboard-nav-item dashboard-nav-dropdown-toggle"><i
                    class="fas fa-money-check-alt"></i> CRM </a>
                <div class='dashboard-nav-dropdown-menu'><a
                        href="cliente_lista_detalhada.php" class="dashboard-nav-dropdown-item">Lista detalhada</a><a
                        href="cliente_novo.php" class="dashboard-nav-dropdown-item">Clientes novos</a>
                </div>
            </div>
            
          <div class="nav-item-divider"></div>
          <a
                    href="index.php" class="dashboard-nav-item"><i class="fas fa-sign-out-alt"></i> Logout </a>
        </nav>
    </div> 
    <div class='dashboard-app'>
        <header class='dashboard-toolbar'><a href="#!" class="menu-toggle"><i class="fas fa-bars"></i></a>  </header>
     

    
        <div id="conteudo" class='dashboard-content'>   

            
      
            <div  class='container'>
                <div class='card'>
                    <div class='card-header'>
                        <h2><?=($_SESSION['bemVindo']);?></h2> 
                    </div>

                  </div>
                    <div class="img_bg"> </div> 
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>