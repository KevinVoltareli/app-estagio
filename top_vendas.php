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
            
    
            
            $read = $conn->prepare("SELECT DISTINCT COUNT(d.MATID) AS ID, d.MATFANTASIA AS produto, h.APELIDO AS apelido, i.FILID AS filial, j.ARCDESCRICAO AS COR "
                    . "FROM TB_VEN_VENDA a "
                    . "INNER JOIN TB_VPE_VENDAPEDIDOS b ON b.VENID_VENDA = a.VENID "
                    . "INNER JOIN TB_IPD_ITEMPEDIDO c ON b.PEDID_PEDIDO = c.PEDID_PEDIDO "
                    . "INNER JOIN TB_MAT_MATERIAL d ON d.MATID = c.MATID_PRODUTO "
                    . "INNER JOIN TB_NCM_NCM e ON d.NCMID = e.NCMID "
                    . "INNER JOIN TB_AAT_ATRIBUTOS f ON f.MATID = d.MATID "
                    . "INNER JOIN TB_ARM_ATRMODELO g ON g.ARMID = f.ARMID "
                    . "INNER JOIN ARM_APELIDO h ON h.ARMDESCRICAO = g.ARMDESCRICAO "  
                    . "INNER JOIN TB_CLI_CLIENTE i ON i.CLIID = a.CLIID_PAGADOR "
                    . "INNER JOIN TB_ARC_ATRCOR j ON j.ARCID = f.ARCID "
                    . "{$where} AND a.VENTOTALLIQUIDO > 0 AND NOT e.NCMID = '56' 
                                                          AND NOT e.NCMID = '65'
                                                          AND NOT e.NCMID = '66'
                                                          AND NOT e.NCMID = '68'
                                                          AND NOT e.NCMID = '71'
                                                          AND NOT e.NCMID = '75'
                       GROUP BY d.MATFANTASIA, d.MATID, h.APELIDO, i.FILID, j.ARCDESCRICAO ORDER BY ID DESC");


            $read->setFetchMode(PDO::FETCH_ASSOC);
            $read->execute();
            $array = $read->fetchAll();
            if (count($array) == 0):
                echo "Nenhum registro localizado";
            endif;
            $qtdProd = 0;
       
        ?>

        <?php
         $readVendas = $conn->prepare("SELECT CLIID_PAGADOR AS idPagador, count(VENDATAHORAFATURAMENTO) AS dataPag, VENTOTALLIQUIDO AS vendaLiquida, VENTOTALRECEBER AS vendaReceber "
                    . "FROM TB_VEN_VENDA "
                    . "{$where} AND VENTOTALLIQUIDO > 0 GROUP BY CLIID_PAGADOR, VENTOTALRECEBER, VENDATAHORAFATURAMENTO, VENDALIQUIDA ORDER BY VENDATAHORAFATURAMENTO ASC ");


            $readVendas->setFetchMode(PDO::FETCH_ASSOC);
            $readVendas->execute();
            $arrayVendas = $readVendas->fetchAll();
            if (count($array) == 0):
                echo "Nenhum registro localizado";
            endif;
            $qtdVenda = 0;
            $qtdVenda1 = 0;
            $qtd2 = 0;
            ?>
            
                <?php 
                foreach ($arrayVendas as $dados): 

                   $qtdVenda += $dados["VENDALIQUIDA"];
                   $qtdVenda1 += $dados["VENDARECEBER"];
                   $qtd2 += $dados["DATAPAG"];
                    ?>
                    <!--<tr>
                        <td><?= $dados["DATAPAG"]; ?></td>
                        <td><?= number_format($dados["VENDALIQUIDA"], 2, ",", "."); ?></td>
                        <td><?= number_format($dados["VENDARECEBER"], 2, ",", "."); ?></td>
                    </tr>-->
                <?php
                endforeach; 
                ?>
            </table>
        


    </body>
</html>
