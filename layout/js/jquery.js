  // Hide message after timeOut
  $(".dont_login").show();
  setTimeout(function() {
      $(".dont_login").hide();
  }, 50000);

  $(".get").click(function() {
      $("#place").toggleClass("d-none", 1000);
  });

  // Show Password When I Hover On Icon Eye

  var passField = $('.password');

  $('.show-pass, .show-pass-log').hover(function() {

      passField.attr('type', 'text');

  }, function() {

      passField.attr('type', 'password');
  });

  // ================ check if user login or not ================= //
  if ($('.buy_btn, .cart_btn').attr('disabled')) {
      $('.alert_for_disabled').html('<p>Login First</p>');
  }

  $('.cart_btn, .buy_btn').hover(function() {
      $('.alert_for_disabled').fadeToggle();
  });

  // For Toggle sidebar
  $("#close-sidebar").click(function() {
      $(".page-wrapper").removeClass("toggled");
  });

  $("#show-sidebar").click(function() {
      $(".page-wrapper").addClass("toggled");
  });


  var ms = window.matchMedia("(max-width: 900px)");

  if (ms.matches) {
      $(".page-wrapper").removeClass("toggled");
  } else {
      $(".page-wrapper").addClass("toggled");
  }

  // for method recieve
  $('#way-send-s').click(function() {
      if ($(this).attr("checked", "ckecked")) {
          $('.center-inp').removeClass('d-block').addClass('d-none').slideUp(1000);
      }
  });

  $('#way-send').click(function() {
      if ($(this).attr("checked", "ckecked")) {
          $('.center-inp').removeClass('d-none').addClass('d-block').slideDown(1000);
      }
  });


  // for payment order
  $('#card_pay').click(function() {

      if ($(this).attr("checked", "ckecked")) {
          $('.form-payment').removeClass("d-none").addClass('d-block').slideDown(1000);
      }
  });

  $('#by_hand').click(function() {
      if ($(this).attr("checked", "ckecked")) {
          $('.form-payment').removeClass("d-block").addClass('d-none').slideUp(1000);
      }
  });

  // ------------- quantity input ------------
  $(document).ready(function() {

      var quantitiy = 0;
      $('.quantity-right-plus').click(function(e) {
          // Stop acting like a button
          e.preventDefault();
          // Get the field name
          var quantity = parseInt($('.quantity_js').val());
          // If is not undefined
          $('.quantity_js').val(quantity + 1);
      });

      $('.quantity-left-minus').click(function(e) {
          // Stop acting like a button
          e.preventDefault();
          // Get the field name
          var quantity = parseInt($('.quantity_js').val());
          // If is not undefined
          // Increment
          if (quantity > 0) {
              $('.quantity_js').val(quantity - 1);
          }
      });
  });

  /* validate password */

  var myInput = document.getElementById("pass");
  var letter = document.getElementById("letter");
  var capital = document.getElementById("capital");
  var number = document.getElementById("number");
  var length = document.getElementById("length");

  // When the user clicks on the password field, show the message box
  myInput.onfocus = function() {
      document.getElementById("message").style.display = "block";
  }

  // When the user clicks outside of the password field, hide the message box
  myInput.onblur = function() {
      document.getElementById("message").style.display = "none";
  }

  // When the user starts to type something inside the password field
  myInput.onkeyup = function() {
      // Validate lowercase letters
      var lowerCaseLetters = /[a-z]/g;
      if (myInput.value.match(lowerCaseLetters)) {
          letter.classList.remove("invalid");
          letter.classList.add("valid");
      } else {
          letter.classList.remove("valid");
          letter.classList.add("invalid");
      }

      // Validate capital letters
      var upperCaseLetters = /[A-Z]/g;
      if (myInput.value.match(upperCaseLetters)) {
          capital.classList.remove("invalid");
          capital.classList.add("valid");
      } else {
          capital.classList.remove("valid");
          capital.classList.add("invalid");
      }

      // Validate numbers
      var numbers = /[0-9]/g;
      if (myInput.value.match(numbers)) {
          number.classList.remove("invalid");
          number.classList.add("valid");
      } else {
          number.classList.remove("valid");
          number.classList.add("invalid");
      }

      // Validate length
      if (myInput.value.length >= 8) {
          length.classList.remove("invalid");
          length.classList.add("valid");
      } else {
          length.classList.remove("valid");
          length.classList.add("invalid");
      }
  }