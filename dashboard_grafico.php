
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

     <link rel="icon" type="text/css" href="image/logo_santo_grau_todo.png">

     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.0/css/all.min.css">

     <script
          src="https://code.jquery.com/jquery-3.6.0.min.js"
          integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
          crossorigin="anonymous">
        </script>

       

     <script src="js.js"></script>
     <script src="controle.js"></script>
    

</head>
<body onLoad="loading()">
      <!--logica de pre loader -->

      <div class="box-load">             
        <div class="pre"></div>
      </div>

<div class="conteudo-loader">        
      <!-- FIM logica de pre loader -->
        
    <div class='dashboard'> 
    <div  style="z-index: 1;"class="dashboard-nav"> 
        <header><a href="home2.php" class="menu-toggle"><i class="fas fa-bars"></i></a><a href="#" class="brand-logo"><span>Santo Grau</span></a></header>
        <nav class="dashboard-nav-list"><a href="home2.php" class="dashboard-nav-item"><i class="fas fa-home"></i>
            Home </a>

            <div class='dashboard-nav-dropdown'><a href="#!" class="dashboard-nav-item dashboard-nav-dropdown-toggle">
                <i class="fas fa-tachometer-alt"></i> Dashboard </a>
                <div class='dashboard-nav-dropdown-menu'><a id="dash"
                        href="dashboard.php" class="dashboard-nav-dropdown-item" id="dash">Detalhado</a><a id="grafico"
                        href="dashboard_grafico.php" class="dashboard-nav-dropdown-item">Gráfico</a></div>
            </div>

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

                        <?php if($_SESSION['login'] == 'kevin.voltareli') { ?>
                            <a
                            href="cadastro_antigo.php" class="dashboard-nav-dropdown-item">Cadastro antigo</a>
                        <?php } ?>    

                </div>
            </div>
            
            <a href="curva_abc_prodloja.php" class="dashboard-nav-item"><i class="fas fa-tachometer-alt"></i>
            Estoque Prod Lojas </a>

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

<?php

  
  require "top_vendas.php";
  require 'grafico1.php';

                                   ?>      



        <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                       
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                       
                    <!-- Content Row -->

                    <div class="row">

                        <!-- Area Chart PRODUTOS VENDIDOS -->
                          <div class="col-xl-6 col-lg-6">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Total produto vendido mensal</h6>
                                    <div class="dropdown no-arrow">
                                        
                                    </div>
                                </div>
                                <!-- GRÁFICO 1 -->
                                <div id="grafico" class="card-body">                                   

                                      <div id="barchart_material" style="color: red; width: 100%; height: 800px;"></div>                                                      
                                </div>
                            </div>
                        </div>


                        <!--******************** GRÁFICO DE PRODUTOS ESTOQUE **********************-->
                        <div class="col-xl-6 col-lg-6">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Total produtos estoque</h6>
                                    <div class="dropdown no-arrow">
                                        
                                    </div>
                                </div>
                                <!-- GRÁFICO 2 -->
                                <div class="card-body" >
                                    

                                      <div id="barchart_material3" style="width: 100%; height: 800px;"></div>

                                                                        
                                </div>
                            </div>
                        </div>

                         <!-- GRÁFICO 3 FILIAIS -->
                        <div class="col-6">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Venda filiais</h6>
                                    <div class="dropdown no-arrow">
                                        
                                    </div>
                                </div>
                                <!-- GRÁFICO 3 -->
                                <div class="card-body">
                                    

                                             <div id="barchart_material2" style="width: 100%; height: 100%;"></div>

                                                                        
                                </div>
                            </div>
                        </div>

                        <!-- GRÁFICO 4 QUANTIDADE DE CLIENTES NOVOS -->
                        <div class="col-6">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Quantidade de clientes novos</h6>
                                    <div class="dropdown no-arrow">
                                        
                                    </div>
                                </div>
                                <!-- GRÁFICO 4 -->
                                <div class="card-body">                                    
                                    <div id="piechart" style="width: 100%; height: 300px;"></div>
                                     <?= $qtdNovo ?> <br>
                                     <?= $qtdAntigo ?>

                                </div>
                            </div>
                        </div>

                        
                    </div>



                    <!-- Content Row -->
                    <div class="row">

                        <!-- Content Column -->
                        <div class="col-lg-6 mb-4">

                            
                            

                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->
</div>
</div>
</body>
</html>