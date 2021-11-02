/* Start Rating System */
function showResultData(url) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("rating_product").innerHTML = this.responseText;
        }
    };
    xhttp.open("GET", url, true);
    xhttp.send();

}; //endFunction


function addRating(productId, ratingValue) {
    var xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {

            showResultData('includes/rating-system/get_rating.php');

            if (this.responseText != "success") {
                alert(this.responseText);
            }
        }
    };

    xhttp.open("POST", "includes/rating-system/insertRating.php", true);
    xhttp.setRequestHeader("Content-type",
        "application/x-www-form-urlencoded");
    var parameters = "index=" + ratingValue + "&productid=" +
        productId;
    xhttp.send(parameters);
}

/* End Rating System */