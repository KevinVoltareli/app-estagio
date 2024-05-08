<?php

  if (!isset($_SESSION)):
    session_start();
endif;
  if(!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] != 'SIM'){
    header('Location: index.php?login=erro2');
  }
$qtd = 0;
?>         

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=iso-8859-1" />
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
                                                 
                            <h4>Relatorio de Trocas</h4>
                        </div>
                        <div class="card-body">
                        
                            <form action="" method="post">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Data inicial</label>
                                            <input class="form-control" name="fdate" type="date" maxlength="10" size="10"  value="<?php if(isset($_POST['fdate'])){echo $_POST['fdate'];}?>" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">  
                                            <label>Data final</label>
                                            <input class="form-control" name="tdate" type="date" maxlength="10" size="10"  value="<?php if(isset($_POST['tdate'])){echo $_POST['tdate'];}?>" />
                                        </div>
                                    </div>
                        
                                    <div class="col-md-4">
                                        <div  class="form-group">                                     
                                          <button type="submit" class="btn btn-md btn-warning">Pesquisar</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 ">
                                            <div class="form-group">  
                                                <label>Selecione a filial</label><br>
                                                    <select class="col-md-12" id="filiais" name="filial">
                                                        <option  value="">
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
                                                        <option value="">--Selecione para todos--</option>
                                                        <option value="2">Galao</option>
                                                        <option value="4">Aggio</option>
                                                        <option value="5">E-commerce</option>
                                                        <option value="7">Site</option>
                                                    </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4 ">                   
                                            <div class="form-group">  
                                                    <label>Pesquisar OS</label><br>
                                                        <input value="<?php if(isset($_POST['buscar'])){echo $_POST['buscar'];}?>" type="number" id="buscar" name="buscar">
                                            </div>  
                                        </div>                          
                                    </div>                    
                            </form>
                        </div>

                <!--Começo da primeira listagem -->        
                                                              
                    <div class="card mt-8">
                        <div class="card-body">
                            <table class="table table-borderd">
                                <thead>
                                    <tr>
                                        
                                     
                                        <th>Os</th>
                                        <th>Data</th>
                                        <th>Cliente</th>
                                        <th>Vendedor</th>
                                        <th>Tipo de Venda</th>
                                        <th>Valor Liquido</th>
                                        <th>Observação</th>



                                    </tr>
                                </thead>
                                <tbody>
                        </div>                                            
                    </div>        
                
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

            $where = "WHERE a.PEDDATADIGITACAO >=  '" . $post['fdate'] . "'";
            if(!empty($post['tdate'])):
            $where .= " and a.PEDDATADIGITACAO <=  '". $post['tdate'] ." 23:59:59'";

            if($post['filial'] == '2' || $post['filial'] == '4' || $post['filial'] == '5' || $post['filial'] == '7'):
                @$where .= " AND a.FILID_FILIAL  = '" . $post['filial'] . "'";      
                endif;

            if(!empty($post['buscar'])):
            @$where .= "AND a.PEDSEQUENCIAL LIKE :buscar ";            
            endif;
            
            endif;

         
            
            
            $read = $conn->prepare("SELECT DISTINCT a.PEDSEQUENCIAL AS OS,a.PEDDATAENTRADA AS DATA,c.PESNOME AS VENDEDOR,a.PEDVALORLIQUIDO AS VALOR_LIQUIDO,
            d.TVNDESCRICAO AS TIPO_DE_VENDA,a.PEDOBS AS OBSERVACAO,abcd.PESNOME AS CLIENTE 
                        FROM TB_PED_PEDIDO a
                        INNER JOIN TB_VND_VENDEDOR b ON b.VNDID = a.VNDID_PRIMEIRO
                        INNER JOIN TB_PES_PESSOA c ON c.PESID = b.PESID 
                        INNER JOIN TB_TVN_TIPOVENDA d ON d.TVNID = a.TVNID 
                        INNER JOIN TB_IPD_ITEMPEDIDO e ON e.PEDID_PEDIDO = a.PEDID
                        INNER JOIN TB_MAT_MATERIAL f ON f.MATID = e.MATID_PRODUTO
                        INNER JOIN TB_MPC_MATPRECOCUSTO g ON g.MATID = f.MATID
                        INNER JOIN TB_VEN_VENDA z ON z.VENID = b.VNDID 
                        INNER JOIN TB_VPE_VENDAPEDIDOS h ON h.VENID_VENDA = z.VENID 
                        INNER JOIN TB_CLI_CLIENTE i ON i.CLIID = z.CLIID_PAGADOR 
                        INNER JOIN TB_PES_PESSOA abcd ON abcd.PESID = i.PESID 
                        {$where}
                        AND NOT d.TVNDESCRICAO = 'VENDA'
                        AND NOT d.TVNDESCRICAO = 'VIDEO CHAMADA'
                        AND NOT f.MATFANTASIA = 'PASSAGEM DE LENTES'
                        AND NOT f.MATFANTASIA = 'LIMPA LENTES' 
                        AND a.PEDSEQUENCIAL > 800000
                        GROUP BY a.PEDSEQUENCIAL,a.PEDDATAENTRADA,c.PESNOME,a.PEDVALORLIQUIDO,d.TVNDESCRICAO,a.PEDSEQUENCIAL,a.PEDOBS,abcd.PESNOME");
                               
            $read->bindParam(':buscar', $buscar, PDO::PARAM_STR);
            $read->setFetchMode(PDO::FETCH_ASSOC);
            $read->execute();
            $array = $read->fetchAll();
            if (count($array) == 0):
                echo "Nenhum registro localizado";      
            endif;
            $qtdval = 0;
           

            ?>
            
                <?php 
                foreach ($array as $dados): 
                $qtdval += $dados["VALOR_LIQUIDO"];
                
                
                                
                    ?>
                    
                        
                        
                        <td><?= number_format($dados["OS"], 0, "", ""); ?></td>
                        <td><?= $dados["DATA"]; ?></td>
                        <td><?php echo utf8_encode($dados["CLIENTE"]); ?></td>
                        <td><?= $dados["VENDEDOR"]; ?></td>
                        <td><?= $dados["TIPO_DE_VENDA"]; ?></td>
                        <td><?= number_format($dados["VALOR_LIQUIDO"]); ?></td>
                        <td><?= $dados["OBSERVACAO"]; ?></td>

                    </tr>
                        
                    
                <?php
                endforeach; 

               
                echo "<h5>Valor liquido total: {$qtdval}</h5>";
                echo "<h5>Custo total: {$qtd}</h5>";
                ?>
            </table>
            <?php
            
        endif;
        ?>

        <!--Fim da primeira listagem -->

        <!--Começo da segunda listagem -->        
        <div style="font-size: 15px " class="container">                        
                    <div class="row">
                    <div class="col-6">
                    <div class="card mt-4">
                    <div class="card-body">
                        <table class="table table-borderd">
                                <thead>
                                    <tr>
                                        
                                        <th>Produto</th> 
                                        <th>Quantidade</th>
                                        <th>Custo</th>
                            
                                    </tr>
                                </thead>
                                <tbody>

                        </div>  
                    </div>
        </div>                 
       
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

            $where = "WHERE a.PEDDATADIGITACAO >=  '" . $post['fdate'] . "'";
            if(!empty($post['tdate'])):
            $where .= " and a.PEDDATADIGITACAO <=  '". $post['tdate'] ." 23:59:59'";


            if(!empty($post['buscar'])):
            @$where .= "AND a.PEDSEQUENCIAL LIKE :buscar ";            
            endif;
            
            endif;

         $qtd= 0;
            
            
            $read = $conn->prepare("SELECT g.MPCPRECOCUSTO AS custo,f.MATFANTASIA AS PRODUTO,h.IPDQTDE AS QUANTIDADE
            FROM TB_PED_PEDIDO a
            INNER JOIN TB_VND_VENDEDOR b ON b.VNDID = a.VNDID_PRIMEIRO 
            INNER JOIN TB_PES_PESSOA c ON c.PESID = b.PESID
            INNER JOIN TB_TVN_TIPOVENDA d ON d.TVNID = a.TVNID 
            INNER JOIN TB_IPD_ITEMPEDIDO e ON e.PEDID_PEDIDO = a.PEDID
            INNER JOIN TB_MAT_MATERIAL f ON f.MATID = e.MATID_PRODUTO
            INNER JOIN TB_MPC_MATPRECOCUSTO g ON g.MATID = f.MATID
            INNER JOIN TB_IPD_ITEMPEDIDO h ON h.PEDID_PEDIDO = a.PEDID
            {$where}
            AND NOT d.TVNDESCRICAO = 'VENDA'
            AND NOT d.TVNDESCRICAO = 'VIDEO CHAMADA'
            AND NOT f.MATFANTASIA = 'PASSAGEM DE LENTES'
            AND NOT f.MATFANTASIA = 'LIMPA LENTES'
            AND NOT g.MPCPRECOCUSTO = '0'
            GROUP BY g.MPCPRECOCUSTO,f.MATFANTASIA,h.IPDQTDE");
                               
            $read->bindParam(':buscar', $buscar, PDO::PARAM_STR);
            $read->setFetchMode(PDO::FETCH_ASSOC);
            $read->execute();
            $array = $read->fetchAll();
            if (count($array) == 0):
                echo "Nenhum registro localizado";      
            endif;
            $qtdcus = 0;
            $custoformat = 0;
            $qtdquan = 0;
            ?>
            
                <?php 
                foreach ($array as $dados): 
                $qtdquan += $dados["QUANTIDADE"];
                $custoformat += $dados["CUSTO"];
                $qtd =  number_format($custoformat, 2, ",", ".") ;   
                $total =  $dados["QUANTIDADE"] *  $dados["CUSTO"]; 
                $qtdTotal =  number_format($total, 2, ",", ".") ;
                
                    ?>
                    
                       
                        <td><?= $dados["PRODUTO"]; ?></td>
                        <td><?= number_format($dados["QUANTIDADE"], 0, ".", ","); ?></td>
                        <td><?= $qtdTotal ?></td>
                    </tr>
                        
                    
                <?php
                endforeach; 
                echo "<h5>Quantidade total: {$qtdquan}</h5>";
                ?>
            </table>
            <?php
            
        endif;
        ?>

        <!--Fim da segunda listagem -->




    </body>
</html>
