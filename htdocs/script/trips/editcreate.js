var bwTripsLocations;

/**
 * Checks if all rows are filled now. If so adds a new row
 * @returns {boolean}
 */
function checkLocationRows() {
    complete = true;
    $('div[id^=div-location]').find('.validate').each( function() {
        var value = $(this).val();
        complete &= (value != '');
    });
    if (complete) {
        var next = $('div[id^=div-location]').length + 1;
        $('#location-loading').show();
        var url = '/trips/addlocation/' + next;
        var newLocation = $('<div id="div-location-' + next + '">').load(url,
            function () {
                $('#empty-location').before(newLocation);
                setTimeout(enableAutoComplete(addMarker), 500);
                setTimeout(enableDatePicker(), 500);
                setTimeout(enableSelect2, 500);
                $('#location-loading').hide();
            });
    }
    return false;
}

function enableDatePicker() {
    $( ".date-picker-start" ).datepicker({
        changeMonth: true,
        numberOfMonths: 1,
        dateFormat: "yy-mm-dd",
        onClose: function( selectedDate ) {
            var id = this.id.replace('startdate', 'enddate');
            $( '#' + id ).datepicker( "option", "minDate", selectedDate );
            var date = $( '#' + id).val();
            if (date == undefined || date == '') {
                $( '#' + id).val(selectedDate);
            }
            checkLocationRows();
        }

    });
    $( ".date-picker-end" ).datepicker({
        changeMonth: true,
        numberOfMonths: 1,
        dateFormat: "yy-mm-dd",
        onClose: function( selectedDate ) {
            var id = this.id.replace('enddate', 'startdate');
            $( '#'+ id ).datepicker( "option", "maxDate", selectedDate );
            checkLocationRows();
        }
    });
}

/**
 * enableSelect2
 */
function enableSelect2() {
    $(".select2").select2({
        allowClear: true,
        dropdownAutoWidth: true,
        width: '100%',
        minimumResultsForSearch: -1
    });
}

/**
 *
 * @constructor
 */
function BWTripsLocations(htmlMapId) // Constructor
{
    this.addMarkerCallback = function(label, geonameid, latitude, longitude) {
        BWTripsLocations.addMarker(label, geonameid, latitude, longitude);
    };

    var instance = this;
    instance.map = initMap(htmlMapId).fitWorld();
    instance.latLngs = [];
    instance.polyline = null;
    instance.addMarker = function(id, label, geonameid, latitude, longitude) {
        // get current location number
        var parts = id.split("-");
        var current = parts[1] - 1;
        $('#remove-' + parts[1]).removeAttr('disabled');
        $('#remove-' + parts[1]).click( instance.removeRow );
        if (current == instance.latLngs.length) {
            instance.latLngs.push(new L.LatLng(latitude, longitude));
        } else {
            instance.latLngs[current] = new L.LatLng(latitude, longitude);
        }
        if (instance.polyline != null) {
            instance.map.removeLayer(instance.polyline);
        }
        instance.polyline = new L.polyline(instance.latLngs, {color: 'red'}).addTo(instance.map);
        instance.map.fitBounds(instance.polyline.getBounds());
        checkLocationRows();
    };

    instance.removeMarker = function(id) {

    };

    instance.removeRow = function( e ) {
        var parts = this.id.split("-");
        var current = parts[1] - 1;

        return false;
    }
}

$( document ).ready(function() {
    enableDatePicker();
    enableSelect2();

    bwTripsLocations = new BWTripsLocations('trips-map');

    addMarker = bwTripsLocations.addMarker;
});