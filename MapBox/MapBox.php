<?php
/**
 * Created by PhpStorm.
 * User: Daan Corporaal
 * Date: 2-11-2018
 * Time: 11:33
 */
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8' />
    <title>Display buildings in 3D</title>
    <meta name='viewport' content='initial-scale=1,maximum-scale=1,user-scalable=no' />
    <script src='https://api.tiles.mapbox.com/mapbox-gl-js/v0.50.0/mapbox-gl.js'></script>
    <link href='https://api.tiles.mapbox.com/mapbox-gl-js/v0.50.0/mapbox-gl.css' rel='stylesheet' />
    <style>
        body { margin:0; padding:0; }
        #map { position:absolute; top:0; bottom:0; width:100%; }
    </style>
</head>
<body>

<div id='map'></div>
<script>
    mapboxgl.accessToken = 'pk.eyJ1IjoiZGFhbmNvcnBvcmFhbCIsImEiOiJjajRqcHZ3aWswZzRuMzJzZWV6NTVudWNoIn0.2HkU7BZBUnYb9QnHjrGmNQ';
    var map = new mapboxgl.Map({
        style: 'mapbox://styles/mapbox/light-v9',
        // long - lat
        center: [4.9888, 52.3166],
        zoom: 15.5,
        pitch: 45,
        bearing: -17.6,
        container: 'map'
    });

    // The 'building' layer in the mapbox-streets vector source contains building-height
    // data from OpenStreetMap.
    map.on('load', function() {
        // Insert the layer beneath any symbol layer.
        var layers = map.getStyle().layers;

        var labelLayerId;
        for (var i = 0; i < layers.length; i++) {
            if (layers[i].type === 'symbol' && layers[i].layout['text-field']) {
                labelLayerId = layers[i].id;
                break;
            }
        }

        map.addLayer({
            'id': '3d-buildings',
            'source': 'composite',
            'source-layer': 'building',
            'filter': ['==', 'extrude', 'true'],
            'type': 'fill-extrusion',
            'minzoom': 15,
            'paint': {
                'fill-extrusion-color': '#aaa',

                // use an 'interpolate' expression to add a smooth transition effect to the
                // buildings as the user zooms in
                'fill-extrusion-height': [
                    "interpolate", ["linear"], ["zoom"],
                    15, 0,
                    15.05, ["get", "height"]
                ],
                'fill-extrusion-base': [
                    "interpolate", ["linear"], ["zoom"],
                    15, 0,
                    15.05, ["get", "min_height"]
                ],
                'fill-extrusion-opacity': .6
            }
        }, labelLayerId);


    });
</script>

</body>
</html>