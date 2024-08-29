<script>
    let achat_table = $('#achat_table').DataTable();

$(document).ready(function() {
    load_table()
})


function load_table(){

    var sites_id = $('#sites_id').val()

    var route = "{{ route('achat.get_data1' , [':sites_id']) }}"
        route = route.replace(':sites_id' , sites_id)

    product_table.destroy(); // Supprimer le contenu de la balise tbody

    product_table = $('#achat_table').DataTable({
        // stateSave: true,
        processing: true,
        serverSide: false,
        "responsive": true,
        "autoWidth": true,
        "paging" : true,
        "searching": true,
        "info":     true,
        // "language" : {
        //     "url" : '{!!asset('/plugins/dataTable.french.lang')!!}'
        // },
        // dom: '<"card-header border-bottom p-1"<"head-label"><"dt-action-buttons text-right"B>><"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
        // displayLength: 50,
        // lengthMenu: [10, 25, 50, 75, 100],
        // buttons: [
        //     {
        //         extend: 'collection',
        //         className: "btn btn-outline-secondary dropdown-toggle mr-2",
        //         text: feather.icons['share'].toSvg({ class: 'font-small-4 mr-50' }) + 'Exporter',

        //         buttons: [
        //             {
        //                 extend: 'print',
        //                 text: feather.icons['printer'].toSvg({ class: 'font-small-4 mr-50' }) + 'Imprimer',
        //                 className: 'dropdown-item',
        //                 exportOptions: { columns: export_column }
        //             },
        //             {
        //                 extend: 'csv',
        //                 text: feather.icons['file-text'].toSvg({ class: 'font-small-4 mr-50' }) + 'Csv',
        //                 className: 'dropdown-item',
        //                 exportOptions: { columns: export_column }
        //             },
        //             {
        //                 extend: 'excel',
        //                 text: feather.icons['file'].toSvg({ class: 'font-small-4 mr-50' }) + 'Excel',
        //                 className: 'dropdown-item',
        //                 exportOptions: { columns: export_column }
        //             },
        //             {
        //                 extend: 'pdf',
        //                 text: feather.icons['clipboard'].toSvg({ class: 'font-small-4 mr-50' }) + 'Pdf',
        //                 className: 'dropdown-item',
        //                 exportOptions: { columns: export_column }
        //             },
        //                 {
        //                 extend: 'copy',
        //                 text: feather.icons['copy'].toSvg({ class: 'font-small-4 mr-50' }) + 'Copier',
        //                 className: 'dropdown-item',
        //                 exportOptions: { columns: export_column }
        //             }
        //         ],

        //     },
        //     {
        //         text: feather.icons['plus'].toSvg({ class: 'mr-50 font-small-4' }) + add_btn.label,
        //         className: add_btn.label !== null ? 'create-new btn btn-primary' : 'd-none',
        //         attr: {
        //             'data-toggle': 'modal',
        //             'data-target': add_btn.modal_id,
        //             'id' : 'btn_add_notes',
        //             'onclick' : "add_notes_student()"
        //         },

        //         init: function (api, node, config) {
        //             $(node).removeClass('btn-secondary');
        //         }
        //     }

        // ],
        ajax: {
            'url' : route,
            // success : function (data) {
            //     console.log(data)
            // },
            // error: function (err){
            //     console.log(err)
            // }
        },
        columns: [
            {data: 'name', name: 'name'},
            {data: 'unit_price', name: 'unit_price'},
            {data: 'quantity', name: 'quantity'},
            {data: 'total_price', name: 'total_price'},
            {data: 'by', name: 'by'},
            {data: 'status', name: 'status'},
            {data: 'actions', name: 'actions'},
           
        ],
        "rowCallback": function( row, data ) {

        },
    });
}

</script>
