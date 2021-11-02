/*global $, confirm*/
$(function() {

    "use strict";

    // Dashboard

    $('.toggle-info').click(function() {

        $(this).toggleClass('selected').parent().next('.panel-body').fadeToggle(100);

        if ($(this).hasClass('selected')) {

            $(this).html('<i class="fa fa-minus fa-lg"></i>')
        } else {
            $(this).html('<i class="fa fa-plus fa-lg"></i>')
        }

    });


    // Show & Hide button From dashboard page

    $('.comment-box .member-c').hover(function() {

        'use strict';

        $('.comment-box .js-hide').slideDown(500);

        $('.comment-box .member-c').click(function() {

            $('.comment-box .js-hide').slideUp(800);

        });
    });



    /* =========================================================================== */

    // Hide PlaceHolder on focus

    $('[placeholder]').focus(function() {

        $(this).attr('data-text', $(this).attr('placeholder'));
        $(this).attr('placeholder', ' ');
    }).blur(function() {

        $(this).attr('placeholder', $(this).attr('data-text'));
    });

    /* =========================================================================== */

    // Show Password When I Hover On Icon Eye

    var passField = $('.password');

    $('.show-pass, .show-pass-log').hover(function() {

        passField.attr('type', 'text');

    }, function() {

        passField.attr('type', 'password');
    });


    /* =========================================================================== */

    // Confirmation With Button special('Delet')

    $('.confirm').click(function() {

        return confirm('Are You Sure....??');

    });


    /* =========================================================================== */

    // Category View Option

    $('.cat h3').click(function() {

        $(this).next('.full-view').fadeToggle();
    });

    $('.option span').click(function() {

        $(this).addClass('active').siblings('span').removeClass('active');

        if ($(this).data('view') === 'full') {

            $('.cat .full-view').fadeIn(200);

        } else {

            $('.cat .full-view').fadeOut(200);
        }
    });


    // Show Delete Button On Child Cats

    $(".child-link").hover(function() {

        $(this).find('.show_remove').fadeIn(400);

    }, function() {

        $('.show_remove').find('.show_remove').fadeOut(400);
    });


});


// Function To Make Link Active

$(document).ready(function() {

    $("li a").addClass("active");
});

$(document).ready(function() {
    $("li a").click(function() {
        $("li a").removeClass('active');
        $(this).addClass('active');
    })
    var loc = window.location.href;
    $("li a").removeClass('active');
    $("li a").each(function() {
        if (loc.indexOf($(this).attr("href")) != -1) {
            $(this).closest('li a').addClass("active");

        }
    });
});