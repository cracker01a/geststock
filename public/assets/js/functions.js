/**
 *
 * Fonction pour gérer les fonctions de basculement.
 * Exemple (Cacher ou Afficher un element=Balise)
 *
 * tag_1 = Balise 1 : Premier element à afficher
 * tag_2 = Balise 2 : Second element à afficher
 * tag_3 = Balise 3 : Balise d'action pour switcher. Balise form (input= checkbox)
 * val_compare = Valeur de comparaison exemple : YES/NO
 *
 */
function switch_tags(tag_1 , tag_2, tag_3, val_compare){

    if ($(tag_3).val() === val_compare) {
        $(tag_1).removeClass('d-none')
        $(tag_2).addClass('d-none')
    }else{
        $(tag_2).removeClass('d-none')
        $(tag_1).addClass('d-none')
    }
}

/**
 *
 * Fonction pour afficher les message d'alert Activer / Desactiver.
 * response = Reponse de comparaison
 * message_1 = Message à afficher en cas d'égalité
 * message_2 = Message à afficher en cas d'inégalité
 *
 */
function msg_act_ele(response, message_1 , message_2){

    if (response === 'YES') {
        $("#showMsg").append(`
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <div class="alert-body"><i data-feather='check'></i><span> ${message_1} </span></div>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
        `)
    }else{
        $("#showMsg").append(`
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <div class="alert-body"><i data-feather='x-circle'></i><span> ${message_2} </span></div>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
        `)
    }

}

/**
 *
 * Fonction pour afficher les message d'alert
 * type = Représente le type du message (success - danger - warning - info)
 * message = Représente le message à afficher
 *
 */
function message_alert(type,message,id='#showMsg', time=0){
    var icon = type === 'success' ? 'check' : ( type === 'warning' ? 'alert-triangle' : (type === 'danger' ? 'x-circle' : 'info') )

    $(id).append(`
        <div class="alert alert-${type} alert-dismissible fade show" role="alert">
            <div class="alert-body"><i data-feather='${icon}'></i><span> ${message} </span> </div>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
        </div>
    `)

}

/**
 *
 * Fonction pour validation number phone
 */

function validation_number_phone(submit_id){

    var country_code = []
    var validate = true
    $(submit_id + " .country_code").each(function (ele_index , ele_item) {
        country_code[ele_index] = $(this).find('option:selected').text()
    })

    $(submit_id + ' .phone').each(function (ele_index , ele_item) {
        var number_phone = country_code[ele_index]+''+$(this).val()

        try {
            if (!libphonenumber.parsePhoneNumber(number_phone).isValid()) {
                $(this).css({"border": "1px solid red" , "border-radius": "5px"})
                validate = false
            }else{
                $(this).css({"border-color": "#D8D6DE"})
            }
        } catch (error) {
            $(this).css({"border": "1px solid red" , "border-radius": "5px"})
            validate = false
        }
    })
    if (validate) {
        $(submit_id+" #btn-submit").removeAttr('disabled')
    }else{
        $(submit_id+" #btn-submit").attr('disabled','disabled')
    }

}

function removePicture(tag_file_id , tag_img_id , edit=false){

    $('#'+tag_file_id).val('')
    if (edit) {
        $('#remove_picture').val('YES')
    }

    $('#'+tag_img_id).attr('src' , 'images/default-picture.jpg')
    // console.log($('#'+tag_file_id).val())
}
