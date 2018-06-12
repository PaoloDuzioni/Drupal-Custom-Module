jQuery(document).ready(function($) {

    var mapElem = $("#map"),
    
    myMap = {
        'title'    : mapElem.attr('data-title'),
        'lat'      : mapElem.attr('data-lat'),
        'long'     : mapElem.attr('data-lon'),
        'addr'     : mapElem.attr('data-addr'),
        'url'     : mapElem.attr('data-url'),
        'style'    : [{featureType:'all',stylers:[{saturation:-80}]},{featureType:'road.arterial',elementType:'geometry',stylers:[{hue:'#00ffee'},{saturation:50}]},{featureType:'poi.business',elementType:'labels',stylers:[{visibility:'off'}]}]
    },
    
    myLatLng = new google.maps.LatLng(myMap.lat, myMap.long),

    mapOptions = {
        zoom: 13,
        center: myLatLng,
        mapTypeControl: false,
        scrollwheel: false,
        streetViewControl: false,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        styles: myMap.style
    };

    console.log('Url: ' + myMap.url); 
    console.log('Lat: ' + myMap.lat); 
    console.log('Long: ' + myMap.long); 

    var map = new google.maps.Map(document.getElementById("map"), mapOptions);

    var contentString = '<div id="content">'+
    '<div id="bodyContent">'+
        '<h5>' + myMap.title + '</h5>'+
    '<div>' + myMap.addr + '</div>'+
    '<div><a target="_blank" href="' + myMap.url + '">Open in maps</a></div>'+
    '</div>'+
    '</div>';

    var infowindow = new google.maps.InfoWindow({
        content: contentString
    });

    var marker = new google.maps.Marker({
        position: myLatLng,
        map: map,
        title: myMap.title + ' - ' + myMap.addr
    });
    marker.addListener('click', function() {
        infowindow.open(map, marker);
    });

});