<!-- *********** GRÁFICO QUANTIDADE DE CLIENTES NOVOS ****************** -->

      <?php 

         include "conexao.php";

                 $sql = "SELECT sum(a.VENID) AS TOTALVENID, a.CLIID_PAGADOR 
                         FROM TB_VEN_VENDA a
                         WHERE CLIID_PAGADOR IS NOT NULL 
                         GROUP BY a.CLIID_PAGADOR
                         ORDER BY a.CLIID_PAGADOR";


                                                                         
              $read = $conn->prepare($sql);
              $read->setFetchMode(PDO::FETCH_ASSOC);
              $read->execute();                         
              $array = $read->fetchAll();
              $qtdNovo = 0;
              $qtdAntigo = 0;
              
              $read1 = $conn->prepare("SELECT  a.VENID AS VENIDREAL, a.CLIID_PAGADOR
                                        FROM TB_VEN_VENDA a
                                        WHERE CLIID_PAGADOR IS NOT NULL
                                        GROUP BY a.CLIID_PAGADOR, a.VENID
                                        ORDER BY a.CLIID_PAGADOR  ");

            //$read->bindParam(':buscar', $buscar, PDO::PARAM_STR);
            $read1->setFetchMode(PDO::FETCH_ASSOC);            
            $read1->execute();   
            $array = $read1->fetchAll();
                          
              //$numlinhas = $read->rowCount();  

                     // $qtdNovo++;
                      // $qtdAntigo++;



             foreach ($array as $dados):     
              
                //echo $dataDia;

                if($dados['VENIDREAL'] == $total || $total == 2*$dados['VENIDREAL'] || $total == 3*$dados['VENIDREAL'] || $total == 4*$dados['VENIDREAL']  ){
                  $qtdNovo++;                  
                 } else  {
                  $qtdAntigo++;
                };
                //else if() {  }
              endforeach;
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

                    <!-- GRÁFICO 4 -->
                                <div class="card-body">                                    
                                  <div id="piechart" style="width: 100%; height: 300px;"></div>
                                     <?= $qtdNovo ?> <br>
                                     <?= $qtdAntigo ?>

                                  </div>
                                </div>