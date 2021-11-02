// image hover
$(document).ready(function() {
    $('#ex1').zoom();
});

// ------------------ Tabs ----------------------
function openCity(evt, actionName) {
    // Declare all variables
    var i, tabcontent, tablinks;

    // Get all elements with class="tabcontent" and hide them
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }

    // Get all elements with class="tablinks" and remove the class "active"
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }

    // Show the current tab, and add an "active" class to the button that opened the tab
    document.getElementById(actionName).style.display = "block";
    evt.currentTarget.className += " active";
}

/* Rating Product */
function mouseOverRating(productId, rating) {

    resetRatingStars(productId)

    for (var i = 1; i <= rating; i++) {
        var ratingId = productId + "_" + i;
        document.getElementById(ratingId).style.color = "#f00";

    }
}

function resetRatingStars(productId) {
    for (var i = 1; i <= 5; i++) {
        var ratingId = productId + "_" + i;
        document.getElementById(ratingId).style.color = "#9E9E9E";
    }
}

function mouseOutRating(productId, userRating) {
    var ratingId;

    if (userRating != 0) {
        for (var i = 1; i <= userRating; i++) {
            ratingId = productId + "_" + i;
            document.getElementById(ratingId).style.color = "#f00";
        }
    }
    if (userRating <= 5) {
        for (var i = (userRating + 1); i <= 5; i++) {
            ratingId = productId + "_" + i;
            document.getElementById(ratingId).style.color = "#9E9E9E";
        }
    }
}

// Help Accordion

var acc = document.getElementsByClassName("accordion");
var i;

for (i = 0; i < acc.length; i++) {
    acc[i].addEventListener("click", function() {
        /* Toggle between adding and removing the "active" class,
        to highlight the button that controls the panel */
        this.classList.toggle("active");

        /* Toggle between hiding and showing the active panel */
        var panel = this.nextElementSibling;
        if (panel.style.display === "block") {
            panel.style.display = "none";
        } else {
            panel.style.display = "block";
        }
    });
}

var browserWindow = $(window);

// :: 1.0 Preloader Active Code
browserWindow.on('load', function() {
    // $('.preloader').fadeOut('slow', function() {
    //     $(this).remove();
    // });
});

// --- home slider ---

var slideIndex = 1;
showSlides(slideIndex);

// Next/previous controls
function plusSlides(n) {
    showSlides(slideIndex += n);
}

var slideIndex = 0;
showSlides();

function showSlides() {
    var i;
    var slides = document.getElementsByClassName("mySlides");
    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }
    slideIndex++;
    if (slideIndex > slides.length) { slideIndex = 1 }
    slides[slideIndex - 1].style.display = "block";
    setTimeout(showSlides, 10000); // Change image every 10 seconds
}

/* Rating Product */

function mouseOverRating(productId, rating) {

    resetRatingStars(productId)

    for (var i = 1; i <= rating; i++) {
        var ratingId = productId + "_" + i;
        document.getElementById(ratingId).style.color = "#ff6e00";

    }
}

function resetRatingStars(productId) {
    for (var i = 1; i <= 5; i++) {
        var ratingId = productId + "_" + i;
        document.getElementById(ratingId).style.color = "#9E9E9E";
    }
}

function mouseOutRating(productId, userRating) {
    var ratingId;

    if (userRating != 0) {
        for (var i = 1; i <= userRating; i++) {
            ratingId = productId + "_" + i;
            document.getElementById(ratingId).style.color = "#ff6e00";
        }
    }
    if (userRating <= 5) {
        for (var i = (userRating + 1); i <= 5; i++) {
            ratingId = productId + "_" + i;
            document.getElementById(ratingId).style.color = "#9E9E9E";
        }
    }
}