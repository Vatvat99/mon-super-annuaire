// Quand le DOM est chargé
$(document).ready( function () {

    // Tableau Datatable
    $('#listing').DataTable({
        'lengthChange': false,
        'searching': true,
        "columns": [
            null,
            null,
            null,
            null,
            null,
            { "orderable": false }
        ],
        'language': {
            url: '/js/fr_FR.json'
        }
    });

    // Tooltips bootstrap
    $('[data-toggle="tooltip"]').tooltip()

});

