<script>
    repeater_bloc(["#create-form"])


    $(document).ready(function() {
        $('select').each(function() {
            if (!$(this).hasClass('select2-hidden-accessible')) {
                $(this).select2();
            }
        });
    });

    function add_new_achats(){
        setTimeout(function() {
            $('select').each(function() {
                if (!$(this).hasClass('select2-hidden-accessible')) {
                    $(this).select2();
                }
            });
        }, 100);
    }

    var total_general = 0;

    function total(element){

        var parentRow = $(element).closest('.row');
        var unitPrice = parentRow.find('input[name*="[unit_price]"]').val() ?? 0;
        var quantity = parentRow.find('input[name*="[quantity]"]').val() ?? 0;
        var total = unitPrice * quantity;
        parentRow.find('input[name*="[total_vente]"]').val(total);
        total_general = parseInt(total_general) + parseInt(total)
        $('#total_general').html(total_general+" F CFA")
    }

    function get_price_unit(element){


        var product_id = $(element).val()
        var route = "{{ route('product.price' , ':id') }}"
            route = route.replace(':id' , product_id)

        $.ajax({
            type: "GET",
            url: route,
            success: function(data) {

                var parentRow = $(element).closest('.row');
                parentRow.find('input[name*="[unit_price]"]').val(data.price);
                // total(element)

            },
            error: function(err){
                console.log(err)
            }
        });

    }

</script>
