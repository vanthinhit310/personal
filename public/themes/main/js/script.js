$(document).ready(function() {
    $().fancybox({
        selector: '[data-fancybox="google-photo-images"]',
        loop: true,
        buttons: ["slideShow", "fullScreen", "close", "download", "thumbs"],
        image: { preload: true },
        transitionEffect: "slide",
        transitionDuration: 1000,
        fullScreen: { autoStart: false },
        // Automatically advance after 3s to next photo.
        slideShow: { autoStart: true, speed: 3000 },
        // Display the contents figcaption element as the caption of an image
        caption: function(instance, item) {
            return $(this)
                .find("figcaption")
                .html();
        }
    });
});
