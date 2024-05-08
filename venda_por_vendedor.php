<?php

  if (!isset($_SESSION)):
    session_start();
endif;
  if(!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] != 'SIM'){
    header('Location: index.php?login=erro2');
  }

?>         

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Demonstrativo de vendas</title>

         <!--Bootstrap-->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <!--Icone pagina-->
        <link rel="icon" type="text/css" href="image/logo_santo_grau_todo.png">
        <!--Font awesome-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
        <!--Css -->
        <link rel="stylesheet" type="text/css" href="css/estiloRelatorios.css">

       <style type="text/css">
       body {
        color:#6011a1;
       }
       tr {
        color:#6011a1;
       }
       button {
        margin-top: 30px ;
       
       }
     </style>
    </head>
    <body>

        <!-- TOGGLE MENU -->
        <input style="-webkit-appearance: none;
                       visibility: hidden;
                       display: none;" type="checkbox" id="check" name="">

        
    <div class="container_toggle">
        <label for="check">
            <span class="fas fa-times" id="times"></span>
            <span class="fas fa-bars" id="bars"></span>
        </label>
        <div class="head">Menu</div>
            <ol>
                <li><a href="consulta_quantidade_produtos.php"><i class="fa-solid fa-sack-dollar"></i>Vendas Macro</a></li>
                <li><a href="consulta_quantidade_produtos_detalhada.php"><i class="fa-solid fa-circle-info"></i>Venda detalhado</a></li>
                <li><a href="curva_abc.php"><i class="fa-solid fa-shapes"></i>Estoque</a></li>
                <li><a href="curva_abc_detalhado.php"><i class="fa-solid fa-shapes"></i>Estoque detalhado</a></li>
                <li><a href="curva_abc_outlet.php"><i class="fa-solid fa-shapes"></i>Estoque outlet</a></li>
                <li><a href="curva_abc_acessorio.php"><i class="fa-solid fa-shapes"></i>Acessórios</a></li>
                <li><a href="venda_por_vendedor.php"><i class="fa-sharp fa-solid fa-person"></i>Venda vendedor</a></li>

                <?php if($_SESSION['login'] == 'kevin.voltareli') { ?>
                    <li><a href="cadastro_antigo.php"><i class="fa-solid fa-person-cane"></i>Cadastro antigo</a></li>  
                <?php } ?>    
                
                <li><a href="home2.php"><i class="fa-solid fa-x"></i>Sair</a></li>        
            </ol>        
    </div>   
        <!-- FIM TOGGLE MENU -->
  

    <div class="container"> 
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card mt-5">                        
                        <div class="card-header"> 
                                                 
                            <h4>Venda por vendedor</h4>
                        </div>
                        <div class="card-body">
                        
                            <form action="" method="post">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Data inicial</label>
                                            <input class="form-control" name="fdate" type="date" maxlength="10" size="10" required value="<?php if(isset($_POST['fdate'])){echo $_POST['fdate'];}?>" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">  
                                            <label>Data final</label>
                                            <input class="form-control" name="tdate" type="date" maxlength="10" size="10" required value="<?php if(isset($_POST['tdate'])){echo $_POST['tdate'];}?>" />
                                        </div>
                                    </div>
                        
                                    <div class="col-md-4">
                                        <div  class="form-group">                                     
                                          <button type="submit" class="btn btn-md btn-warning">Pesquisar</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="card mt-4">
                    <div class="card-body">
                        <table class="table table-borderd">
                            <thead>
                                <tr>
                                    <th>Nome</th> 
                                    <th>Total</th>                                   
                                </tr>
                            </thead>
                            <tbody>

       
        <?php
        $post = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (is_array($post)):
            try {
                $conn = new PDO("firebird:dbname=C:\SavWinRevo\Servidor\DataBase\BDSAVWINREVO.FDB", "SYSDBA", "masterkey");
            } catch (PDOException $e) {
                echo '<pre>';
                print_r($e);
                echo '</pre>';
                die(); //deu ruim
            }
            $where = "WHERE a.PEDDATADIGITACAO >=  '" . $post['fdate'] . "'";
            if(!empty($post['tdate'])):
            $where .= " and a.PEDDATADIGITACAO <=  '". $post['tdate'] ." 23:59:59'";
            
            endif;

              
            
            $read = $conn->prepare("SELECT c.PESNOME AS NOME, sum(a.PEDVALORLIQUIDO) AS LIQUIDO
                                    FROM TB_PED_PEDIDO a
                                    INNER JOIN TB_VND_VENDEDOR b ON b.VNDID = a.VNDID_PRIMEIRO
                                    INNER JOIN TB_PES_PESSOA c ON c.PESID = b.PESID 
                                    {$where}
                                    AND a.FILID_FILIAL = '5'
                                    AND a.PEDDATACANCELAMENTO IS NULL
                                    GROUP BY c.PESNOME 
                                    ORDER BY liquido desc");
                               

            $read->setFetchMode(PDO::FETCH_ASSOC);
            $read->execute();
            $array = $read->fetchAll();
            if (count($array) == 0):
                echo "Nenhum registro localizado";
            endif;
            $qtd = 0;

            ?>
            
                <?php 
                foreach ($array as $dados): 
                $qtd += $dados["LIQUIDO"];
                
                    ?>
                    <tr>
                        <td><?= $dados["NOME"]; ?></td>
                        <td><?= number_format($dados["LIQUIDO"], 2, ",", "."); ?></td>

                    </tr>
                <?php
                endforeach; 
                echo "<h5>Total geral: {$qtd}</h5>";
                ?>
            </table>
            <?php
            
        endif;
        ?>


    </body>
</html>
