<script src="{{ asset('js/loader.js') }}"></script>

    <script type="text/javascript">
      google.charts.load('current', {'packages':['table']});
      google.charts.setOnLoadCallback(drawTable);

      function drawTable() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Operador');
        data.addColumn('string', 'Tipo de ruta');
        data.addColumn('string', 'Unidad');
        data.addRows([
          @foreach ($choferes as $row)

          ['{{$row->nb_chofer}}',  '{{$row->nb_ruta}}', '{{$row->nb_unidad}}'],
          @endforeach

        ]);


        var table = new google.visualization.Table(document.getElementById('table_div'));

        


        table.draw(data, {showRowNumber: true, width: '100%', height: '100%'});
      }
    </script>
     <!--{{$contador}}-->
    <div id="table_div" style="width: 670px; "></div>

