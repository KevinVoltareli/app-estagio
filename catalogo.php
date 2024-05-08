<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Demonstrativo de vendas</title>

        <!--Bootstrap-->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <!--Icone pagina-->
        <link rel="icon" type="text/css" href="image/logo_santo_grau_todo.png">
        <!--Font awesome-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
        <!--Css catalogo -->
        <link rel="stylesheet" type="text/css" href="css/estiloCatalogo.css">

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

       button a {
        text-decoration: none;

        color: white;
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

            $where = "WHERE a.MECDATALOTE  >= '2018-01-01'";            
            $where .= " and a.MECDATALOTE <=  '2022-12-31'";
             
            @$where .= " AND c.PESID = '31823'";  
            
            $read = $conn->prepare("SELECT e.NOME_APELIDO as APELIDO, SUM(a.MECQUANTIDADE1) AS QTD, e.COR AS COR, e.MATFANTASIA AS MATFAN "
                                    . "FROM TB_MEC_MATESTCONTROLE a "
                                    . "INNER JOIN TB_MAT_MATERIAL b ON b.MATID = a.MATID "
                                    . "INNER JOIN TB_FIL_FILIAL c ON c.FILID = a.FILID "
                                    . "INNER JOIN TB_PES_PESSOA d ON d.PESID = c.PESID "
                                    . "INNER JOIN TB_DRIP_APELIDO e ON e.MATFANTASIA = b.MATFANTASIA "
                                    . "{$where} "
                                    . "AND a.MECQUANTIDADE1 > '0'
                                       AND NOT b.NCMID = '56' 
                                       AND NOT b.NCMID = '65'
                                       AND NOT b.NCMID = '66'
                                       AND NOT b.NCMID = '68'
                                       AND NOT b.NCMID = '71'
                                       AND NOT b.NCMID = '75'"
                                    . "GROUP BY e.NOME_APELIDO, e.COR, e.MATFANTASIA " 
                                    . "ORDER BY QTD desc ");

            //$read->bindParam(':buscar', $buscar, PDO::PARAM_STR);
            $read->setFetchMode(PDO::FETCH_ASSOC);            
            $read->execute();   
            $array = $read->fetchAll();       
        
            $qtd = 0;

            ?>
            
                <?php 
                foreach ($array as $dados): 
                $qtd += $dados["QTD"];
                    ?>
                        <div class="card">

                            <div class="imgBx">
                                <img src="image/testeProdutos/<?= $dados["MATFAN"]; ?>.jpg">
                            </div>
                        <h3><?= $dados["APELIDO"]; ?></h3>
                        <h6>Cor: <?= $dados["COR"]; ?></h4>
                        <p><?= $dados["MATFAN"]; ?></p>
                        <h5>Qtd estoque: <?= number_format($dados["QTD"], 0, ",", "."); ?></h3>
                        
                                                               
                            
                        </div>
                <?php
                endforeach; 
                //echo "Total geral: {$qtd}";
                ?>
           
        


    </body>
</html>
