$( "#uvjet" ).autocomplete({
    source: function( request, response ) {
      $.ajax( {
        url: "/clan/traziclan",
        data: {
          uvjet: request.term
        },
        success: function( data ) {
          response( data );
        }
      } );
    },
    minLength: 1,
    select: function( event, ui ) {
    //  console.log(event);
    spremi(ui.item);
        console.log( "Idem na server s: " + ui.item.sifra );
    }
  } ).autocomplete( "instance" )._renderItem = function( ul, item ) {
    return $( "<li>" )
      .append( "<div>" + item.ime + " " + item.prezime + "</div>" )
      .appendTo( ul );
  };




function spremi(grupa,polaznik){
  $.ajax( {
    url: "/grupa/dodajpolaznik",
    data: {
      grupa: grupa,
      polaznik: polaznik.sifra
    },
    success: function( data ) {

      if(data=="OK"){
          $("#tijelo").append('<tr> ' +
          '<td> ' + polaznik.ime + ' ' + polaznik.prezime +
          '' +
          (polaznik.oib==null ? '' : polaznik.oib)  +
          '' +
          '<span style="font-size: 0.7em;"> ' +
          polaznik.email +
          '</span> ' +
          '</td> ' +
          '' +
          '<td><a href="#" class="polaznik"  ' +
          'id="p_'+ polaznik.sifra  +'"> ' +
              '<i class="fas fa-trash fa-2x" style="color: red"></i> ' +
              '</a></td> ' +
          '</tr>');
      }

      
      definirajBrisanje();

    }
  });
}


function definirajBrisanje(){


$(".polaznik").click(function(){
  var element = $(this);
  var polaznik = element.attr("id").split("_")[1];


  $.ajax( {
    url: "/grupa/obrisipolaznik",
    data: {
      grupa: grupa,
      polaznik: polaznik
    },
    success: function( data ) {
      if(data=="OK"){
        element.parent().parent().remove();
      }
    }
  });

  return false;
});

}


definirajBrisanje();