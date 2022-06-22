<?php
session_start();
if (!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] != 'SIM') {
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

    </head>
    <body>

        <div class="container col-4"> 
            <div>
                <h2 class="text-center">Demonstrativo de vendas</h2>
            </div>
            <div class="container col-4">
                <a href="home.php" class="btn btn-lg btn-warning btn-block" type="submit">Voltar</a>
            </div>
        </div>



        <form action="" method="post">

            <p>
                From: <input name="fdate" type="date" maxlength="10" size="10" required />
            </p>
            <p>
                To: <input name="tdate" type="date" maxlength="10" size="10" required />
            </p>
            <p>
                <!--<input type="submit" value="Enviar" /> -->
                <button type="submit" class="btn btn-primary btn-sm">Pesquisar</button>
            </p>
        </form>

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
            $where = "WHERE MVMDATAMOV >=  '" . $post['fdate'] . "'";
            if(!empty($post['tdate'])):
            $where .= " and MVMDATAMOV <=  '" . $post['tdate'] . "'";
            
            endif;
            $read = $conn->prepare("SELECT a.MATID AS codigo,b.MATFANTASIA, sum(a.MVMQUANTIDADE) AS total "
                     
                    . "FROM TB_MVM_MOVMATITEM a "
                    . "INNER JOIN TB_MAT_MATERIAL b ON a.MATID = b.MATID, MATDESCRICAO "
                    . "{$where} GROUP BY a.MATID , b.MATFANTASIA ORDER BY total desc");
            $read->setFetchMode(PDO::FETCH_ASSOC);
            $read->execute();
            $array = $read->fetchAll();
            if (count($array) == 0):
                echo "Nenhum registro localizado";
            endif;
            $qtd = 0;
            ?>
            
            <table width="500px" border="1">
                <tr>
                   
                    <th>Código</th>
                    <th>MATFANTASIA</th>
                    <th>Total</th>
                </tr>
                <?php 
                foreach ($array as $dados): 
                    $qtd += $dados["TOTAL"];
                    ?>
                    <tr>
                       
                        <td><?php echo $dados["CODIGO"]; ?></td>
                        <td><?php echo $dados["MATFANTASIA"]; ?></td>
                        <td><?php echo number_format($dados["TOTAL"], 0, ",", "."); ?></td>
                    <?php endforeach; ?>
            </table>
            <?php
            echo "Total geral: {$qtd}";
        endif;
        ?>


    </body>
</html>
