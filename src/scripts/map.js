import mapboxgl from 'mapbox-gl';

jQuery(document).ready(function ($) {
    if ($('#map').length) {
        // Create a mapbox map and a single marker with coordinates from the data attributes
        let locationLat = $('#map').attr('data-lat');
        let locationLng = $('#map').attr('data-lng');
        let mapToken = 'pk.eyJ1IjoiaG5pa29sb3NraSIsImEiOiJjbGRxOHYzZjYwaGE3M3ZvNHB3eHNleGdsIn0.mwxXDycSSiRcs98vsfAqFA';


        mapboxgl.accessToken = mapToken;


        let map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/light-v11',
            center: [locationLng, locationLat],
            zoom: 14,
        });

        // set marker with custom pin image
        let marker = new mapboxgl.Marker({
            color: '#4aa380',
            draggable: false,
            // width and height of the marker
            width: 50,
            height: 50,

        })
            .setLngLat([locationLng, locationLat])
            .addTo(map);
        $('.mapboxgl-marker').css('background-image', 'url(' + $('#map').attr('data-marker') + ')');
    }
});