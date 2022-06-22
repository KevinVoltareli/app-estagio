   

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Demonstrativo de vendas</title>

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

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

  

    <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card mt-5">
                        <div class="card-header">
                            <h4>Relatório de vendas</h4>
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
                                          <a href="grafico.php"><button type="button" class=" btn btn-md btn-success">Gráficos</button></a>
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
                                    <th>ID PAGADOR</th>
                                    <th>VENDA DATA/HORA</th>
                                    <th>Total LIQUIDO</th>
                                    <th>Total RECEBER</th>
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
            $where = "WHERE d.VENDATAHORAFATURAMENTO >=  '" . $post['fdate'] . "'";
            if(!empty($post['tdate'])):
            $where .= " and d.VENDATAHORAFATURAMENTO <=  '" . $post['tdate'] . "'";
            
            endif;

            /*TB_VEN_VENDA ->Recebe todas vendas da loja, inclusive as que não foram efetuadas com sucesso.
                             As vendas que foram efetuadas com sucesso, precisa ser associada à coluna CLIID_PAGADOR.
                             Colunas necessárias:
                             VENID = Id de venda que precisara ser conectado com a tabela TB_VPE_VENDAPEDIDOS, que se conecta com TB_IPD_ITEMPEDIDO(aqui onde encontrará coluna de MATID_PRODUTO que pode ser associado à quais produtos venderam).
                             CLIID_PAGADOR: Coluna onde está associado à itens que realmente venderam.
                             VENTOTALLIQUIDO: venda bruta - desconto
                             VENDATAHORAFATURAMENTO: data e hora

               TB_VPE_VENDAPEDIDOS -> Importante para conectar tabela de vendas à de itens pedido
                             Colunas:
                             VPEID, VENID_VENDA, PEDID_PEDIDO

               TB_IPD_ITEMPEDIDO -> PEDID_PEDIDO ( ID )
                                    MATID_PRODUTO (ID dos produtos)

               TB_MAT_MATERIAL -> MATID
                                  MATFANTASIA                                                 
                                
                */
            
            $read = $conn->prepare("SELECT d.VENID, d.CLIID_PAGADOR AS idPagador , a.MATID_PRODUTO ,b.MATFANTASIA AS PRODUTO,                    a.IPDQTDE , IPDPRECO  , d.VENTOTALRECEBER AS vendaReceber,            
                                    d.VENDATAHORAFATURAMENTO AS DATA  FROM TB_IPD_ITEMPEDIDO a
                                    INNER JOIN TB_MAT_MATERIAL b ON a.MATID_PRODUTO = b.MATID 
                                    INNER JOIN TB_VPE_VENDAPEDIDOS c ON c.PEDID_PEDIDO = a.PEDID_PEDIDO 
                                    INNER JOIN TB_VEN_VENDA d ON d.VENID = c.VENID_VENDA 
                                    {$where} AND d.CLIID_PAGADOR IS NOT NULL ");


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
                  // $qtd += $dados["VENDALIQUIDA"];
                    ?>
                    <tr>
                        <td><?= $dados["IDPAGADOR"]; ?></td>
                        <td><?= $dados["PRODUTO"]; ?></td> 
                        <td><?= $dados["DATA"]; ?></td>
                     <!--   <td><?= number_format($dados["VENDALIQUIDA"], 2, ",", "."); ?></td> -->
                        <td><?= number_format($dados["VENDARECEBER"], 2, ",", "."); ?></td>
                    </tr>
                <?php
                endforeach; 
                ?>
            </table>
            <?php
            echo "Total geral: {$qtd}";
        endif;
        ?>


    </body>
</html>
