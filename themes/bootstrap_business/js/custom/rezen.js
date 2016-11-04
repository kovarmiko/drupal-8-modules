jQuery(document).ready(function($) { 
    var imagesSrc = ['slide1', 'slide2', 'slide3', 'slide4'];
    rewriteSlideShowImageSrc($,imagesSrc);
});

function rewriteSlideShowImageSrc($,imagesArray){
    $.each(imagesArray, function(key, value){
        $('#' + value).attr('src', Drupal.url('sites/default/files/') + value + '.jpg');
        
    });
}
