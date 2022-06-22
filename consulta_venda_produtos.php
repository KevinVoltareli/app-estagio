<?php

  session_start();
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
                                    <th>Produto</th>
                                    <th>Data</th>
                                    <th>Total receber</th>
                                    <th>Total liquido</th>
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
            $where = "WHERE VENDATAHORAFATURAMENTO >=  '" . $post['fdate'] . "'";
            if(!empty($post['tdate'])):
            $where .= " and VENDATAHORAFATURAMENTO <=  '". $post['tdate'] ." 23:59:59'";
            
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
            
            $read = $conn->prepare("SELECT DISTINCT a.CLIID_PAGADOR AS idPagador, a.VENDATAHORAFATURAMENTO AS dataPag, a.VENTOTALLIQUIDO AS vendaLiquida, a.VENTOTALRECEBER AS vendaReceber, d.MATID, d.MATFANTASIA AS produto, b.PEDID_PEDIDO, a.VENID "
                    . "FROM TB_VEN_VENDA a "
                    . "INNER JOIN TB_VPE_VENDAPEDIDOS b ON b.VENID_VENDA = a.VENID "
                    . "INNER JOIN TB_IPD_ITEMPEDIDO c ON b.PEDID_PEDIDO = c.PEDID_PEDIDO "
                    . "INNER JOIN TB_MAT_MATERIAL d ON d.MATID = c.MATID_PRODUTO "
                    . "INNER JOIN TB_NCM_NCM e ON d.NCMID = e.NCMID "
                    . "{$where} AND a.VENTOTALLIQUIDO > 0 AND NOT e.NCMID = '56' 
                                                          AND NOT e.NCMID = '61'
                                                          AND NOT e.NCMID = '65'
                                                          AND NOT e.NCMID = '66'
                                                          AND NOT e.NCMID = '68'
                                                          AND NOT e.NCMID = '71'
                                                          AND NOT e.NCMID = '75'
                                                          AND NOT e.NCMID = '67'
                                                          ORDER BY a.VENDATAHORAFATURAMENTO ");


            $read->setFetchMode(PDO::FETCH_ASSOC);
            $read->execute();
            $array = $read->fetchAll();
            if (count($array) == 0):
                echo "Nenhum registro localizado";
            endif;
            $qtd = 0;
            $qtd1 = 0;
            ?>
            
                <?php 
                foreach ($array as $dados): 
                   $qtd += $dados["VENDARECEBER"];
                   $qtd1 += $dados["VENDALIQUIDA"];
                    ?>
                    <tr>
                        <td><?= $dados["PRODUTO"]; ?></td>
                        <td><?= $dados["DATAPAG"]; ?></td>
                        <td><?= number_format($dados["VENDARECEBER"], 2, ",", "."); ?></td>
                        <td><?= number_format($dados["VENDALIQUIDA"], 2, ",", "."); ?></td>
                    </tr>
                <?php
                endforeach; 
                ?>
            </table>
            <?php
            echo "Total geral: {$qtd}";
            echo "</br>";
            echo "Total geral: {$qtd1}";

        endif;
        ?>


    </body>
</html>
