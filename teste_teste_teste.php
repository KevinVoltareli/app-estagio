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
                                   
                                    <th>Quantidade</th> 
                                    <th>Os</th>
                                    <th>Cliente</th>
                                    <th>Vendedor</th>
                                    <th>Tipo de Venda</th>
                                    <th>Valor Liquido</th>
                                    <th>Custo</th>
                                    <th>Observação</th>



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

           
            
            $read = $conn->prepare("SELECT b.DEVDATATROCA AS DATA,d.PESNOME AS CLIENTE, j.PESNOME AS VENDEDOR,f.MOMDESCRICAO AS TIPO_DE_VENDA,b.DEVQUANTIDADE AS QUANTIDADE,a.PEDVALORLIQUIDO AS VALOR_LIQUIDO,
            b.DEVOBSERVACOES AS OBSERVACAO,a.PEDSEQUENCIAL AS os,SUM(g.MPCPRECOCUSTO) AS custo,e.MATFANTASIA AS PRODUTO
                        FROM TB_PED_PEDIDO a 
                        INNER JOIN TB_DEV_DEVOLUCAO b ON b.PEDID_TROCA = a.PEDID
                        INNER JOIN TB_CLI_CLIENTE c ON c.CLIID = b.CLIID
                        INNER JOIN TB_PES_PESSOA d ON d.PESID  = c.PESID 
                        INNER JOIN TB_IPD_ITEMPEDIDO h ON h.PEDID_PEDIDO = a.PEDID
                        INNER JOIN TB_MAT_MATERIAL e ON e.MATID = h.MATID_PRODUTO
                        INNER JOIN TB_MOM_MOTIVOMOVIMENTACAO f ON f.MOMID = b.MOMID 
                        INNER JOIN TB_MPC_MATPRECOCUSTO g ON g.MATID = e.MATID  
                        INNER JOIN TB_VND_VENDEDOR i ON i.VNDID = a.VNDID_PRIMEIRO 
                        INNER JOIN TB_PES_PESSOA j ON j.PESID = i.PESID 
                        {$where}
                        AND NOT e.MATFANTASIA = 'PASSAGEM DE LENTES'
                        AND NOT e.MATFANTASIA = 'LIMPA LENTES'
                        GROUP BY j.PESNOME, b.DEVDATATROCA,d.PESNOME,f.MOMDESCRICAO,b.DEVQUANTIDADE,a.PEDVALORLIQUIDO,b.DEVOBSERVACOES,a.PEDSEQUENCIAL,e.MATFANTASIA");
                               
            $read->setFetchMode(PDO::FETCH_ASSOC);            
            $read->execute();   
            $array = $read->fetchAll();   

            foreach ($array as $dados):                              
              ?>
               
                

            
          
               
                    
                    

              
                    
                    <?php
                            $PRODUTO = $dados["PRODUTO"];
                            
                            
                

                            ?> 

                                
                            <?php 
                            extract($dados);

                            $lista_produtos["records"][] = [

                                'PRODUTO'=> $PRODUTO,
                               
                            ];
                            



                        endforeach;

                        $read = $conn->prepare("SELECT b.DEVDATATROCA AS DATA,d.PESNOME AS CLIENTE, j.PESNOME AS VENDEDOR,f.MOMDESCRICAO AS TIPO_DE_VENDA,b.DEVQUANTIDADE AS QUANTIDADE,a.PEDVALORLIQUIDO AS VALOR_LIQUIDO,
                        b.DEVOBSERVACOES AS OBSERVACAO,a.PEDSEQUENCIAL AS os,SUM(g.MPCPRECOCUSTO) AS custo
                                    FROM TB_PED_PEDIDO a 
                                    INNER JOIN TB_DEV_DEVOLUCAO b ON b.PEDID_TROCA = a.PEDID
                                    INNER JOIN TB_CLI_CLIENTE c ON c.CLIID = b.CLIID
                                    INNER JOIN TB_PES_PESSOA d ON d.PESID  = c.PESID 
                                    INNER JOIN TB_IPD_ITEMPEDIDO h ON h.PEDID_PEDIDO = a.PEDID
                                    INNER JOIN TB_MAT_MATERIAL e ON e.MATID = h.MATID_PRODUTO
                                    INNER JOIN TB_MOM_MOTIVOMOVIMENTACAO f ON f.MOMID = b.MOMID 
                                    INNER JOIN TB_MPC_MATPRECOCUSTO g ON g.MATID = e.MATID  
                                    INNER JOIN TB_VND_VENDEDOR i ON i.VNDID = a.VNDID_PRIMEIRO 
                                    INNER JOIN TB_PES_PESSOA j ON j.PESID = i.PESID 
                                    {$where}
                                    GROUP BY j.PESNOME, b.DEVDATATROCA,d.PESNOME,f.MOMDESCRICAO,b.DEVQUANTIDADE,a.PEDVALORLIQUIDO,b.DEVOBSERVACOES,a.PEDSEQUENCIAL");
                        
                        $read->setFetchMode(PDO::FETCH_ASSOC);            
            $read->execute();   
            $array = $read->fetchAll();   

            foreach ($array as $dados):                              
              ?>
               
          
              
                    <?= number_format($dados["QUANTIDADE"], 0, ".", ","); ?></td>
                        <td><?= number_format($dados["OS"], 0, ",", "."); ?></td>
                        <td><?= $dados["CLIENTE"]; ?></td>
                        <td><?= $dados["VENDEDOR"]; ?></td>
                        <td><?= $dados["TIPO_DE_VENDA"]; ?></td>
                        <td><?= number_format($dados["VALOR_LIQUIDO"]); ?></td>
                        <td><?= number_format($dados["CUSTO"], 2, ",", "."); ?></td>
                        <td><?= $dados["OBSERVACAO"]; ?></td>

                    
           
                    
                    <?php
                            $QUANTIDADE = $dados["QUANTIDADE"];
                            $OS = $dados["OS"];
                            $CLIENTE = $dados["CLIENTE"];
                            $VENDEDOR = $dados["VENDEDOR"];
                            $TIPO_DE_VENDA = $dados["TIPO_DE_VENDA"];
                            $LIQUIDO = $dados["VALOR_LIQUIDO"];
                            $CUSTO = $dados["CUSTO"];
                            $qtd =  number_format($CUSTO, 2, ",", ".");
                            $OBSERVACAO = $dados["OBSERVACAO"];
                            
                

                            ?> 

                                
                            <?php 
                            extract($dados);

                            $lista_produtos["records"][] = [

                                'PRODUTO'=> $PRODUTO,
                                'QUANTIDADE' => number_format($QUANTIDADE,2,",",""),
                                'OS' => number_format($OS),
                                'CLIENTE' => $CLIENTE,
                                'VENDEDOR' => $VENDEDOR,
                                'TIPO_DE_VENDA' => $TIPO_DE_VENDA,
                                'LIQUIDO' => number_format($LIQUIDO),
                                'CUSTO' => $CUSTO,
                                'OBSERVACAO' => $OBSERVACAO,
                            ];
                            



                        endforeach;
           

                echo "<h5>Quantidade total: {$QUANTIDADE}</h5>";
                echo "<h5>Valor liquido total: {$LIQUIDO}</h5>";
                echo "<h5>Custo total: {$qtd}</h5>";
               
                ?>
            <?php
            
        endif;
        ?>


    </body>
</html>
