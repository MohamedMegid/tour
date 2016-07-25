<script src="{{ asset('assets/backend/vendors/modal/js/classie.js') }}"></script>
<script src="{{ asset('assets/backend/vendors/modal/js/modalEffects.js') }}"></script>
<script type="text/javascript">
  $(document).on('click', '#set-image', function () {
        // get id and set it to hidden value
        var returned_id = $("#iframe").contents().find("#return-id").val(); 
        $("#main-image").val(returned_id);

        // change main image thumbnail after select image
        var returned_url = $("#iframe").contents().find("#return-url").val(); 
        $("#main-image-thumbnail").attr("src", returned_url);
    });
</script>
<script type="text/javascript">
  $(document).on('click', '#set-gallery-images', function () {
        // get id and set it to hidden value
        var returned_json = $("#iframe-gallery").contents().find("#json-data").val(); 
        var gallery = document.getElementById("gallery");
        var gallery_data = JSON.parse(returned_json);
	        for (var i=0; i < gallery_data.length; i++){
	            var id = gallery_data[i].id;
	            var url = gallery_data[i].url;
	            
	            gallery.innerHTML += "<div class='gallery-img'><img src='"+url+"' /><a href='#gallery' class='img-delete'>x</a><input type='hidden' name='gallery_images[]' value='"+id+"'></div>";
	            // remove selected images from iframe
	            $("#iframe-gallery").contents().find(".selected").removeClass("selected");
	            $("#iframe-gallery").contents().find("#json-data").val('');
	            $("#iframe-gallery").contents().find("#ids").empty();
	        }
    });

 $(function() {
    $('#gallery').on('click', '.img-delete', function (event) {
    	var commentContainer = $(this).parent();
           commentContainer.remove();
     });
    return false;
  });
</script>