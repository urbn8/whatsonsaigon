$(document).on('ready', function() {
    $("#urbn8-wos-map").width("100%").height("200px").gmap3({
        map: {
            options: {
                center: [20.9697228, -89.6309225],
                zoom: 14
            }
        },
        marker: {
            latLng: [20.9697228, -89.6309225],
            options: {
                draggable: true,
                center: [20.9697228, -89.6309225],
            },
            events: {
                dragend: function(marker) {
                    $(this).gmap3({
                        getaddress: {
                            latLng: marker.getPosition(),
                            callback: function(results) {
                                var content = results && results[0] ? results && results[0].formatted_address : "no address";
                                $('#Form-field-Event-lat_long').val(marker.getPosition())
                                $('#Form-field-Event-address').val(content)
                            }
                        }
                    });
                }
            }
        },
    });
})