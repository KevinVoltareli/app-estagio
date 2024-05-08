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

       button a {
        text-decoration: none;

        color: white;
       }

     </style>
    </head>
    <body>
        
             
    

    <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card mt-5">
                        <div class="card-header">
                            <h4></h4>
                        </div>

                        <div class="container">                        

                           <div class="col-12"> 

                       

                    <div class="card mt-4">
                    <div class="card-body">
                        <table class="table table-borderd">
                            <thead>
                                <tr>
                                    <th>Produto</th>      
                                    <th>Filial</th>
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
           
            
            
            $read = $conn->prepare("SELECT  e.PESNOME AS NOME, d.VENDATAHORAFATURAMENTO AS DATAFAT
              FROM
                TB_PED_PEDIDO a
              INNER JOIN
                TB_TVN_TIPOVENDA b ON b.TVNID = a.TVNID 
              INNER JOIN
                TB_CLI_CLIENTE c ON c.CLISEQUENCIAL = a.PEDSEQUENCIAL 
              INNER JOIN
                TB_VEN_VENDA d ON d.CLIID_PAGADOR = c.CLIID 
              INNER JOIN
                TB_PES_PESSOA e ON e.PESID = c.PESID 
              WHERE  
                NOT b.TVNID = '48'
                AND NOT b.TVNID = '49'
                AND NOT b.TVNID = '50'
                AND NOT b.TVNID = '51'
                AND NOT b.TVNID = '52'
                AND NOT b.TVNID = '54'
                AND NOT b.TVNID = '55'              
              ORDER BY e.PESNOME");

            $read->setFetchMode(PDO::FETCH_ASSOC);            
            $read->execute();   
            $array = $read->fetchAll();       
        
            $qtd = 0;

            ?>
            
                <?php 
                foreach ($array as $dados): 
                //$qtd += $dados["ID"];
                  if($dados["DATAFAT"] == $dados["DATAFAT"]) {
                    ?>
                    <tr>
                        <td><?= $dados["NOME"]; ?></td>
                        <td><?= $dados["DATAFAT"]; ?></td>
                        <td><?php echo 'sim' ?></td>
                    </tr>
                <?php
                }
                endforeach; 
                ?>
            </table>
            <?php
           // echo "Total geral: {$qtd}";

        ?>


    </body>
</html>
