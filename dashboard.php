<?php

  
  require "top_vendas.php";


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
                href="#" class="dashboard-nav-item active"><i class="fas fa-tachometer-alt"></i> dashboard
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
        <header class='dashboard-toolbar'><a href="#!" class="menu-toggle"><i class="fas fa-bars"></i></a> <h1 class="h3 mb-0 text-gray-800">Dashboard</h1></header>
        <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                       
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Venda liquida (mensal)</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= number_format($qtdVenda, 2, ",", ".");?> </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Venda receber (mensal)</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= number_format($qtdVenda1, 2, ",", ".");?> </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">                                            
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                Total Produtos</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= "{$qtd2}";?></div>
                                        </div>                                        
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pending Requests Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                DADOS A ESCOLHER</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">$EXEMPLO</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content Row -->

                    <div class="row">

                        <!-- Area Chart -->
                        <div class="col-xl-8 col-lg-7">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Top vendas mensais</h6>
                                    <div>
                                        
                                        
                                    </div>
                                </div>
                                <!-- Card Body -->


                                <div class="card-body"> 
                                 
                                  <table class="table table-borderd">
                                    <thead>
                                        <tr>
                                            <th>Produto</th>
                                            <th>Cor</th>
                                            <th>Filial</th>
                                            <th>Total</th>
                                        </tr>

                                        <?php 
                                        foreach ($array as $dados): 
                                           $qtdProd += $dados["ID"];
                                            ?>
                                            <?php echo '<tr>
                                                <td>'.$dados['APELIDO'].'</td>
                                                <td>'.$dados['COR'].'</td>
                                                <td>'.$dados['FILIAL'].'</td>
                                                <td>'.$dados['ID'].'</td>
                                            </tr>'?>
                                        <?php
                                        endforeach; 
                                        ?>
                                    </thead>          
                                   </table>               
                                <div class="chart-area">
                                     
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pie Chart -->
                        <div class="col-xl-4 col-lg-5">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">DADOS A ESCOLHER</h6>
                                    <div class="dropdown no-arrow">
                                        
                                    </div>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="chart-pie  pb-2">
                                    <table class="table table-borderd">


                                       <thead>
                                            <!--<tr>
                                                <th>Data</th>
                                                <th>Total liquido</th>
                                                <th>Total a receber</th>
                                            </tr>-->
                                            <h1>Dados a escolher</h1>



                                        </thead>
                                    </table>    



                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Content Column -->
                        <div class="col-lg-6 mb-4">

                            <!-- Project Card Example -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Projetos!</h6>
                                </div>
                                <div class="card-body">
                                    <h4 class="small font-weight-bold">EXEMPLO<span
                                            class="float-right">20%</span></h4>
                                    <div class="progress mb-4">
                                        <div class="progress-bar bg-danger" role="progressbar" style="width: 20%"
                                            aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <h4 class="small font-weight-bold">EXEMPLO <span
                                            class="float-right">40%</span></h4>
                                    <div class="progress mb-4">
                                        <div class="progress-bar bg-warning" role="progressbar" style="width: 40%"
                                            aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <h4 class="small font-weight-bold">EXEMPLO <span
                                            class="float-right">60%</span></h4>
                                    <div class="progress mb-4">
                                        <div class="progress-bar" role="progressbar" style="width: 60%"
                                            aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <h4 class="small font-weight-bold">EXEMPLO <span
                                            class="float-right">80%</span></h4>
                                    <div class="progress mb-4">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: 80%"
                                            aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <h4 class="small font-weight-bold">EXEMPLO <span
                                            class="float-right">Complete!</span></h4>
                                    <div class="progress">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 100%"
                                            aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>

                           

                        </div>

                        <div class="col-lg-6 mb-4">

                        

                            <!-- Approach -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Notas do desenvolvimento</h6>
                                </div>
                                <div class="card-body">
                                    <p>Olá! Estou trabalhando nesta página atualmente! Os nomes para visualizações não estão muito legais, estou no desenvolvimento para transcrever eles!</p>
                                    <p class="mb-0">Próxima etapa será aplicar os dados que temos em gráficos!</p>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->
</div>

</body>
</html>