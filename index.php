<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>TD Interop - JS</title>
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css"
            integrity="sha512-Rksm5RenBEKSKFjgI3a41vrjkw4EVPlJ3+OiI65vTjIdo9brlAacEuKOiQ5OFh7cOI1bkDwLqdLw3Zg0cRJAAQ=="
            crossorigin=""/>            
        <link rel="stylesheet" href="css/semantic.css">
        <script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js"
            integrity="sha512-/Nsx9X4HebavoBvEBuyp3I7od5tA0UzAxs+j83KgC8PU0kgB4XiK4Lfe4y4cgBtaRJQEIFCW+oC506aPT2L1zw=="
            crossorigin=""></script>
    </head>

    <body>
        <div class="ui top fixed menu" style="z-index: 1">
            <div class="item">
                <h1>Interopérabilité - JS</h1>
            </div>        
        </div>

        <div class="ui grid" style="margin-top: 20px;">
            <div class="eight wide centered row">
                <?php    
                    // Setup le proxy pour Webetu ici
                
                    $adress_nantes = "Nantes";
                    $api_key = "AIzaSyAUyVBen58FMOii8MUwfqWV_5bPog_rAvg";
                    $geo_url = "https://maps.googleapis.com/maps/api/geocode/json?address=$adress_nantes&key=$api_key";
                
                    $geo_data = file_get_contents($geo_url);
                    $geo_json = json_decode($geo_data);

                    $lat_nantes = $geo_json->results[0]->geometry->location->lat;
                    $lng_nantes = $geo_json->results[0]->geometry->location->lng;


                    $info_url = "http://api.loire-atlantique.fr/opendata/1.0/traficevents?filter=Tous";
                    $info_data = file_get_contents($info_url);
                    $info_json = json_decode($info_data);                    
                ?>
            </div>
        </div>

        <div id="mapid" style="height: 500px; width: 70%; margin: auto; z-index: 0"></div>            

        <script>    
            <?php
                echo "var mymap = L.map('mapid').setView([$lat_nantes, $lng_nantes], 9);";

                foreach($info_json as $info)
                {
                    $lat = $info->latitude;
                    $lng = $info->longitude;
                    $nature = $info->nature;
                    $statut = $info->statut;

                    echo "L.marker([$lat, $lng]).addTo(mymap).bindPopup(\"$nature - $statut\");";
                }
            ?>

            L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
                maxZoom: 18,
                id: 'mapbox.streets',
                accessToken: 'pk.eyJ1IjoiZGVtYXJicmUxdSIsImEiOiJjamN0aDQ4ejMwZmM0MnFudXNmODc1am52In0.F7HMcNCiKY5gygrzGx1obg'
            }).addTo(mymap); 
            
        </script>

    </body>
</html>