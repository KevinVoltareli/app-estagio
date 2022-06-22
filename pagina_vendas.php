   

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
                                    <th>Data</th>
                                    <th>Total liquido</th>
                                    <th>Total a receber</th>
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

            
            $read = $conn->prepare("SELECT CLIID_PAGADOR AS idPagador, VENDATAHORAFATURAMENTO AS dataPag, VENTOTALLIQUIDO AS vendaLiquida, VENTOTALRECEBER AS vendaReceber "
                    . "FROM TB_VEN_VENDA "
                    . "{$where} AND VENTOTALLIQUIDO > 0 GROUP BY CLIID_PAGADOR, VENTOTALRECEBER, VENDATAHORAFATURAMENTO, VENDALIQUIDA ORDER BY VENDATAHORAFATURAMENTO ASC ");
            
            
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
                   $qtd += $dados["VENDALIQUIDA"];
                   $qtd1 += $dados["VENDARECEBER"];
                    ?>
                    <tr>
                        <td><?= $dados["DATAPAG"]; ?></td>
                        <td><?= number_format($dados["VENDALIQUIDA"], 2, ",", "."); ?></td>
                        <td><?= number_format($dados["VENDARECEBER"], 2, ",", "."); ?></td>
                    </tr>
                <?php
                endforeach; 
                ?>
            </table>
            <?php
            echo "Total Liquido: {$qtd}";
            echo "<br>";
            echo "Total Receber: {$qtd1}";

            endif;
        ?>


    </body>
</html>
