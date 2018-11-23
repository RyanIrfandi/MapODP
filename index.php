<?php

include "dbconfig.php";
?>






<!DOCTYPE html >
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <title>MAP ODP</title>
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
    </style>
<script type="text/javascript" async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA4PDma4jktR1lJS_7zKkc0Sykp2_UZpHM&callback=initMap">
    </script>

  </head>

  <body>
    <div id="map"></div>

    <script>
      var customLabel = {
        17: {
          label: '17'
        },
        18: {
          label: '18'
        }
      };




        function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
          center: new google.maps.LatLng(-2.741396, 107.637680),
          zoom: 12
        });



        var infoWindow = new google.maps.InfoWindow;

          // Change this depending on the name of your PHP or XML file
          downloadUrl('\parseToXML.php', function(data) {
            var xml = data.responseXML;
            var markers = xml.documentElement.getElementsByTagName('marker');
            Array.prototype.forEach.call(markers, function(markerElem) {
              var id = markerElem.getAttribute('id');
              var name = markerElem.getAttribute('name');
              var point = new google.maps.LatLng(
                  parseFloat(markerElem.getAttribute('lat')),
                  parseFloat(markerElem.getAttribute('lng')));
              var tahun = markerElem.getAttribute('tahun') % 2000;
              var used_port = markerElem.getAttribute('used_port');
              var total_port = markerElem.getAttribute('total_port');
              var warnaOdp = markerElem.getAttribute('warnaOdp');
              var idle_port =total_port - used_port;
 
 //menampilakn info windows saat di klik point map       

              //create elemen div
              var infowincontent = document.createElement('div');

              //menampilakn nama odp saat di klik
              var strong = document.createElement('strong');
              strong.textContent = name
              infowincontent.appendChild(strong);

              //menampilakn informasi selanjutnya di baris baru
              infowincontent.appendChild(document.createElement('br'));

              //menampilkan sisa port odp
              var text = document.createElement('text');
              text.textContent ="sisa port : "+idle_port
              infowincontent.appendChild(text);

              //menampilakn informasi selanjutnya di baris baru
              infowincontent.appendChild(document.createElement('br'));

              var text = document.createElement('text');
              text.textContent ="total port : "+total_port
              infowincontent.appendChild(text);

              
              var iconBase = '\icon/'; //link folder icon map
              var icons = {

                  hitam: {
                         icon: iconBase + 'hitam.png'
                  },
                  hijau: {
                         icon: iconBase + 'hijau.png'
                  },
                  kuning: {
                         icon: iconBase + 'kuning.png'
                  },
                  merah: {
                         icon: iconBase + 'merah.png'
                  },


              };

              var icon_label = customLabel[tahun]  || {}; //menampilkan 2 digit terakhir dari tahun pada point map
              var icon_logo = icons[warnaOdp] || {};

              var marker = new google.maps.Marker({
                map: map,
                position: point,
                icon: icon_logo.icon,
                label: icon_label.label
              });
          
              



              marker.addListener('click', function() {
                infoWindow.setContent(infowincontent);
                infoWindow.open(map, marker);
              });
            });
          });
        }



      function downloadUrl(url, callback) {
        var request = window.ActiveXObject ?
            new ActiveXObject('Microsoft.XMLHTTP') :
            new XMLHttpRequest;

        request.onreadystatechange = function() {
          if (request.readyState == 4) {
            request.onreadystatechange = doNothing;
            callback(request, request.status);
          }
        };

        request.open('GET', url, true);
        request.send(null);
      }

      function doNothing() {}
    </script>
    
  </body>
</html>







