<?php $conexao = new PDO("firebird:dbname=C:\SavWinRevo\Servidor\DataBase\BDSAVWINREVO.FDB", "SYSDBA", "masterkey"); ?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
 
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
 
    <title>Gráficos Ricardo Milbrath</title>
  </head>
  <body>
    
 
 
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">
    google.charts.load("current", {packages:['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ["Cidade", "População", { role: "style" } ],
       
        <?php
                           

                            $sql = "SELECT e.apelido AS modelo , sum(a.MVMQUANTIDADE) AS total "
                                    . "FROM TB_MVM_MOVMATITEM a "
                                    . "INNER JOIN TB_MAT_MATERIAL b ON a.MATID = b.MATID "
                                    . "INNER JOIN TB_AAT_ATRIBUTOS c ON a.matid = c.MATID "
                                    . "INNER JOIN TB_ARM_ATRMODELO d ON c.ARMID = d.ARMID "
                                    . "INNER JOIN ARM_APELIDO e ON d.ARMDESCRICAO = e.ARMDESCRICAO  "
                                    . " GROUP BY e.APELIDO ORDER BY modelo, total desc";

        $busca = mysqli_query($conexao,$sql);
 
        while ($dados = mysqli_fetch_array($busca)) {
            $modelo = $dados['modelo'];
             $total = $dados['total'];
       
 
         ?>
 
        ["<?php echo $modelo ?>", <?php echo $total ?>, "#ffd432"],
       
 
      <?php } ?>
 
      ]);
 
      var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);
 
      var options = {
        title: "Cidade x População",
        width: 1200,
        height: 500,
        bar: {groupWidth: "80%"},
        legend: { position: "none" },
      };
      var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
      chart.draw(view, options);
  }
  </script>
<div id="columnchart_values" style="width: 1200px; height: 500px;"></div>
 
 
 
    <!-- Optional JavaScript; choose one of the two! -->
 
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
 
    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->
  </body>
</html>