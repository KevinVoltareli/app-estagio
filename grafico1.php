<html>
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Produtos', '' ],

          <?php 

        $dataInicialEstoque = '2018-01-01';
        $dataFinalEstoque = '2024-12-31';

        $dataInicialVenda = '2023-01-01';
        $dataFinalVenda = '2023-01-31 23:59';

         include "conexao.php";

         // ***************  GRÁFICO PRODUTOS VENDIDOS *****************

          $sql = "SELECT FIRST 15 DISTINCT h.NOME_APELIDO AS NOME, sum(l.PICQTDE) AS TOTAL 
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
                            ORDER BY total DESC ";
                   
              $read = $conn->prepare($sql);
              $read->setFetchMode(PDO::FETCH_ASSOC);
              $read->execute();                         
              $array = $read->fetchAll();
              //$numlinhas = $read->rowCount();               
             
              foreach($array as $dados) { ?>

               ['<?= $dados['NOME']  ?> ', <?= $dados['TOTAL'] ?> ],             

        <?php } ?>
        ]);
      

         

        var options = {
          chart: {
             
          },
          bars: 'horizontal' // Required for Material Bar Charts.
        };

        var chart = new google.charts.Bar(document.getElementById('barchart_material'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }

    </script>

    <!-- GRAFICO 2 -->
     <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Produtos', ''],

          <?php 

         include "conexao.php";

         // ***************  GRÁFICO PRODUTOS ESTOQUE *****************

          $sql = "SELECT FIRST 15 DISTINCT e.NOME_APELIDO as APELIDO, SUM(a.MECQUANTIDADE1) AS QTD "
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
                                    . "ORDER BY QTD desc";
                   
              $read = $conn->prepare($sql);
              $read->setFetchMode(PDO::FETCH_ASSOC);
              $read->execute();                         
              $array = $read->fetchAll();
              //$numlinhas = $read->rowCount();               
             
              foreach($array as $dados) { ?>

                ['<?= $dados['APELIDO']  ?> ', <?= $dados['QTD'] ?>, ],


        <?php } ?>
        ]);
      

         

        var options = {
          chart: {
            
          },
          bars: 'horizontal' // Required for Material Bar Charts.
        };

        var chart = new google.charts.Bar(document.getElementById('barchart_material3'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }

    </script>


    <!-- GRAFICO 3 FILIAIS -->
     <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Filiais', ''],

          <?php 

         include "conexao.php";

          $sql = "SELECT c.PESNOME AS NOME, sum(PEDVALORLIQUIDO)-SUM(PEDVALORDESCONTOTOTAL) AS TOTAL "
                        . "FROM TB_PED_PEDIDO a "                       
                        . "INNER JOIN TB_FIL_FILIAL b ON b.FILID = a.FILID_FILIAL "
                        . "INNER JOIN TB_PES_PESSOA c ON b.PESID = c.PESID "                         
                        . "WHERE PEDDATAENTRADA >= '2022-12-01' AND PEDDATAENTRADA <= '2022-12-31 23:59' "
                        . "AND (MCVID != 2 OR MCVID IS NULL)
                           AND (MCVID != 3 OR MCVID IS NULL)
                           AND (MCVID != 4 OR MCVID IS NULL)
                           GROUP BY c.PESNOME ORDER BY TOTAL DESC";
                   
              $read = $conn->prepare($sql);
              $read->setFetchMode(PDO::FETCH_ASSOC);
              $read->execute();                         
              $array = $read->fetchAll();
              //$numlinhas = $read->rowCount();               
             
              foreach($array as $dados) { ?>

               ['<?= $dados['NOME']  ?>', <?= $dados['TOTAL'] ?> ],

        <?php } ?>
        ]);
      

         

        var options = {
          chart: {
            
          },
          bars: 'horizontal' // Required for Material Bar Charts.
        };

        var chart = new google.charts.Bar(document.getElementById('barchart_material2'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }

    </script>

<!-- *********** GRÁFICO QUANTIDADE DE CLIENTES NOVOS ****************** -->

      <?php 

         include "conexao.php";

                        $sql = "SELECT d.VENID, e.PESNOME AS NOME ,d.CLIID_PAGADOR , a.PEDDATAENTRADA AS DATAENTRADA, a.PEDDATADIGITACAO AS DATADIGITACAO, d.VENDATAHORAFATURAMENTO AS DATAFAT
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
              ORDER BY d.CLIID_PAGADOR   ";
                                                 
              $read = $conn->prepare($sql);
              $read->setFetchMode(PDO::FETCH_ASSOC);
              $read->execute();                         
              $array = $read->fetchAll();
              $qtdNovo = 0;
              $qtdAntigo = 0;
              
              //$numlinhas = $read->rowCount();  

                     // $qtdNovo++;
                      // $qtdAntigo++;



             /* foreach ($array as $dados):     
                $dataDia = date("d/m/Y",strtotime($dados["DATAFAT"]));
            
                echo $dataDia;
                if($dataDia == $dataDia) { 
                  $qtdNovo++;
                } else  {
                  $qtdAntigo++;
                };
                //else if() {  }
              endforeach;*/

               /*foreach ($array as $dados): 
                //$qtd += $dados["TOTAL"];
                    ?>
                    <tr>
                        <td><?= $dados["NOME"]; ?></td>
                        <td><?= $dados["DATAFAT"]; ?></td>

                    </tr>
                    
                <?php
                endforeach; */
               ?>
                

        <script type="text/javascript">
          google.charts.load('current', {'packages':['corechart']});
          google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
          ['Novo',  <?=$qtdNovo?>], //copia $qtdNovo
          ['Antigo',  <?=$qtdAntigo?>], //copia qtdAntigo
                    
        ]);
          //titulo do gráfico
        var options = {
         
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }
    </script>

      
     
  </head> 
</html>