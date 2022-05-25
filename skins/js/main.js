$(document).ready(function() {
  // Función a a ejecutar al presionar el botón
  $('#btnShowInfo').on('click', function(){
    
    // Se oculta el contenedor de información
    $('.info-container').hide(300);
    $('#infoContainer').html('');

    // Se ejecuta la funcion de Ajax
    $.ajax({
      url: '/datacrm/',
      type: 'GET',
      data:{
        action: 'showInfo'
      },
      success: function(data) {

        // Se muestra el contenedor de información y se agrega el contenido
        $('#infoContainer').html(data);
        $('.info-container').show(300);
      }
    })
  })
})