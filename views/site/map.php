<style>
    #map {
        width: 100%;
        height: 600px
    }
</style>


<div id="map"></div>


<script>
    $(document).ready(function () {
        var map = L.map('map').setView([68.959, 33.061], 12);
        L.tileLayer('http://192.168.56.20/osm_tiles/{z}/{x}/{y}.png', {maxZoom: 18}).addTo(map);
        var marker = L.marker([69, 33], {draggable: 'true'}).addTo(map);

        // function onMapClick(e) {
        //     alert("You clicked the map at " + e.latlng);
        // }
        // map.on('click', onMapClick);

        var popup = L.popup();

        function onMapClick(e) {
            popup
                .setLatLng(e.latlng)
                .setContent("You clicked the map at " + e.latlng.toString())
                .openOn(map);
        }

        map.on('click', onMapClick);

        $.ajax({
            url: "coordinates",
            method: "POST",
            dataType: "JSON",
            success: function (markers) {
                for ( var i=0; i < markers.length; ++i )
                {
                    L.marker( [markers[i].lat_d, markers[i].lng_d], {draggable: 'true'})
                        .bindPopup( '<strong>'+ markers[i].company_title + '</strong> ' +
                                    '<hr>'+
                                    '<strong> Расположение: </strong>' + markers[i].placement + '<br>' +
                                    'Частота: ' + markers[i].frequency + ' МГц' + '<br>' +
                                    'Документ: ' + markers[i].records_location + '<br>' +
                                    'Заявка: ' + markers[i].req_num + '<br>'
                        )
                        .addTo( map );
                }
                // L.marker( [markers.lat, markers.lng] )
                //     .bindPopup( '<a href="' + markers.url + '" target="_blank">' + markers.name + '</a>' )
                //     .addTo( map );
            }
        });
    })

</script>
