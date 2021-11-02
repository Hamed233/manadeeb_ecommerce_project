/* For Edit image */
$(document).ready(function() {
    fetch_data();

    function fetch_data() {
        var action = "fetch";
        $.ajax({
            url: "includes/actions/update_image.php",
            method: "POST",
            data: {
                action: action
            },
            success: function(data) {
                $('#image_data').html(data);
            }
        });
    }

    $('#image_form').submit(function(event) {
        event.preventDefault();
        var image_name = $('#image').val();
        if (image_name == '') {
            alert("Please Select Image");
            return false;
        } else {
            var extension = $('#image').val().split('.').pop().toLowerCase();
            if (jQuery.inArray(extension, ['gif', 'png', 'jpg', 'jpeg']) == -1) {
                alert("Invalid Image File");
                $('#image').val('');
                return false;
            } else {
                $.ajax({
                    url: "includes/actions/update_image.php",
                    method: "POST",
                    data: new FormData(this),
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        alert(data);
                        fetch_data();
                        $('#image_form')[0].reset();
                        $('#imageModal').modal('hide');
                    }
                });
            }
        }
    });

    $(document).on('click', '.update_img', function() {
        $('#image_id').val($(this).attr("id"));
        $('#action').val("update_img");
        $('.modal-title').text("Update Image");
        $('#insert_img').val("Update");
        $('#imageModal').modal("show");
    });
});



/* Rating System */
function showResultData(url) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("rating").innerHTML = this.responseText;
        }
    };
    xhttp.open("GET", url, true);
    xhttp.send();

} //endFunction


function addRating(productId, ratingValue) {
    var xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {

            showResultData('includes/actions/getRating.php');

            if (this.responseText != "success") {
                alert(this.responseText);
            }
        }
    };

    xhttp.open("POST", "includes/actions/insertRating.php", true);
    xhttp.setRequestHeader("Content-type",
        "application/x-www-form-urlencoded");
    var parameters = "index=" + ratingValue + "&productid=" +
        productId;
    xhttp.send(parameters);
}

$("body").ready(function() {
    showResultData('includes/actions/getRating.php');
});
/* End Rating System */

/* Start Add To Cart */

$(document).ready(function() {
    $.ajax({
        type: 'post',
        url: 'includes/actions/store_items.php',
        data: {
            total_cart_items: "totalitems"
        },
        success: function(response) {
            document.getElementById("cart-quantity").innerHTML = response;
        },
        error: function() {
            document.getElementById("cart-quantity").innerHTML = 0;
        }
    });
});

function cart(id) {
    var ele = document.getElementById(id);
    var img_src = ele.getElementsByTagName("img")[0].src;
    var name = document.getElementById(id + "_name").value;
    var sellar = document.getElementById(id + "_sellar").value;
    var quantity = document.getElementById(id + "_quantity").value;
    var price = document.getElementById(id + "_price").value;
    var discount = document.getElementById(id + "_discount").value;
    var pro_id = document.getElementById(id + "_product").value;

    $.ajax({
        type: 'post',
        url: 'includes/actions/store_items.php',
        data: {
            item_img: img_src,
            item_quantity: quantity,
            item_name: name,
            product_id: pro_id,
            item_sellar: sellar,
            item_price: price,
            price_discount: discount,
            cart: "cart"
        },
        success: function(response) {
            document.getElementById("cart-quantity").innerHTML = response;
            $('.cap_status').addClass('alert alert-primary').html("Added to Cart <i class=\"fa fa-check-circle\"></i>").fadeIn('slow').delay(2000).fadeOut('slow');
        }
    });

}

$(document).ready(function() {
    $.ajax({
        type: 'post',
        url: 'includes/actions/store_items.php',
        data: {
            mycart: "cart"
        },
        success: function(response) {
            document.getElementById("mecart").innerHTML = response;
        }
    });
});

/* End Add To Cart */