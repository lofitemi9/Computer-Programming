$(document).ready(function(){
    $(function(){
        $("#head").load("./includes/meta.html");
        $("#header").load("./includes/header.html");
        $("#footer").load("./includes/footer.html");
    })

    $("#myInput").on("keyup", function(){
        var value = $(this).val().toLowerCase();
        $("#myTable tr").filter(function(){
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });
    $("#accordian li h3").click(function(){
        var $parent = $(this).parent();
        if($parent.hasClass("active")) return;
        $("#accordian ul .row").not().slideUp();
        $(this).next().slideDown(function(){
            $parent.addClass("active").siblings().removeClass("active");
        });
    });
    var $carouselSlides = $('.carousel-slides');

    var $carouselSlide = $('.carousel-slide');

    var $carouselDots = $('.carousel-dots');

    var slideCount = $carouselSlide.length;

    var currentSlide = 0;

    var slideWidth = $carouselSlide.width(); // Get initial slide width

    var autoPlayInterval; // Variable to hold the auto-play interval

    // --- Carousel Initialization ---

    // Create pagination dots dynamically

    for (var i = 0; i < slideCount; i++) {

        $carouselDots.append('<span class="carousel-dot" data-slide-index="' + i + '"></span>');

    }

    // Set the first dot as active

    $carouselDots.find('.carousel-dot').eq(0).addClass('active');

    // --- Core Carousel Functionality ---

    // Function to move to a specific slide

    function goToSlide(index) {

        // Ensure index wraps around for continuous loop

        if (index >= slideCount) {

        index = 0;

        } else if (index < 0) {

        index = slideCount - 1;

        }

        currentSlide = index;

        // Calculate the new transform value to show the correct slide

        $carouselSlides.css('transform', 'translateX(' + (-currentSlide * slideWidth) + 'px)');

        // Update active dot

        $carouselDots.find('.carousel-dot').removeClass('active');

        $carouselDots.find('.carousel-dot').eq(currentSlide).addClass('active');

    }

    // Function to go to the next slide

    // This function is still needed for auto-play, even without navigation buttons

    function nextSlide() {

        goToSlide(currentSlide + 1);

    }

    // Pagination dot click

    $carouselDots.on('click', '.carousel-dot', function() {

        var index = $(this).data('slide-index');

        goToSlide(index);

        resetAutoPlay(); // Reset auto-play on manual interaction

    });

    // --- Auto-Play Functionality ---

    // Start auto-play

    function startAutoPlay() {

        autoPlayInterval = setInterval(nextSlide, 5000); // Change slide every 5 seconds

    }

    // Stop auto-play

    function stopAutoPlay() {

        clearInterval(autoPlayInterval);

    }

    // Reset auto-play (stop and then start again)

    function resetAutoPlay() {

        stopAutoPlay();

        startAutoPlay();

    }

    // --- Responsive Adjustments ---

    // Update slideWidth on window resize

    $(window).on('resize', function() {

        slideWidth = $carouselSlide.width();

        // Re-position the carousel to the current slide based on new width

        $carouselSlides.css('transform', 'translateX(' + (-currentSlide * slideWidth) + 'px)');

    });

    // Initial call to set up carousel and start auto-play

    startAutoPlay();

    // Ensure correct initial position in case of pre-loaded scroll

    goToSlide(0);

    
});

