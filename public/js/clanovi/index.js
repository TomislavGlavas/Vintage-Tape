
var sifraClan;

$(".slika").click(function(){
  sifraClan=$(this).attr("id").split("_")[1];
    $("#image").attr("src",$(this).attr("src"));
    $("#slikaModal").foundation("open");
    definirajCropper();
    return false;
});

$("#spremi").click(function(){
    var opcije = { "width": 100, "height": 150 };
    var result = $image.cropper("getCroppedCanvas", opcije, opcije);

    $.ajax({
        type: "POST",
        url: putanja + "clan/spremiSliku/"+sifraClan,
        data: "slika=" + result.toDataURL(),
        success: function(vratioServer){
          if(vratioServer==="OK"){
            $("#p_"+sifraClan).attr("src",result.toDataURL());
            $("#slikaModal").foundation("close");
          }else{
            alert(vratioServer);
          }
        }
      });


    return false;
  });

  var $image;

function definirajCropper(){


var URL = window.URL || window.webkitURL;
$image = $('#image');
var options = {aspectRatio: 2 / 3 };

// Cropper
$image.on({}).cropper(options);

var uploadedImageURL;


// Import image
var $inputImage = $('#inputImage');

if (URL) {
  $inputImage.change(function () {
    var files = this.files;
    var file;

    if (!$image.data('cropper')) {
      return;
    }

    if (files && files.length) {
      file = files[0];

      if (/^image\/\w+$/.test(file.type)) {
       

        if (uploadedImageURL) {
          URL.revokeObjectURL(uploadedImageURL);
        }

        uploadedImageURL = URL.createObjectURL(file);
        $image.cropper('destroy').attr('src', uploadedImageURL).cropper(options);
        $inputImage.val('');
      } else {
        window.alert('Please choose an image file.');
      }
    }
  });
} else {
  $inputImage.prop('disabled', true).parent().addClass('disabled');
}

}