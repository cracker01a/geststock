<script>
    let achat_table = $('#achat_table').DataTable();

$(document).ready(function() {
    load_table()
})


function load_table(){

    var sites_id = $('#sites_id').val()

    var route = "{{ route('achat.get_data' , [':sites_id']) }}"
        route = route.replace(':sites_id' , sites_id)

    achat_table.destroy(); // Supprimer le contenu de la balise tbody

    achat_table = $('#achat_table').DataTable({
        // stateSave: true,
        processing: true,
        serverSide: false,
        "responsive": true,
        "autoWidth": true,
        "paging" : true,
        "searching": true,
        "info":     true,
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
            {data: 'id', name: 'id'},
            {data: 'num', name: 'num'},
            {data: 'name', name: 'name'},
            {data: 'unit_price', name: 'unit_price'},
            {data: 'quantity', name: 'quantity'},
            {data: 'total_price', name: 'total_price'},
            {data: 'date', name: 'date'},
            {data: 'by', name: 'by'},
            {data: 'status', name: 'status'},
            {data: 'actions', name: 'actions'},

        ],
        "rowCallback": function( row, data ) {

        },
    });
}

</script>
