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
        <link rel="icon" type="text/css" href="/..image/logo_santo_grau_todo.png">
        <!--Font awesome-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
        <!--Css -->
        <link rel="stylesheet" type="text/css" href="../css/estiloRelatorios.css">

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

    <!--TOGGLE MENU -->
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
                <li><a href="../consulta_quantidade_produtos.php"><i class="fa-solid fa-sack-dollar"></i>Vendas Macro</a></li>
                <li><a href="../consulta_quantidade_produtos_detalhada.php"><i class="fa-solid fa-circle-info"></i>Venda detalhado</a></li>
                <li><a href="../curva_abc.php"><i class="fa-solid fa-shapes"></i>Estoque</a></li>
                <li><a href="../curva_abc_detalhado.php"><i class="fa-solid fa-shapes"></i>Estoque detalhado</a></li>
                
                <li><a href="../curva_abc_outlet.php"><i class="fa-solid fa-shapes"></i>Estoque outlet</a></li>
                <li><a href="../curva_abc_acessorio.php"><i class="fa-solid fa-shapes"></i>Acessórios</a></li>
                <li><a href="../venda_por_vendedor.php"><i class="fa-sharp fa-solid fa-person"></i>Venda vendedor</a></li>
                <li><a href="grifes_detalhada.php"><i class="fa fa-bookmark" aria-hidden="true"></i></i>Grifes detalhadas</a></li>

                <?php if($_SESSION['login'] == 'kevin.voltareli') { ?>
                    <li><a href="../cadastro_antigo.php"><i class="fa-solid fa-person-cane"></i>Cadastro antigo</a></li>  
                <?php } ?>   
                
                <li><a href="../home2.php"><i class="fa-solid fa-x"></i>Sair</a></li>        
            </ol>        
    </div>  

    <div class="container">
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
                                    

                                 

                                    <div class="col-md-4 ">
                                        <div class="form-group">  
                                            <label>Selecione a filial (estoque)</label><br>
                                                <select class="col-md-12" id="filiais" name="filial">
                                                    <option value="">
                                                        <?php 
                                                          if(isset($_POST['filial'])){
                                                             if($_POST['filial'] == '1') {
                                                                echo 'Central';
                                                            } elseif($_POST['filial'] == '20279') {
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
                                                    <option value="1">Central</option>
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
            $where = "WHERE a.MECDATALOTE  >= '2000-01-01'";            
            $where .= " and a.MECDATALOTE <=  '2024-12-31'";
             if($post['filial'] == '1' || $post['filial'] == '20281' || $post['filial'] == '31823' || $post['filial'] == '20279' || $post['filial'] == '20279'):
            @$where .= " AND c.PESID = '" . $post['filial'] . "'";   
            endif;
           
            
            
            $read = $conn->prepare("SELECT f.ARGDESCRICAO AS GRIFE,  sum(a.MECQUANTIDADE1) AS QTD
            FROM TB_MEC_MATESTCONTROLE a 
            INNER JOIN TB_MAT_MATERIAL b ON b.MATID = a.MATID
            INNER JOIN TB_FIL_FILIAL c ON c.FILID = a.FILID
            INNER JOIN TB_PES_PESSOA d ON d.PESID = c.PESID 
            INNER JOIN TB_AAT_ATRIBUTOS e ON e.MATID = b.MATID 
            INNER JOIN TB_ARG_ATRGRIFE f ON f.ARGID = e.ARGID 
            {$where}
            AND NOT c.FILID = '1'
            AND NOT c.FILID = '5'                            
            AND NOT c.FILID = '7'
            AND NOT f.ARGDESCRICAO = 'SANTO GRAU PRIME'
            AND NOT f.ARGDESCRICAO = 'DRIP'
            AND NOT f.ARGDESCRICAO = 'CLIPON'
            AND NOT f.ARGDESCRICAO = 'ESTOJO PRETO'
            AND NOT f.ARGDESCRICAO = 'SUNGLASS'
            AND NOT f.ARGDESCRICAO = 'LIMPA LENTES'
            AND NOT f.ARGDESCRICAO = 'LENCO MAGICO'
            AND NOT f.ARGDESCRICAO = 'ESTOJO BRANCO'
            AND NOT f.ARGDESCRICAO = 'ESTOJO'
            AND NOT f.ARGDESCRICAO = 'HIDROBLUE'
            AND NOT f.ARGDESCRICAO = 'CORDAO'
            AND NOT f.ARGDESCRICAO = 'ANEL'
            AND NOT f.ARGDESCRICAO = 'SUPREME'
            AND NOT f.ARGDESCRICAO = 'PRESILHA'
            AND NOT f.ARGDESCRICAO = 'AQUARELA'
            AND NOT f.ARGDESCRICAO = 'CARRERA'
            AND NOT f.ARGDESCRICAO = 'ACUVUE 2'
            AND NOT f.ARGDESCRICAO = 'HIDROCOR MENSAL'
            AND NOT f.ARGDESCRICAO = 'SILMO KIDS'
            AND NOT f.ARGDESCRICAO = 'FROZEN'
            AND NOT f.ARGDESCRICAO = 'TRAVESSURA'
            AND NOT f.ARGDESCRICAO = 'STARCK'
            AND NOT f.ARGDESCRICAO = 'HALO'
            AND NOT f.ARGDESCRICAO = 'BERLOQUE'
            AND NOT f.ARGDESCRICAO = 'JOHNSON'
            AND NOT f.ARGDESCRICAO = 'COCA-COLA'
            AND NOT f.ARGDESCRICAO = 'SOLFLEX NATURAL COLORS'
            AND NOT f.ARGDESCRICAO = 'CARRARINHO'
            AND NOT f.ARGDESCRICAO = 'CALVIN KLEIN'
            AND NOT f.ARGDESCRICAO = 'MAX&CO'
            AND NOT f.ARGDESCRICAO = 'NATURAL COLORS'
            AND NOT f.ARGDESCRICAO = 'PAULO CARRARO'
            AND NOT f.ARGDESCRICAO = 'KEEN'
            AND NOT f.ARGDESCRICAO = 'WILVALE KIDS'
            AND NOT f.ARGDESCRICAO = 'PLATINI'
            AND NOT f.ARGDESCRICAO = 'OMEGA'
            AND NOT f.ARGDESCRICAO = 'SMART'
            AND NOT f.ARGDESCRICAO = 'DOLCE & GABBANA'
            AND NOT f.ARGDESCRICAO = 'AMERICAN WAY'
            AND NOT f.ARGDESCRICAO = 'FORMALLI'
            AND NOT f.ARGDESCRICAO = 'MORMAII'
            AND NOT f.ARGDESCRICAO = 'GUESS'
            AND NOT f.ARGDESCRICAO = 'HUGO BOSS'
            AND NOT f.ARGDESCRICAO = 'JULIEN LAFOND'
            AND NOT f.ARGDESCRICAO = 'TURMA DA MONICA'
            AND NOT f.ARGDESCRICAO = 'GRAZI MASSAFERA'
            AND NOT f.ARGDESCRICAO = 'HOYA'
            AND NOT f.ARGDESCRICAO = 'SOLOTICA'
            AND a.MECQUANTIDADE1 > '0'                            
            GROUP BY GRIFE
            ORDER BY QTD DESC");

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
                        <td><?= $dados["GRIFE"]; ?></td>                     
                        <td><?= number_format($dados["QTD"], 0, ",", "."); ?></td>
                    </tr>
                <?php
                endforeach; 
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
            $where1 = "WHERE a.VENDATAHORAFATURAMENTO >=  '" . $post['fdate'] . "'";
            if(!empty($post['tdate'])):
            $where1 .=  "and a.VENDATAHORAFATURAMENTO <=  '". $post['tdate'] ." 23:59'";
            endif;

            if($post['filial'] == '20281' || $post['filial'] == '31823' || $post['filial'] == '20279' || $post['filial'] == '20279'):
            @$where1 .= " AND n.PESID = '" . $post['filial'] . "'";   
            endif;

            
            $read = $conn->prepare("SELECT  g.ARGDESCRICAO  AS NOME, sum(l.PICQTDE) AS TOTAL 
            FROM TB_VEN_VENDA a
            INNER JOIN TB_VPE_VENDAPEDIDOS b ON b.VENID_VENDA = a.VENID 
            INNER JOIN TB_IPD_ITEMPEDIDO c ON c.PEDID_PEDIDO = b.PEDID_PEDIDO 
            INNER JOIN TB_MAT_MATERIAL d ON c.MATID_PRODUTO = d.MATID 
            INNER JOIN TB_NCM_NCM e ON e.NCMID = d.NCMID 
            INNER JOIN TB_AAT_ATRIBUTOS f ON f.MATID = d.MATID  
            INNER JOIN TB_ARG_ATRGRIFE g ON g.ARGID = f.ARGID 
            INNER JOIN TB_PED_PEDIDO i ON i.PEDID = c.PEDID_PEDIDO
            INNER JOIN TB_TVN_TIPOVENDA j ON j.TVNID = i.TVNID
            INNER JOIN TB_PIC_PEDIDOITEMCLIENTE l ON l.IPDID  = c.IPDID
            INNER JOIN TB_FIL_FILIAL m ON m.FILID = i.FILID_FILIAL 
            INNER JOIN TB_PES_PESSOA n ON n.PESID = m.PESID 
            {$where1}
            AND NOT g.ARGDESCRICAO = 'SANTO GRAU PRIME'
            AND NOT g.ARGDESCRICAO = 'DRIP'
            AND NOT g.ARGDESCRICAO = 'CLIPON'
            AND NOT g.ARGDESCRICAO = 'ESTOJO PRETO'
            AND NOT g.ARGDESCRICAO = 'SUNGLASS'
            AND NOT g.ARGDESCRICAO = 'LIMPA LENTES'
            AND NOT g.ARGDESCRICAO = 'LENCO MAGICO'
            AND NOT g.ARGDESCRICAO = 'ESTOJO BRANCO'
            AND NOT g.ARGDESCRICAO = 'ESTOJO'
            AND NOT g.ARGDESCRICAO = 'HIDROBLUE'
            AND NOT g.ARGDESCRICAO = 'CORDAO'
            AND NOT g.ARGDESCRICAO = 'ANEL'
            AND NOT g.ARGDESCRICAO = 'SUPREME'
            AND NOT g.ARGDESCRICAO = 'PRESILHA'
            AND NOT g.ARGDESCRICAO = 'AQUARELA'
            AND NOT g.ARGDESCRICAO = 'CARRERA'
            AND NOT g.ARGDESCRICAO = 'ACUVUE 2'
            AND NOT g.ARGDESCRICAO = 'MICHAEL KORS'
            AND NOT g.ARGDESCRICAO = 'HIDROCOR MENSAL'
            AND NOT g.ARGDESCRICAO = 'SILMO KIDS'
            AND NOT g.ARGDESCRICAO = 'FROZEN'
            AND NOT g.ARGDESCRICAO = 'TRAVESSURA'
            AND NOT g.ARGDESCRICAO = 'STARCK'
            AND NOT g.ARGDESCRICAO = 'HALO'
            AND NOT g.ARGDESCRICAO = 'BERLOQUE'
            AND NOT g.ARGDESCRICAO = 'JOHNSON'
            AND NOT g.ARGDESCRICAO = 'COCA-COLA'
            AND NOT g.ARGDESCRICAO = 'SOLFLEX NATURAL COLORS'
            AND NOT g.ARGDESCRICAO = 'CARRARINHO'
            AND NOT g.ARGDESCRICAO = 'CALVIN KLEIN'
            AND NOT g.ARGDESCRICAO = 'MAX&CO'
            AND NOT g.ARGDESCRICAO = 'NATURAL COLORS'
            AND NOT g.ARGDESCRICAO = 'PAULO CARRARO'
            AND NOT g.ARGDESCRICAO = 'KEEN'
            AND NOT g.ARGDESCRICAO = 'WILVALE KIDS'
            AND NOT g.ARGDESCRICAO = 'PLATINI'
            AND NOT g.ARGDESCRICAO = 'OMEGA'
            AND NOT g.ARGDESCRICAO = 'SMART'
            AND NOT g.ARGDESCRICAO = 'DOLCE & GABBANA'
            AND NOT g.ARGDESCRICAO = 'AMERICAN WAY'
            AND NOT g.ARGDESCRICAO = 'FORMALLI'
            AND NOT g.ARGDESCRICAO = 'MORMAII'
            AND NOT g.ARGDESCRICAO = 'GUESS'
            AND NOT g.ARGDESCRICAO = 'HUGO BOSS'
            AND NOT g.ARGDESCRICAO = 'JULIEN LAFOND'
            AND NOT g.ARGDESCRICAO = 'TURMA DA MONICA'
            AND NOT g.ARGDESCRICAO = 'GRAZI MASSAFERA'
            AND NOT g.ARGDESCRICAO = 'HOYA'
            AND NOT e.NCMID = '56' 
            AND NOT e.NCMID = '65'
            AND NOT e.NCMID = '66'
            AND NOT e.NCMID = '68'
            AND NOT e.NCMID = '71'
            AND NOT e.NCMID = '73'  
            AND NOT e.NCMID = '75'
            GROUP BY  NOME, l.PICQTDE
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
