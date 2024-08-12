
@foreach($data as $gallery)
<div class="item category1 col-lg-4 col-md-4 col-12 col-sm">
    <a title="Image Title Goes Here" href="{{ env('IMAGE_SHOW_PATH').$gallery->image }}" class="fancylight popup-btn" data-fancybox-group="light">
        <img  class="img-fluid" src="{{ env('IMAGE_SHOW_PATH').$gallery->image }}">

    </a>
</div>
@endforeach


    <style>
    .mfp-content{margin-top: 130px !important}
    </style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.css" />
	<script src="http://localhost/NABIK-GRIHA/assets/templates/basic/assetss/js/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.isotope/3.0.6/isotope.pkgd.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.js"></script>

<script src="dist/simple-lightbox.js?v2.2.1"></script>
<script>
    (function() {
        var $gallery = new SimpleLightbox('.gallery a', '.gallery a p', {});
    })();
</script>
	<script src="js/script.js" defer></script>
	<script src="js/carousel.js"></script> 
<script src="owl-carousel/js/owl.carousel.js"></script>


<script>

         $('.portfolio-menu ul li').click(function(){
         	$('.portfolio-menu ul li').removeClass('active');
         	$(this).addClass('active');
         	
         	var selector = $(this).attr('data-filter');
         	$('.portfolio-item').isotope({
         		filter:selector
         	});
         	return  false;
         });
         $(document).ready(function() {
         var popup_btn = $('.popup-btn');
         popup_btn.magnificPopup({
         type : 'image',
         gallery : {
         	enabled : true
         }
         });
         });
</script>