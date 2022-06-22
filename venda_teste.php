   

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

            try {
                $conn = new PDO("firebird:dbname=C:\SavWinRevo\Servidor\DataBase\BDSAVWINREVO.FDB", "SYSDBA", "masterkey");
            } catch (PDOException $e) {
                echo '<pre>';
                print_r($e);
                echo '</pre>';
                die(); //deu ruim
            }
             $where = "WHERE VENDATAHORAFATURAMENTO >= '2022-06-01' ";
        
            $where .= " and VENDATAHORAFATURAMENTO <=  '2022-06-30 23:59' ";
            
            

            
            $read = $conn->prepare("SELECT CLIID_PAGADOR AS idPagador, count(VENDATAHORAFATURAMENTO) AS dataPag, VENTOTALLIQUIDO AS vendaLiquida, VENTOTALRECEBER AS vendaReceber "
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
            $qtd2 = 0;
            ?>
            
                <?php 
                foreach ($array as $dados): 
                   $qtd += $dados["VENDALIQUIDA"];
                   $qtd1 += $dados["VENDARECEBER"];
                   $qtd2 += $dados["DATAPAG"];
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
            echo "<br>";
            echo "Total Produtos: {$qtd2}";
        ?>


    </body>
</html>
