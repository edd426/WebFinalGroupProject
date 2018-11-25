$(document).ready(function() {
//input to ajax is size, features, search, and page number. If page is not defined default to 1.
$.ajax({
    url: "getFeatures.php",
    dataType: "html",
    success: function(response){
        $("#features").html(response);
    }
});

var url = window.location.href;
var formData = url.split("?")[1];
$.ajax({
    type: "GET",
    url: "home.php",
    data: formData,
    dataType: "html",
    success: function(response){
        $("#rooms").html(response);
    }
});

$("#filters").submit(function(){
    var formData = $("#filters").serialize();
    window.location.href = "home.html/"+formData+"&page=0";
    // $.ajax({
    //     type: "GET",
    //     url: "home.php",
    //     data: formData,
    //     dataType: "html",
    //     success: function(response){
    //         $("#rooms").html(response);
    //     }
    // });
    // e.preventDefault();
});


});