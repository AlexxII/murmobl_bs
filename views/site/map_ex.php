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
        $.ajax({
            url: "coordinates-ex",
            method: "POST",
            dataType: "JSON",
            success: function (markers) {
                var m = new L.MarkerClusterGroup();
                for (var i = 0; i < markers.length; i++) {
                    var a = markers[i];
                    var title = a.company_title;
                    var marker = new L.Marker(new L.LatLng(a.lat_d, a.lng_d), {
                        title: title,
                        draggable: 'true',
                        azimuth: a.azimuth,
                        d_width: a.horiz_width,
                        frequency: a.frequency
                    });

                    marker.bindPopup(
                        '<strong>'+ markers[i].company_title + '</strong> ' +
                        '<hr>'+
                        '<strong>ID:</strong>' + markers[i].id + '<br>' +
                        'Тип РЭС: ' + markers[i].res + '<br>' +
                        '<strong> Расположение: </strong>' + markers[i].placement + '<br>' +
                        'Частота: ' + markers[i].frequency + ' МГц' + '<br>' +
                        'Документ: ' + markers[i].records_location + '<br>' +
                        'Заявка: ' + markers[i].req_num + '<br>' +
                        '<strong> Координаты: </strong>' + markers[i].lat + ' с.ш. | ' + markers[i].lng + ' в.д.' + '<br>'+
                        'Азимут: ' + markers[i].azimuth + '<br>'+
                        'Ширина ДНА в горизонт.плоск.:' + markers[i].horiz_width
                    );
                    m.addLayer(marker);
                    marker.on('drag', function (e) {
                        console.log('marker drag event');
                    });
                }
                map.addLayer(m);
                m.addEventListener('mouseout', function (e) {
                    // console.log(c);
                    // console.log($(this).closest('leaflet-interactive'));
                    // m.removeLayer(marker);
                });
                m.addEventListener('mouseover', function (e) {
                    if (map.getZoom() >= 16) {
                        var coordinates = e.latlng;
                        var azimuth = e.layer.options.azimuth;
                        var width = e.layer.options.d_width;
                        var frequency = e.layer.options.frequency;
                        var width_d = parseFloat(width);
                        var length = 400;
                        if (width_d > 0.9 && width_d <= 3) {
                            length = 10000;
                        }
                        var az_d = parseFloat(azimuth);
                        var start_angle = az_d - width_d / 2;
                        var end_angle = az_d + width_d / 2;
                        var frequency_d = parseFloat(frequency);
                        if (frequency_d < 2000) {
                            color = '#9ca3a0';
                        } else if (frequency_d > 2000 && frequency_d < 2100) {
                            color = '#a11524';
                        } else {
                            color = '#39ff95';
                        }
                        var c = L.semiCircle([coordinates.lat, coordinates.lng], {
                            radius: length,
                            startAngle: start_angle,
                            stopAngle: end_angle,
                            fillColor: color,
                            fillOpacity: 0.6
                        }).addTo(map);
                    }
                })
/*
                function markerClick(e)
                {
                    var coordinates = e.latlng;
                    var azimuth = e.target.options.azimuth;
                    var width = e.target.options.d_width;
                    var c = L.semiCircle([coordinates.lat, coordinates.lng], {radius: 400})
                        .setDirection(azimuth, width-1)
                        .addTo(map);
                }
*/
/*
                map.on('layeradd', function (e) {
                    console.log(e);
                });

                map.on('draw:created', function (e) {
                    console.log(e);
                    var type = e.layerType,
                        layer = e.layer;
                    drawnItems.addLayer(layer);
                    console.log(layer);
                });
*/
            }
        });

    })

</script>
