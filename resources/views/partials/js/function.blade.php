<script>

    /*
    * -------------------------------------------------------------------------
    * DataTable function
    * -------------------------------------------------------------------------
    *
    */
//     function dataTable(name, export_column, add_btn={label:null,modal_id:null}, orderGroup=false , tag_id="#table", responsive=true, autoWith=true, paging=true, searching=true, info=true ){
//           if (!orderGroup) {
//               $(tag_id).DataTable({
//                   "responsive": responsive,
//                   "autoWidth": autoWith,
//                   "paging" : paging,
//                   "searching": searching,
//                   "info":     info,
//                   "language" : {
//                       "url" : '{!!asset('/plugins/dataTable.french.lang')!!}'
//                   },
//                   dom:
//                       '<"card-header border-bottom p-1"<"head-label"><"dt-action-buttons text-right"B>><"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
//                   displayLength: 7,
//                   lengthMenu: [7, 10, 25, 50, 75, 100],

//                   buttons: [
//                       {
//                           extend: 'collection',
//                           className: "btn btn-outline-secondary dropdown-toggle mr-2",
//                           text: feather.icons['share'].toSvg({ class: 'font-small-4 mr-50' }) + 'Exporter',

//                           buttons: [
//                               {
//                                   extend: 'print',
//                                   text: feather.icons['printer'].toSvg({ class: 'font-small-4 mr-50' }) + 'Imprimer',
//                                   className: 'dropdown-item',
//                                   exportOptions: { columns: export_column }
//                               },
//                               {
//                                   extend: 'csv',
//                                   text: feather.icons['file-text'].toSvg({ class: 'font-small-4 mr-50' }) + 'Csv',
//                                   className: 'dropdown-item',
//                                   exportOptions: { columns: export_column }
//                               },
//                               {
//                                   extend: 'excel',
//                                   text: feather.icons['file'].toSvg({ class: 'font-small-4 mr-50' }) + 'Excel',
//                                   className: 'dropdown-item',
//                                   exportOptions: { columns: export_column }
//                               },
//                               {
//                                   extend: 'pdf',
//                                   text: feather.icons['clipboard'].toSvg({ class: 'font-small-4 mr-50' }) + 'Pdf',
//                                   className: 'dropdown-item',
//                                   exportOptions: { columns: export_column }
//                               },
//                                   {
//                                   extend: 'copy',
//                                   text: feather.icons['copy'].toSvg({ class: 'font-small-4 mr-50' }) + 'Copier',
//                                   className: 'dropdown-item',
//                                   exportOptions: { columns: export_column }
//                               }
//                           ],

//                       },
//                       {
//                           text: feather.icons['plus'].toSvg({ class: 'mr-50 font-small-4' }) + add_btn.label,
//                           className: add_btn.label !== null ? 'create-new btn btn-primary' : 'd-none',
//                           attr: {
//                               'data-toggle': 'modal',
//                               'data-target': add_btn.modal_id
//                           },

//                           init: function (api, node, config) {
//                               $(node).removeClass('btn-secondary');
//                           }
//                       }

//                   ],

//               });
//           } else {
//               $(tag_id).DataTable({
//               "responsive": responsive,
//               "autoWidth": autoWith,
//               "paging" : paging,
//               "searching": searching,
//               "info":     info,
//               "language" : {
//                   "url" : '{!!asset('/plugins/dataTable.french.lang')!!}'
//               },
//               dom:
//                   '<"card-header border-bottom p-1"<"head-label"><"dt-action-buttons text-right"B>><"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
//               displayLength: 7,
//               lengthMenu: [7, 10, 25, 50, 75, 100],

//               buttons: [
//                   {
//                       extend: 'collection',
//                       className: 'btn btn-outline-secondary dropdown-toggle mr-2',
//                       text: feather.icons['share'].toSvg({ class: 'font-small-4 mr-50' }) + 'Exporter',

//                       buttons: [
//                           {
//                               extend: 'print',
//                               text: feather.icons['printer'].toSvg({ class: 'font-small-4 mr-50' }) + 'Imprimer',
//                               className: 'dropdown-item',
//                               exportOptions: { columns: export_column }
//                           },
//                           {
//                               extend: 'csv',
//                               text: feather.icons['file-text'].toSvg({ class: 'font-small-4 mr-50' }) + 'Csv',
//                               className: 'dropdown-item',
//                               exportOptions: { columns: export_column }
//                           },
//                           {
//                               extend: 'excel',
//                               text: feather.icons['file'].toSvg({ class: 'font-small-4 mr-50' }) + 'Excel',
//                               className: 'dropdown-item',
//                               exportOptions: { columns: export_column }
//                           },
//                           {
//                               extend: 'pdf',
//                               text: feather.icons['clipboard'].toSvg({ class: 'font-small-4 mr-50' }) + 'Pdf',
//                               className: 'dropdown-item',
//                               exportOptions: { columns: export_column }
//                           },
//                               {
//                               extend: 'copy',
//                               text: feather.icons['copy'].toSvg({ class: 'font-small-4 mr-50' }) + 'Copier',
//                               className: 'dropdown-item',
//                               exportOptions: { columns: export_column }
//                           }
//                       ],

//                   },
//                   {
//                       text: feather.icons['plus'].toSvg({ class: 'mr-50 font-small-4' }) + add_btn.label,
//                       className: add_btn.label !== null ? 'create-new btn btn-primary' : 'd-none',
//                       attr: {
//                           'data-toggle': 'modal',
//                           'data-target': add_btn.modal_id
//                       },
//                       init: function (api, node, config) {
//                           $(node).removeClass('btn-secondary');
//                       }
//                   }

//               ],

//               order: orderGroup.order,
//               rowGroup: {
//                   dataSrc: orderGroup.rowGroup
//               },
//               columnDefs: [ {
//                   targets: orderGroup.columnDefs,
//                   visible: false
//               } ]

//           });
//           }


//       $('div.head-label').html('<h4 class="mb-0">'+name+'</h4>');

//    }


  /*
  *---------------------------------------------------------------------------------------------------
  * Fonction pour afficher model d'alert
  * id = ID du modal
  * bg = Background du modal
  * color = Color des text
  * --------------------------------------------------------------------------------------------------
  *
  *
  */

  function modals_alert(id, type="default"){

      $('body').append(`
          <div class="modal fade modal-${type}" id="${id}" tabindex="-1" role="dialog" aria-labelledby="${id}Label" aria-hidden="true" data-backdrop="static" data-keyboard="false">
              <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title" id="${id}Label"> <i class="mdi mdi-alert-octagon"></i> <span class="title_elmt"> l'article</span> </h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  <div class="modal-body">
                      <p class="title_2">Message d'alerte !</p>
                      <p class="desc_elmt"> </p>
                  </div>
                  <div class="modal-footer">
                      <button type="button" id="btn-modal-continuous" onclick="action_modal()" class="btn btn-${type}">Continuer</button>
                  </div>
                  </div>
              </div>
          </div>
      `)

      }

  /*
  *-----------------------------------------------------------------------------------------
  * For repeat bloc
  * ----------------------------------------------------------------------------------------
  *
  *
  */
  function repeater_bloc(elements){
      elements.forEach(element => {
          $((function(){
              "use strict";
              $(element+", .repeater-default").repeater({
                  show:function(){
                      $(this).slideDown()
                    //   feather&&feather.replace({width:14,height:14})
                  },
                  hide:function(e){
                      if(confirm("Êtes-vous sûr de vouloir supprimer cet élément?")&&$(this).slideUp(e)){
                          if(typeof(validation_number_phone) == 'function' ){
                              validation_number_phone('#create-form #btn-submit')
                          }
                      }
                  }
              })
          }));
      });
  }

  /*
  *-----------------------------------------------------------------------------------------
  * For ajax request
  * ----------------------------------------------------------------------------------------
  *
  *
  */
  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });


   /*
  *-----------------------------------------------------------------------------------------
  * Theme script
  * ----------------------------------------------------------------------------------------
  *
  *
  */

//   $(window).on('load',  function(){
//       if (feather) {
//         feather.replace({ width: 14, height: 14 });
//       }
//   })

  /*
  *-----------------------------------------------------------------------------------------
  * For alert message
  * ----------------------------------------------------------------------------------------
  *
  *
  */


  @if($message = Session::get('success'))
      var message = <?php echo json_encode($message); ?>;
      message_alert('success',message);
  @endif

  @if($message = Session::get('error'))
      var message = <?php echo json_encode($message); ?>;
      message_alert('danger',message);
  @endif

  @if($message = Session::get('warning'))
      var message = <?php echo json_encode($message); ?>;
      message_alert('warning',message);
  @endif

  @if($message = Session::get('info'))
      var message = <?php echo json_encode($message); ?>;
      message_alert('info',message);
  @endif

</script>
