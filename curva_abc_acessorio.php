<?php

  if (!isset($_SESSION)):
    session_start();
endif;
  if(!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] != 'SIM'){
    header('Location: index.php?login=erro2');
  }

$data = date('Y-m-t');
   
   
   $data = explode('-', $data);  

    $dia = $data [2];
    $mes = $data [1];
    $ano = $data [0]; 
    
$vendaInicio = $ano."-".$mes."-"."01";
$vendaFim = $ano."-".$mes."-".$dia;

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
                            <h4>Estoque e venda acessórios</h4>
                        </div>
                        <div class="card-body">
                        
                            <form action="" method="post">
                                <div class="row">

                                    <!--<div class="col-md-4 ">
                                        <div class="form-group">  
                                            <label for="lista">Selecione o mês do estoque</label><br>
                                                <select class="col-md-12" id="lista" name="DATAS" >
                                                    <option ><?php if(isset($_POST['DATAS'])){echo $_POST['DATAS'];}?></option>
                                                    <option value="2022-01">Janeiro</option>
                                                    <option value="2022-02">Fevereiro</option>
                                                    <option value="2022-03">Março</option>
                                                    <option value="2022-04">Abril</option>
                                                    <option value="2022-05">Maio</option>
                                                    <option value="2022-06">Junho</option>
                                                    <option value="2022-07">Julho</option>
                                                    <option value="2022-08">Agosto</option>
                                                    <option value="2022-09">Setembro</option>
                                                    <option value="2022-10">Outubro</option>
                                                    <option value="2022-11">Novembro</option>
                                                    <option value="2022-12">Dezembro</option>
                                                </select>
                                        </div>
                                    </div>-->                            
                                    

                                    <div class="col-md-6 ">
                                        <div class="form-group">  
                                            <label>Pesquisar por produto</label><br>
                                                <input value="<?php if(isset($_POST['buscar'])){echo $_POST['buscar'];}?>" type="text" id="buscar" name="buscar">
                                        </div>
                                    </div>

                                    <div class="col-md-4 ">
                                        <div class="form-group">  
                                            <label>Selecione a filial (estoque)</label><br>
                                                <select class="col-md-12" id="filiais" name="filial">
                                                    <option value="">
                                                        <?php 
                                                          if(isset($_POST['filial'])){
                                                            if($_POST['filial'] == '20279') {
                                                                echo 'Galao';
                                                            } elseif($_POST['filial'] == '20281') {
                                                                echo 'Aggio';
                                                            } elseif($_POST['filial'] == '31823') {
                                                                echo 'E-commerce';
                                                            } elseif($_POST['filial'] == '74061') {
                                                                echo 'Site';
                                                            }
                                                        }
                                                        ?>
                                                            
                                                    </option>
                                                    <option default-value="">--Selecione para todos--</option>
                                                    <option value="20279">Galao</option>
                                                    <option value="20281">Aggio</option>
                                                    <option value="31823">E-commerce</option>
                                                    <option value="74061">Site</option>
                                                </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Data inicial venda - Produto</label>
                                            <input class="form-control" name="fdate" type="date" maxlength="10" size="10" 
                                            required value="<?php if(isset($_POST['fdate'])){echo $_POST['fdate'];} else{echo $vendaInicio; }?>" 
                                            />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">  
                                            <label>Data final venda - Produto</label>
                                            <input class="form-control" name="tdate" type="date" maxlength="10" size="10" required value="<?php if(isset($_POST['tdate'])){echo $_POST['tdate'];}else{echo $vendaFim; }?>" 
                                            />
                                        </div>
                                    </div>
                                

                                    <div class="col-md-4 pb-0">
                                        <div  class="form-group">                                     
                                          <button type="submit" class="btn btn-md btn-warning">Pesquisar</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div style="font-size: 15px " class="container">                        
                    <div class="row">
                    <div class="col-6">
                    <div class="card mt-4">
                    <div class="card-body">
                        <table class="table table-borderd">
                            <thead>
                                <tr>
                                    <th>Produto - Estoque</th>
                                    <th>Quantidade</th>
                                </tr>
                            </thead>
                            <tbody>
                        </div>
                    </div>
       
        <?php // ************ QUERY ESTOQUE ******************
        $post = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        @$buscar = strtoupper("%".($_POST['buscar'])."%");
        

        if (is_array($post)):
            try {
                $conn = new PDO("firebird:dbname=C:\SavWinRevo\Servidor\DataBase\BDSAVWINREVO.FDB", "SYSDBA", "masterkey");
            } catch (PDOException $e) {
                echo '<pre>';
                print_r($e);
                echo '</pre>';
                die(); //deu ruim
            }
            $where = "WHERE a.MECDATALOTE  >= '2018-01-01'";            
            $where .= " and a.MECDATALOTE <=  '2022-12-31'";
             if($post['filial'] == '20281' || $post['filial'] == '31823' || $post['filial'] == '20279' || $post['filial'] == '20279'):
            @$where .= " AND c.PESID = '" . $post['filial'] . "'";   
            endif;
            if(!empty($post['buscar'])):
            @$where .= "AND e.NOME LIKE :buscar ";            
            endif;

            
            
            $read = $conn->prepare("SELECT e.NOME as NOME, SUM(a.MECQUANTIDADE1) AS QTD  
                                    FROM TB_MEC_MATESTCONTROLE a 
                                    INNER JOIN TB_MAT_MATERIAL b ON b.MATID = a.MATID 
                                    INNER JOIN TB_FIL_FILIAL c ON c.FILID = a.FILID 
                                    INNER JOIN TB_PES_PESSOA d ON d.PESID = c.PESID 
                                    INNER JOIN TB_ACESSORIO e ON e.MATFANTASIA = b.MATFANTASIA 
                                    {$where}
                                    AND b.NCMID = '56' 
                                    GROUP BY e.NOME
                                    ORDER BY QTD desc ");

            $read->bindParam(':buscar', $buscar, PDO::PARAM_STR);
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
                $qtd += $dados["QTD"];
                    ?>
                    <tr>
                        <td><?= $dados["NOME"]; ?></td>                     
                        <td><?= number_format($dados["QTD"], 0, ",", "."); ?></td>
                    </tr>
                <?php
                endforeach; 
                echo "<h5>Total estoque: {$qtd}</h5>";
                ?>

            </table>
            </div>
            </div>
            </div>
            <?php
          
        endif;
        ?>

        <!-- ****************** QUERY BUSCAR VENDA PRODUTO ******************** -->
        
          <div class="card mt-4">
                    <div class="card-body">
                        <table class="table table-borderd">
                            <thead>
                                <tr>
                                    <th>Produto - Venda</th>  
                                    <th>Tipo venda</th>     
                                    <th>Quantidade</th>

        <?php
        $post = filter_input_array(INPUT_POST, FILTER_DEFAULT);
       @$buscar = strtoupper("%".($_POST['buscar'])."%");

        if (is_array($post)):
            try {
                $conn = new PDO("firebird:dbname=C:\SavWinRevo\Servidor\DataBase\BDSAVWINREVO.FDB", "SYSDBA", "masterkey");
            } catch (PDOException $e) {
                echo '<pre>';
                print_r($e);
                echo '</pre>';
                die(); //deu ruim
            }
            $where1 = "WHERE a.VENDATAHORAFATURAMENTO >=  '" . $post['fdate'] . "'";
            if(!empty($post['tdate'])):
            $where1 .=  "and a.VENDATAHORAFATURAMENTO <=  '". $post['tdate'] ." 23:59'";
            endif;

            /*if($post['filial'] == '20281' || $post['filial'] == '31823' || $post['filial'] == '20279' || $post['filial'] == '20279'):
            @$where1 .= " AND q.PESID = '" . $post['filial'] . "'";   
            endif;*/

            if(!empty($post['buscar'])):
            @$where1 .= "AND h.NOME LIKE :buscar ";            
            endif;
            
            $read = $conn->prepare("SELECT  h.NOME AS NOME, sum(l.PICQTDE) AS TOTAL,j.TVNDESCRICAO AS TIPOVENDA
                            FROM TB_VEN_VENDA a
                            INNER JOIN TB_VPE_VENDAPEDIDOS b ON b.VENID_VENDA = a.VENID 
                            INNER JOIN TB_IPD_ITEMPEDIDO c ON c.PEDID_PEDIDO = b.PEDID_PEDIDO 
                            INNER JOIN TB_MAT_MATERIAL d ON c.MATID_PRODUTO = d.MATID 
                            INNER JOIN TB_NCM_NCM e ON e.NCMID = d.NCMID 
                            INNER JOIN TB_AAT_ATRIBUTOS f ON f.MATID = d.MATID  
                            INNER JOIN TB_ACESSORIO h ON h.MATFANTASIA  = d.MATFANTASIA
                            INNER JOIN TB_PED_PEDIDO i ON i.PEDID = c.PEDID_PEDIDO
                            INNER JOIN TB_TVN_TIPOVENDA j ON j.TVNID = i.TVNID
                            INNER JOIN TB_PIC_PEDIDOITEMCLIENTE l ON l.IPDID  = c.IPDID
                            {$where1}
                            AND i.PEDDATACANCELAMENTO IS NULL
                            AND e.NCMID = '56' 
                            GROUP BY  h.NOME, l.PICQTDE,j.TVNDESCRICAO
                            ORDER BY total DESC ");


            $read->bindParam(':buscar', $buscar, PDO::PARAM_STR);
            $read->setFetchMode(PDO::FETCH_ASSOC);            
            $read->execute();   
            $array = $read->fetchAll();
            if (count($array) == 0):
                echo "<h6>Nenhum registro localizado</h6>";
            endif;  
            $qtd = 0;

            ?>
            
                <?php 

                foreach ($array as $dados): 
                $qtd += $dados["TOTAL"];                
                    ?>
                    <tr>
                        <td><?= $dados["NOME"]; ?></td>
                        <td><?= $dados["TIPOVENDA"]; ?></td>
                        <td><?= number_format($dados["TOTAL"], 0, ",", "."); ?></td>
                    </tr>                    
                <?php
                endforeach;
                 echo "<h5>Total produtos vendidos: {$qtd}<h5/>"; 


                ?>
              </table>
            <?php
          
        endif;
        ?>



    </body>
</html>
