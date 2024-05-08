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
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <!--Icone pagina-->
        <link rel="icon" type="text/css" href="image/logo_santo_grau_todo.png">
        <!--Font awesome-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
        <!--Css -->
        <link rel="stylesheet" type="text/css" href="css/estiloRelatorios.css">
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <!-- Javascript -->
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
     
        
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

                        <!-- MODAL RELATORIOS QTD FORMATO POR GRIFE-->

                     
         <!-- Button trigger modal -->
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalLong">
  Qtd cor por grife
</button>

<!-- Modal -->
<div class="modal fade bd-example-modal-l" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Qtd cor por grife</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
     

    <!-- ****************** QUERY BUSCAR VENDA PRODUTO ******************** -->
        
  
      <?php
       
            try {
                $conn = new PDO("firebird:dbname=C:\SavWinRevo\Servidor\DataBase\BDSAVWINREVO.FDB", "SYSDBA", "masterkey");
            } catch (PDOException $e) {
                echo '<pre>';
                print_r($e);
                echo '</pre>';
                die(); //deu ruim
            }
            
            $read = $conn->prepare("SELECT e.GRIFE AS GRIFE ,e.COR AS COR, count(e.COR) AS qtdCor
                                FROM TB_MEC_MATESTCONTROLE a 
                                INNER JOIN TB_MAT_MATERIAL b ON b.MATID = a.MATID
                                INNER JOIN TB_FIL_FILIAL c ON c.FILID = a.FILID
                                INNER JOIN TB_PES_PESSOA d ON d.PESID = c.PESID 
                                INNER JOIN TB_DRIP_APELIDO e ON e.MATFANTASIA = b.MATFANTASIA 
                                WHERE a.MECDATALOTE  >= '2010-01-01' AND a.MECDATALOTE <= '2024-12-31'
                                AND NOT b.NCMID = '56' 
                                AND NOT b.NCMID = '65'
                                AND NOT b.NCMID = '66'
                                AND NOT b.NCMID = '68'
                                AND NOT b.NCMID = '71'
                                AND NOT b.NCMID = '75'
                                GROUP BY e.GRIFE, e.cor
                                ORDER BY GRIFE, qtdCor desc");

            $read->setFetchMode(PDO::FETCH_ASSOC);            
            $read->execute();   
            $array = $read->fetchAll();       

            ?>
                <table class="table table-borderd">
                  <thead>
                    <tr>
                      <th>Produto - Venda</th> 
                      <th>Cor</th>                    
                      <th>Quantidade</th>
                

                <?php 

                foreach ($array as $dados):            
                    ?>


                    <tr>
                        <td><?= $dados["GRIFE"]; ?></td>
                        <td><?= $dados["COR"]; ?></td>
                        <td><?= number_format($dados["QTDCOR"], 0, ",", "."); ?></td>
                    </tr>                    
                <?php
                endforeach;               

                ?>
                 </tr>
                  </thead>                                    
                </table>
            <?php
          
        ?>



      </div>
     
        <button type="button" class="btn btn-success" data-dismiss="modal">Fechar</button>
     
    </div>
  </div>
</div>
        

                        <!-- FIM MODAL RELATORIOS FORMATO POR GRIFE-->


                         <!-- MODAL SEXO POR GRIFE-->

                     
         <!-- Button trigger modal -->
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#sexoPorGrife">
  Qtd genero por grife
</button>

<!-- Modal -->
<div class="modal fade bd-example-modal-l" id="sexoPorGrife" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Qtd genero por grife</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
     

    <!-- ****************** QUERY BUSCAR VENDA PRODUTO ******************** -->
        
  
      <?php
       
            try {
                $conn = new PDO("firebird:dbname=C:\SavWinRevo\Servidor\DataBase\BDSAVWINREVO.FDB", "SYSDBA", "masterkey");
            } catch (PDOException $e) {
                echo '<pre>';
                print_r($e);
                echo '</pre>';
                die(); //deu ruim
            }
            
            $read = $conn->prepare("SELECT e.GRIFE AS GRIFE,e.SUB_LINHA2 AS SEXO,sum(a.MECQUANTIDADE1) AS QTDSEXO,e.LINHA AS MATERIAL
                                    FROM TB_MEC_MATESTCONTROLE a 
                                    INNER JOIN TB_MAT_MATERIAL b ON b.MATID = a.MATID
                                    INNER JOIN TB_FIL_FILIAL c ON c.FILID = a.FILID
                                    INNER JOIN TB_PES_PESSOA d ON d.PESID = c.PESID 
                                    INNER JOIN TB_DRIP_APELIDO e ON e.MATFANTASIA = b.MATFANTASIA 
                                    WHERE a.MECDATALOTE  >= '2010-01-01' AND a.MECDATALOTE <= '2024-12-31'
                                    AND NOT b.NCMID = '56' 
                                    AND NOT b.NCMID = '65'
                                    AND NOT b.NCMID = '66'
                                    AND NOT b.NCMID = '68'
                                    AND NOT b.NCMID = '71'
                                    AND NOT b.NCMID = '75'
                                    GROUP BY e.GRIFE, e.SUB_LINHA2,e.LINHA
                                    ORDER BY grife, qtdSexo desc");

            $read->setFetchMode(PDO::FETCH_ASSOC);            
            $read->execute();   
            $array = $read->fetchAll();       

            ?>
                <table class="table table-borderd">
                  <thead>
                    <tr>
                      <th>Produto - Venda</th> 
                      <th>Gênero</th>         
                      <th>Material</th>                   
                      <th>Quantidade</th>
                

                <?php 

                foreach ($array as $dados):            
                    ?>


                    <tr>
                        <td><?= $dados["GRIFE"]; ?></td>
                        <td><?= $dados["SEXO"]; ?></td>
                        <td><?= $dados["MATERIAL"]; ?></td>
                        <td><?= number_format($dados["QTDSEXO"], 0, ",", "."); ?></td>
                    </tr>                    
                <?php
                endforeach;               

                ?>
                 </tr>
                  </thead>                                    
                </table>
            <?php
          
        ?>



      </div>
     
        <button type="button" class="btn btn-success" data-dismiss="modal">Fechar</button>
     
    </div>
  </div>
</div>
            <!-- FIM MODAL RELATORIOS FORMATO POR GRIFE-->


             <!-- MODAL FORMATO POR GRIFE -->
                     
         <!-- Button trigger modal -->
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#formatoPorGrife">
  Qtd formatos por grife
</button>

<!-- Modal -->
<div class="modal fade bd-example-modal-l" id="formatoPorGrife" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Qtd formatos por grife</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
     

    <!-- ****************** QUERY BUSCAR VENDA PRODUTO ******************** -->
        
  
      <?php
       
            try {
                $conn = new PDO("firebird:dbname=C:\SavWinRevo\Servidor\DataBase\BDSAVWINREVO.FDB", "SYSDBA", "masterkey");
            } catch (PDOException $e) {
                echo '<pre>';
                print_r($e);
                echo '</pre>';
                die(); //deu ruim
            }
            
            $read = $conn->prepare("SELECT e.GRIFE AS grife ,e.SUB_LINHA1 as FORMATO, sum(a.MECQUANTIDADE1) AS QTDFORMATO 
                                    FROM TB_MEC_MATESTCONTROLE a 
                                    INNER JOIN TB_MAT_MATERIAL b ON b.MATID = a.MATID
                                    INNER JOIN TB_FIL_FILIAL c ON c.FILID = a.FILID
                                    INNER JOIN TB_PES_PESSOA d ON d.PESID = c.PESID 
                                    INNER JOIN TB_DRIP_APELIDO e ON e.MATFANTASIA = b.MATFANTASIA 
                                    WHERE a.MECDATALOTE  >= '2010-01-01' AND a.MECDATALOTE <= '2024-12-31'
                                    AND NOT b.NCMID = '56' 
                                    AND NOT b.NCMID = '65'
                                    AND NOT b.NCMID = '66'
                                    AND NOT b.NCMID = '68'
                                    AND NOT b.NCMID = '71'
                                    AND NOT b.NCMID = '75'
                                    GROUP BY e.GRIFE, e.SUB_LINHA1
                                    ORDER BY grife, QTDFORMATO desc");

            $read->setFetchMode(PDO::FETCH_ASSOC);            
            $read->execute();   
            $array = $read->fetchAll();       

            ?>
                <table class="table table-borderd">
                  <thead>
                    <tr>
                      <th>Produto - Venda</th> 
                      <th>Formato</th>                    
                      <th>Quantidade</th>
                

                <?php 

                foreach ($array as $dados):            
                    ?>


                    <tr>
                        <td><?= $dados["GRIFE"]; ?></td>
                        <td><?= $dados["FORMATO"]; ?></td>
                        <td><?= number_format($dados["QTDFORMATO"], 0, ",", "."); ?></td>
                    </tr>                    
                <?php
                endforeach;               

                ?>
                 </tr>
                  </thead>                                    
                </table>
            <?php
          
        ?>


      </div>
     
        <button type="button" class="btn btn-success" data-dismiss="modal">Fechar</button>
     
    </div>
  </div>
</div>        
                        <!-- FIM MODAL RELATORIOS-->

                         <!-- MODAL MATERIAL POR GRIFE -->
                     
         <!-- Button trigger modal -->
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#materialPorGrife">
  Qtd material por grife
</button>

<!-- Modal -->
<div class="modal fade bd-example-modal-l" id="materialPorGrife" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Qtd formatos por grife</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
     

    <!-- ****************** QUERY BUSCAR VENDA PRODUTO ******************** -->
        
  
      <?php
       
            try {
                $conn = new PDO("firebird:dbname=C:\SavWinRevo\Servidor\DataBase\BDSAVWINREVO.FDB", "SYSDBA", "masterkey");
            } catch (PDOException $e) {
                echo '<pre>';
                print_r($e);
                echo '</pre>';
                die(); //deu ruim
            }
            
            $read = $conn->prepare("SELECT e.GRIFE AS GRIFE ,e.LINHA AS MATERIAL, sum(a.MECQUANTIDADE1) AS QTDMATERIAL 
                                    FROM TB_MEC_MATESTCONTROLE a 
                                    INNER JOIN TB_MAT_MATERIAL b ON b.MATID = a.MATID
                                    INNER JOIN TB_FIL_FILIAL c ON c.FILID = a.FILID
                                    INNER JOIN TB_PES_PESSOA d ON d.PESID = c.PESID 
                                    INNER JOIN TB_DRIP_APELIDO e ON e.MATFANTASIA = b.MATFANTASIA 
                                    WHERE a.MECDATALOTE  >= '2010-01-01' AND a.MECDATALOTE <= '2024-12-31'
                                    AND NOT b.NCMID = '56' 
                                    AND NOT b.NCMID = '65'
                                    AND NOT b.NCMID = '66'
                                    AND NOT b.NCMID = '68'
                                    AND NOT b.NCMID = '71'
                                    AND NOT b.NCMID = '75'
                                    GROUP BY e.GRIFE, e.LINHA
                                    ORDER BY GRIFE, QTDMATERIAL desc");

            $read->setFetchMode(PDO::FETCH_ASSOC);            
            $read->execute();   
            $array = $read->fetchAll();       

            ?>
                <table class="table table-borderd">
                  <thead>
                    <tr>
                      <th>Grife</th> 
                      <th>Material</th>                    
                      <th>Quantidade</th>
                

                <?php 

                foreach ($array as $dados):            
                    ?>


                    <tr>
                        <td><?= $dados["GRIFE"]; ?></td>
                        <td><?= $dados["MATERIAL"]; ?></td>
                        <td><?= number_format($dados["QTDMATERIAL"], 0, ",", "."); ?></td>
                    </tr>                    
                <?php
                endforeach;               

                ?>
                 </tr>
                  </thead>                                    
                </table>
            <?php
          
        ?>




      </div>
     
        <button type="button" class="btn btn-success" data-dismiss="modal">Fechar</button>
     
    </div>
  </div>
</div>        

                        <!-- FIM MODAL RELATORIOS-->




            <div class="row justify-content-center">                
                <div class="col-md-12">



                    <div class="card mt-5">
                        <div class="card-header">
                            <h4>Estoque</h4>
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
                                                <label> Se quiser pesquisar lojas separadamente, escolha <strong>"Selecione a filial"</strong></label>
                                        </div>
                                    </div>

                              

                                    <div class="col-md-2 ">
                                        <div class="form-group">  
                                            <label>Selecione a grife</label><br>
                                                <select class="col-md-12" id="grifes" name="grifes">
                                                    <option value="">
                                                        <?php 
                                                          if(isset($_POST['grife'])){
                                                             if($_POST['grife'] == 'CLIPON') {
                                                                echo 'CLIPON';
                                                            } elseif($_POST['grife'] == 'DRIP') {
                                                                echo 'DRIP';
                                                            } elseif($_POST['grife'] == 'SANTO GRAU PRIME') {
                                                                echo 'SANTO GRAU PRIME';
                                                            } elseif($_POST['grife'] == 'SUNGLASS') {
                                                                echo 'SUNGLASS';
                                                            }
                                                        }
                                                        ?>
                                                            
                                                    </option>
                                                    <option default-value="">--Selecione para todos--</option>
                                                    <option value="CLIPON">Clipon</option>
                                                    <option value="DRIP">Drip</option>
                                                    <option value="SANTO GRAU PRIME">Santo Grau Prime</option>
                                                    <option value="SUNGLASS">Sunglass</option>
                                                </select>
                                        </div>
                                    </div>

                                    <div class="col-md-2 ">
                                        <div class="form-group">  
                                            <label>Selecione a filial</label><br>
                                                <select class="col-md-12" id="filiais" name="filial">
                                                    <option value="">
                                                        <?php 
                                                          if(isset($_POST['filial'])){
                                                            if($_POST['filial'] == '2') {
                                                                echo 'Galao';
                                                            } elseif($_POST['filial'] == '4') {
                                                                echo 'Aggio';
                                                            } elseif($_POST['filial'] == '5') {
                                                                echo 'E-commerce';
                                                            } elseif($_POST['filial'] == '7') {
                                                                echo 'Site';
                                                            }
                                                        }
                                                        ?>
                                                            
                                                    </option>
                                                    <option default-value="">--Selecione para todos--</option>
                                                    <option value="2">Galao</option>
                                                    <option value="4">Aggio</option>
                                                    <option value="5">E-commerce</option>
                                                    <option value="7">Site</option>
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

                                    <div class="col-md-2">
                                        <div class="form-group">  
                                            <label>Receituário</label>
                                            <input type="checkbox" name="receituario" value="ARMACAO P/ OCULOS">
                                            
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">  
                                            <label>Oculos de sol</label>
                                            <input type="checkbox" name="oculosDeSol" value="OCULOS DE SOL">
                                            
                                        </div>
                                    </div>
                                
    <div class="col-md-4 pb-0">
        <div class="form-group">                                     
            <button type="submit" class="btn btn-md btn-warning">Pesquisar</button>
        </div>
    </div>
</form>

                                
                                </div>
                           

                             
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
            $where = "WHERE a.MECDATALOTE  >= '2010-01-01'";            
            $where .= " and a.MECDATALOTE <=  '2024-12-31'";
             if($post['filial'] == '1' || $post['filial'] == '2' || $post['filial'] == '4' || $post['filial'] == '5'):
            @$where .= " AND a.FILID = '" . $post['filial'] . "'";   
            endif;

             if($post['grifes'] == 'CLIPON' || $post['grifes'] == 'DRIP' || $post['grifes'] == 'SANTO GRAU PRIME' || $post['grifes'] == 'SUNGLASS'):
            @$where .= " AND e.GRIFE = '" . $post['grifes'] . "'";   
            endif;

            if(!empty($post['buscar'])):
            @$where .= "AND e.NOME_APELIDO LIKE :buscar ";            
            endif;

             if(!empty($post['receituario'])):
            @$where .= "AND b.MATDESCRICAO = '" . $post['receituario'] . "' ";            
            endif;
          
            if(!empty($post['oculosDeSol'])):
            @$where .= "AND b.MATDESCRICAO = '" . $post['oculosDeSol'] . "' ";            
            endif;
            
            
            $read = $conn->prepare("SELECT e.NOME_APELIDO as APELIDO, e.ARMDESCRICAO, sum(a.MECQUANTIDADE1) AS QTD
            FROM TB_MEC_MATESTCONTROLE a 
            INNER JOIN TB_MAT_MATERIAL b ON b.MATID = a.MATID
            INNER JOIN TB_FIL_FILIAL c ON c.FILID = a.FILID
            INNER JOIN TB_PES_PESSOA d ON d.PESID = c.PESID 
            INNER JOIN TB_DRIP_APELIDO e ON e.MATFANTASIA = b.MATFANTASIA 
            {$where}
            AND NOT b.NCMID = '56' 
            AND NOT b.NCMID = '65'
            AND NOT b.NCMID = '66'
            AND NOT b.NCMID = '68'
            AND NOT b.NCMID = '71'
            AND NOT b.NCMID = '75'
            AND NOT e.NOME_APELIDO = 'XEV'
            AND NOT a.MECQUANTIDADE1 = '0'
            AND NOT e.GRIFE = 'HICKMANN'
            AND NOT e.GRIFE = 'MILANO VIZZANO' 
            AND NOT e.GRIFE = 'SUPREME'
            AND e.MATFANTASIA NOT LIKE '%OUTLET%'
            AND e.ARMDESCRICAO NOT LIKE '%OUTLET%'
            GROUP BY e.NOME_APELIDO, e.ARMDESCRICAO
            ORDER BY QTD desc");

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
                        <td><?= $dados["APELIDO"]; ?></td>                     
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
            $where1 = "WHERE c.VENDATAHORAFATURAMENTO >=  '" . $post['fdate'] . "'";
            if(!empty($post['tdate'])):
            $where1 .=  "and c.VENDATAHORAFATURAMENTO <=  '". $post['tdate'] ." 23:59'";
            endif;

            if($post['filial'] == '1' || $post['filial'] == '2' || $post['filial'] == '4' || $post['filial'] == '5'):
            @$where1 .= " AND p.FILID_FILIAL = '" . $post['filial'] . "'";   
            endif;

            if(!empty($post['buscar'])):
            @$where1 .= "AND o.NOME_APELIDO LIKE :buscar ";            
            endif;

             if(!empty($post['receituario'])):
            @$where1 .= "AND k.MATDESCRICAO = '" . $post['receituario'] . "' ";            
            endif;
          
            if(!empty($post['oculosDeSol'])):
            @$where1 .= "AND k.MATDESCRICAO = '" . $post['oculosDeSol'] . "' ";            
            endif;

            if($post['grifes'] == 'CLIPON' || $post['grifes'] == 'DRIP' || $post['grifes'] == 'SANTO GRAU PRIME' || $post['grifes'] == 'SUNGLASS'):
            @$where1 .= " AND o.GRIFE = '" . $post['grifes'] . "'";   
            endif;

            
            
            $read = $conn->prepare("SELECT sum(n.PICQTDE) AS TOTAL, o.NOME_APELIDO AS NOME
            FROM TB_LCT_LANCAMENTOS a
            INNER JOIN TB_LTV_LANCAMENTOVENDA b ON b.LCTID = a.LCTID 
            INNER JOIN TB_VEN_VENDA c ON c.VENID = b.VENID 
            INNER JOIN TB_VPE_VENDAPEDIDOS d ON d.VENID_VENDA = c.VENID 
            INNER JOIN TB_PED_PEDIDO e ON e.PEDID = d.PEDID_PEDIDO 
            INNER JOIN TB_CLI_CLIENTE f ON f.CLIID = c.CLIID_PAGADOR 
            INNER JOIN TB_PES_PESSOA g ON g.PESID = f.PESID 
            INNER JOIN TB_USU_USUARIO h ON h.USUID = a.USUID
            INNER JOIN TB_VND_VENDEDOR i ON i.VNDID = e.VNDID_PRIMEIRO 
            INNER JOIN TB_IPD_ITEMPEDIDO j ON j.PEDID_PEDIDO = d.PEDID_PEDIDO
            INNER JOIN TB_MAT_MATERIAL k ON k.MATID = j.MATID_PRODUTO
            INNER JOIN TB_AAT_ATRIBUTOS l ON l.MATID = k.MATID 
            INNER JOIN TB_ARM_ATRMODELO m ON m.ARMID = l.ARMID 
            INNER JOIN TB_PIC_PEDIDOITEMCLIENTE n ON n.IPDID = j.IPDID
            INNER JOIN TB_DRIP_APELIDO o ON o.MATFANTASIA = k.MATFANTASIA 
            INNER JOIN TB_FIL_FILIAL p ON p.FILID = a.FILID 
            {$where1}
            AND e.MCVID IS NULL
            GROUP BY NOME,n.PICQTDE
            ORDER BY total DESC");





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
