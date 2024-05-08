
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

      body #boxConteudo {
        width: 565px;
        margin-right: 300px;

       }

      body #boxConteudo2 {
        width: 590px;
        margin-right: 300px;
       }

      body #div1 {
        
        margin: auto;
        width: 105%;
      }

     </style>
    </head>
    <body>

       
        <?php

        $dataInicialEstoque = '2018-01-01';
        $dataFinalEstoque = '2024-12-31';

        $dataInicialVenda = '2023-01-01';
        $dataFinalVenda = '2023-01-31 23:59';

        $post = filter_input_array(INPUT_POST, FILTER_DEFAULT);

            try {
                $conn = new PDO("firebird:dbname=C:\SavWinRevo\Servidor\DataBase\BDSAVWINREVO.FDB", "SYSDBA", "masterkey");
            } catch (PDOException $e) {
                echo '<pre>';
                print_r($e);
                echo '</pre>';
                die(); //deu ruim
            }

            /* $where = "WHERE VENDATAHORAFATURAMENTO >= '2022-07-01' ";
        
            $where .= " and VENDATAHORAFATURAMENTO <=  '2022-07-31 23:59' ";*/
            
    
            ////////////////// produtos vendidos lista ////////////////////////
            $read = $conn->prepare("SELECT FIRST 30 h.NOME_APELIDO AS CODNOME, sum(l.PICQTDE) AS TOTAL 
                            FROM TB_VEN_VENDA a
                            INNER JOIN TB_VPE_VENDAPEDIDOS b ON b.VENID_VENDA = a.VENID 
                            INNER JOIN TB_IPD_ITEMPEDIDO c ON c.PEDID_PEDIDO = b.PEDID_PEDIDO 
                            INNER JOIN TB_MAT_MATERIAL d ON c.MATID_PRODUTO = d.MATID 
                            INNER JOIN TB_NCM_NCM e ON e.NCMID = d.NCMID 
                            INNER JOIN TB_AAT_ATRIBUTOS f ON f.MATID = d.MATID  
                            INNER JOIN TB_DRIP_APELIDO h ON h.MATFANTASIA  = d.MATFANTASIA
                            INNER JOIN TB_PED_PEDIDO i ON i.PEDID = c.PEDID_PEDIDO
                            INNER JOIN TB_TVN_TIPOVENDA j ON j.TVNID = i.TVNID
                            INNER JOIN TB_PIC_PEDIDOITEMCLIENTE l ON l.IPDID  = c.IPDID
                            WHERE a.VENDATAHORAFATURAMENTO >= '{$dataInicialVenda}' AND a.VENDATAHORAFATURAMENTO <= '{$dataFinalVenda}'
                            AND i.PEDDATACANCELAMENTO IS NULL
                            AND NOT e.NCMID = '56' 
                            AND NOT e.NCMID = '65'
                            AND NOT e.NCMID = '66'
                            AND NOT e.NCMID = '68'
                            AND NOT e.NCMID = '71'
                            AND NOT e.NCMID = '73'  
                            AND NOT e.NCMID = '75'
                            GROUP BY  h.NOME_APELIDO, l.PICQTDE
                            ORDER BY total DESC  ");


            $read->setFetchMode(PDO::FETCH_ASSOC);
            $read->execute();
            $array = $read->fetchAll();
           
            //qtdProd = 0;
       
        ?>
       
        <?php  ////////////// produtos ESTOQUE ///////////////////////
         $readVendas = $conn->prepare("SELECT FIRST 30 DISTINCT e.NOME_APELIDO as APELIDO, SUM(a.MECQUANTIDADE1) AS QTD "
                                    . "FROM TB_MEC_MATESTCONTROLE a "
                                    . "INNER JOIN TB_MAT_MATERIAL b ON b.MATID = a.MATID "
                                    . "INNER JOIN TB_FIL_FILIAL c ON c.FILID = a.FILID "
                                    . "INNER JOIN TB_PES_PESSOA d ON d.PESID = c.PESID "
                                    . "INNER JOIN TB_DRIP_APELIDO e ON e.MATFANTASIA = b.MATFANTASIA "
                                    . "WHERE a.MECDATALOTE  >= '{$dataInicialEstoque}' AND a.MECDATALOTE <= '{$dataFinalEstoque}' "
                                    . "AND NOT b.NCMID = '56' 
                                       AND NOT b.NCMID = '65'
                                       AND NOT b.NCMID = '66'
                                       AND NOT b.NCMID = '68'
                                       AND NOT b.NCMID = '71'
                                       AND NOT b.NCMID = '75'"
                                    . "GROUP BY e.NOME_APELIDO  " 
                                    . "ORDER BY QTD desc");


            $readVendas->setFetchMode(PDO::FETCH_ASSOC);
            $readVendas->execute();
            $arrayVendas = $readVendas->fetchAll();
            
            /*$qtdVenda = 0;
            $qtdVenda1 = 0;
            $qtd2 = 0;*/
            ?>
             
                
                <?php      ///////// Total estoque BOX MENOR //////////
                           
          $readFilial = $conn->prepare("SELECT e.NOME_APELIDO as APELIDO, SUM(a.MECQUANTIDADE1) AS QTD  "
                                    . "FROM TB_MEC_MATESTCONTROLE a "
                                    . "INNER JOIN TB_MAT_MATERIAL b ON b.MATID = a.MATID "
                                    . "INNER JOIN TB_FIL_FILIAL c ON c.FILID = a.FILID "
                                    . "INNER JOIN TB_PES_PESSOA d ON d.PESID = c.PESID "
                                    . "INNER JOIN TB_DRIP_APELIDO e ON e.MATFANTASIA = b.MATFANTASIA "
                                    . "WHERE a.MECDATALOTE  >= '{$dataInicialEstoque}' AND a.MECDATALOTE <= '{$dataFinalEstoque}' "
                                    . "AND NOT b.NCMID = '56' 
                                       AND NOT b.NCMID = '65'
                                       AND NOT b.NCMID = '66'
                                       AND NOT b.NCMID = '68'
                                       AND NOT b.NCMID = '71'
                                       AND NOT b.NCMID = '75'"
                                    . "GROUP BY e.NOME_APELIDO " 
                                    . "ORDER BY QTD desc "); 


            $readFilial->setFetchMode(PDO::FETCH_ASSOC);
            $readFilial->execute();
            $arrayFilial = $readFilial->fetchAll();
           
            $qtdVenda = 0;
            
            ?>
            
                <?php 
                foreach ($arrayFilial as $dados): 
                     $qtdVenda += $dados["QTD"]
             
                    ?>
                    <!--<tr>
                        <td><?= $dados["DATAPAG"]; ?></td>
                        <td><?= number_format($dados["VENDALIQUIDA"], 2, ",", "."); ?></td>
                        <td><?= number_format($dados["VENDARECEBER"], 2, ",", "."); ?></td>
                    </tr>-->
                <?php
                endforeach; 
                ?>


                 <?php      ///////// Total PRODUTO VENDIDO BOX MENOR //////////
                           
          $readFilial1 = $conn->prepare("SELECT DISTINCT h.NOME_APELIDO AS NOME, count(d.MATDESCRICAO) AS TOTAL
                    FROM 
                        TB_VEN_VENDA a
                    INNER JOIN
                        TB_VPE_VENDAPEDIDOS b ON b.VENID_VENDA = a.VENID 
                    INNER JOIN 
                        TB_IPD_ITEMPEDIDO c ON c.PEDID_PEDIDO = b.PEDID_PEDIDO 
                    INNER JOIN 
                        TB_MAT_MATERIAL d ON c.MATID_PRODUTO = d.MATID 
                    INNER JOIN
                        TB_NCM_NCM e ON e.NCMID = d.NCMID 
                    INNER JOIN 
                        TB_AAT_ATRIBUTOS f ON f.MATID = d.MATID  
                    INNER JOIN 
                        TB_DRIP_APELIDO h ON h.MATFANTASIA  = d.MATFANTASIA  
                    WHERE 
                        a.VENDATAHORAFATURAMENTO >= '{$dataInicialVenda}' AND a.VENDATAHORAFATURAMENTO <= '{$dataFinalVenda}'
                    AND NOT e.NCMID = '56' 
                    AND NOT e.NCMID = '65'
                    AND NOT e.NCMID = '66'
                    AND NOT e.NCMID = '68'
                    AND NOT e.NCMID = '71'
                    AND NOT e.NCMID = '73'  
                    AND NOT e.NCMID = '75'
                    GROUP BY d.MATDESCRICAO , h.NOME_APELIDO
                    ORDER BY TOTAL DESC
              ");                       


            $readFilial1->setFetchMode(PDO::FETCH_ASSOC);
            $readFilial1->execute();
            $arrayFilial1 = $readFilial1->fetchAll();
            
            $qtdVenda1 = 0;
            
            ?>
            
                <?php 
                foreach ($arrayFilial1 as $dados): 
                     $qtdVenda1 += $dados["TOTAL"]
             
                    ?>
                    <!--<tr>
                        <td><?= $dados["DATAPAG"]; ?></td>
                        <td><?= number_format($dados["VENDALIQUIDA"], 2, ",", "."); ?></td>
                        <td><?= number_format($dados["VENDARECEBER"], 2, ",", "."); ?></td>
                    </tr>-->
                <?php
                endforeach; 
                ?>


                <?php  ////////////// produtos MAIS VENDIDO ///////////////////////
              $readVendas1 = $conn->prepare("SELECT FIRST 1 DISTINCT h.NOME_APELIDO AS NOME, count(d.MATDESCRICAO) AS TOTAL
                    FROM 
                        TB_VEN_VENDA a
                    INNER JOIN
                        TB_VPE_VENDAPEDIDOS b ON b.VENID_VENDA = a.VENID 
                    INNER JOIN 
                        TB_IPD_ITEMPEDIDO c ON c.PEDID_PEDIDO = b.PEDID_PEDIDO 
                    INNER JOIN 
                        TB_MAT_MATERIAL d ON c.MATID_PRODUTO = d.MATID 
                    INNER JOIN
                        TB_NCM_NCM e ON e.NCMID = d.NCMID 
                    INNER JOIN 
                        TB_AAT_ATRIBUTOS f ON f.MATID = d.MATID  
                    INNER JOIN 
                        TB_DRIP_APELIDO h ON h.MATFANTASIA  = d.MATFANTASIA  
                    WHERE 
                        a.VENDATAHORAFATURAMENTO >= '{$dataInicialVenda}' AND a.VENDATAHORAFATURAMENTO <= '{$dataFinalVenda}'
                    AND NOT e.NCMID = '56' 
                    AND NOT e.NCMID = '65'
                    AND NOT e.NCMID = '66'
                    AND NOT e.NCMID = '68'
                    AND NOT e.NCMID = '71'
                    AND NOT e.NCMID = '73'  
                    AND NOT e.NCMID = '75'
                    GROUP BY d.MATDESCRICAO , h.NOME_APELIDO
                    ORDER BY TOTAL DESC ");


            $readVendas1->setFetchMode(PDO::FETCH_ASSOC);
            $readVendas1->execute();
            $arrayMaisVendido = $readVendas1->fetchAll();
            

            ?>

             <?php  ////////////// produtos menos VENDIDO ///////////////////////
              $readVendas2 = $conn->prepare("SELECT FIRST 1 DISTINCT h.NOME_APELIDO AS NOME, count(d.MATDESCRICAO) AS TOTAL
                    FROM 
                        TB_VEN_VENDA a
                    INNER JOIN
                        TB_VPE_VENDAPEDIDOS b ON b.VENID_VENDA = a.VENID 
                    INNER JOIN 
                        TB_IPD_ITEMPEDIDO c ON c.PEDID_PEDIDO = b.PEDID_PEDIDO 
                    INNER JOIN 
                        TB_MAT_MATERIAL d ON c.MATID_PRODUTO = d.MATID 
                    INNER JOIN
                        TB_NCM_NCM e ON e.NCMID = d.NCMID 
                    INNER JOIN 
                        TB_AAT_ATRIBUTOS f ON f.MATID = d.MATID  
                    INNER JOIN 
                        TB_DRIP_APELIDO h ON h.MATFANTASIA  = d.MATFANTASIA  
                    WHERE 
                        a.VENDATAHORAFATURAMENTO >= '2022-10-01' AND a.VENDATAHORAFATURAMENTO <= '2022-10-31'
                    AND NOT e.NCMID = '56' 
                    AND NOT e.NCMID = '65'
                    AND NOT e.NCMID = '66'
                    AND NOT e.NCMID = '68'
                    AND NOT e.NCMID = '71'
                    AND NOT e.NCMID = '73'  
                    AND NOT e.NCMID = '75'
                    GROUP BY d.MATDESCRICAO , h.NOME_APELIDO
                    ORDER BY TOTAL ASC ");


            $readVendas2->setFetchMode(PDO::FETCH_ASSOC);
            $readVendas2->execute();
            $arrayMenosVendido = $readVendas2->fetchAll();
            
            ?>

    </body>
</html>