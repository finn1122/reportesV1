
    <div id="app">
      <div class="w-full bg-gray-50">
        <h1 class='text-2xl font-bold text-center'>Detalles</h1>
        <h2 class='text-lg text-center'>
    </h2>
        <div class="flex w-full justify-center">
          <table class="table-fixed border-gray-500 w-4/5 mx-12 mt-14">
            <thead class="">
              <tr class="border-b-2 border-black">
                <th class="w-4/12 bg-gray-300 text-left px-2">Unidad</th>
                <th class="w-4/12 bg-gray-300 text-left px-2">Evento</th>
                <th class="w-4/12 bg-gray-300 text-left px-2">Hora inicio</th>
                <th class="w-4/12 bg-gray-300 text-left px-2">Hora fin</th>
                <th class="w-4/12 bg-gray-300 text-left px-2">Duración</th>
                <th class="w-4/12 bg-gray-300 text-left px-2">Ubicación</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-400">

              <tr>
                @foreach ($agruparEventos as $row)
                <td class="text-left px-2">{{$row->nb_unidad}}</td>
                <td class="text-left px-2">
                  <p class="text-sm">
                    {{$row->nb_evento}}
                  </p>
                </td>
                <td class="px-2">{{$row->hora_inicio}}</td>
                <td class="px-2">{{$row->hora_fin}}</td>
                <td class="px-2">{{$row->duracion}}</td>
                <td class="px-2">
                  <p class="underline text-blue-600 text-sm">
                    <a href="{{$row->street_view}}"  target="_blank">Ubicación del evento.</a>.
                  </p>
                </td>
                @endforeach
              </tr>

            </tbody>
          </table>
        </div>
      </div>
    </div>
    
    <script>
    
        let tables = document.getElementsByTagName("table");
          for (var i = 0; i < tables.length; i++) {
            resizableGrid(tables[i]);
          }
          function resizableGrid(table) {
            var row = table.getElementsByTagName("tr")[0],
              cols = row ? row.children : undefined;
            if (!cols) return;
    
            table.style.overflow = "hidden";
    
            var tableHeight = table.offsetHeight;
    
            for (var i = 0; i < cols.length; i++) {
              var div = createDiv(tableHeight);
              cols[i].appendChild(div);
              cols[i].style.position = "relative";
              setListeners(div);
            }
    
            function setListeners(div) {
              var pageX, curCol, nxtCol, curColWidth, nxtColWidth;
    
              div.addEventListener("mousedown", function (e) {
                curCol = e.target.parentElement;
                nxtCol = curCol.nextElementSibling;
                pageX = e.pageX;
    
                var padding = paddingDiff(curCol);
    
                curColWidth = curCol.offsetWidth - padding;
                if (nxtCol) nxtColWidth = nxtCol.offsetWidth - padding;
              });
    
              div.addEventListener("mouseover", function (e) {
                e.target.style.borderRight = "2px solid #0000ff";
              });
    
              div.addEventListener("mouseout", function (e) {
                e.target.style.borderRight = "";
              });
    
              document.addEventListener("mousemove", function (e) {
                if (curCol) {
                  var diffX = e.pageX - pageX;
    
                  if (nxtCol) nxtCol.style.width = nxtColWidth - diffX + "px";
    
                  curCol.style.width = curColWidth + diffX + "px";
                }
              });
    
              document.addEventListener("mouseup", function (e) {
                curCol = undefined;
                nxtCol = undefined;
                pageX = undefined;
                nxtColWidth = undefined;
                curColWidth = undefined;
              });
            }
    
            function createDiv(height) {
              var div = document.createElement("div");
              div.style.top = 0;
              div.style.right = 0;
              div.style.width = "5px";
              div.style.position = "absolute";
              div.style.cursor = "col-resize";
              div.style.userSelect = "none";
              div.style.height = height + "px";
              return div;
            }
    
            function paddingDiff(col) {
              if (getStyleVal(col, "box-sizing") == "border-box") {
                return 0;
              }
    
              var padLeft = getStyleVal(col, "padding-left");
              var padRight = getStyleVal(col, "padding-right");
              return parseInt(padLeft) + parseInt(padRight);
            }
    
            function getStyleVal(elm, css) {
              return window.getComputedStyle(elm, null).getPropertyValue(css);
            }
          }
    </script>