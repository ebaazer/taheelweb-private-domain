// gallery zoom
jQuery("#gallery-zoom").gallaryZoom({
    gallery:'product-gallary', 
    cursor: 'pointer', 
    galleryActiveClass: 'active', 
    imageCrossfade: true, 
    loadingIcon: '#',
});
// images to Fancybox
jQuery("#gallery-zoom").bind("click", function(e) {  
    var gz = jQuery('#gallery-zoom').data('gallaryZoom');	
    jQuery.fancybox(gz.getGalleryList());
    return false;
});
