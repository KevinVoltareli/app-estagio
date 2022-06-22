   

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
             $where = "WHERE VENDATAHORAFATURAMENTO >= '2022-06-01' ";
        
            $where .= " and VENDATAHORAFATURAMENTO <=  '2022-06-30 23:59' ";
            
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
            
                


    </body>
</html>
