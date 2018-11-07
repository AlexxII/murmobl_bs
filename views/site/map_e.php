<style>
    #map {
        width: 100%;
        height: 600px
    }
</style>


<div id="map"></div>

<script>

    var map;
    var region;

    $(document).ready(function () {
        window.map = L.map('map').setView([68.959, 33.061], 12);
        L.tileLayer('http://192.168.56.20/osm_tiles/{z}/{x}/{y}.png', {maxZoom: 18}).addTo(map);
    });

    $(document).ready(function () {
        window.map.on('click', function (e) {
            var latlng = e.latlng;
            var radius = 500;
            window.region = L.marker(e.latlng, {draggable: 'true'}).addTo(window.map);
        })
    });


/*
    $(document).ready(function () {
        map.on("contextmenu", function (event) {
            L.marker(event.latlng, {draggable: 'true'}).addTo(map);
        });
    });
*/

    $(document).ready(function () {
1
        map.on("contextmenu", function (e) {
            var marker = new L.marker(e.latlng).addTo(window.map);
            console.log(turf.distance(marker.toGeoJSON(), window.region.toGeoJSON()) * 1000);
        });
    });

</script>
