$(document).ready(function() {
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth()+1;
    var yyyy = today.getFullYear();
    var date;
    var roomID = window.location.href.split("=")[1];
     if(dd<10){
            dd='0'+dd
        } 
        if(mm<10){
            mm='0'+mm
        } 
    
    today = yyyy+'-'+mm+'-'+dd;

    $("#MeetingDate").attr("min", today);

    $( "#MeetingDate" ).change(function() {
        date = $("#MeetingDate").val();
        $.ajax
            ({
                type: "GET",
                url: '../reservationTime.php',
                data: { Date: date, RoomID: roomID},
                success: function(response)
                {
                    $("#schedule").html(response);
                },
                error: function (request, status, error) {
                    alert(request.responseText);
                }
            });
            $('#submit').prop('disabled', false);
    });

    $('body').on('click','td.available', function() {
        $(this).toggleClass("selected");
    });

    $('#reservationForm').submit(function(e){
        var timeBlocks = $(".selected");
        var prev = timeBlocks[0].id;
        var error = false;
        var i;
        for(i = 0; i<timeBlocks.length; i++)
        {
            if(timeBlocks[i].id - prev > 1)
            {
                error = true;
            }
            prev = timeBlocks[i].id;
        }

        if(!error)
        {
            var startTime = timeBlocks[0].id;
            var endTime = timeBlocks[timeBlocks.length-1].id;
            var userID = $("#userid").text();
            window.location.href = '../saveReservation.php/?roomID='+roomID+'&userID='+userID+'&startTime='+startTime+'&endTime='+endTime+'&resDate='+date;
            
            
        }
        else
        {
            $("#errorMessage").text("You can only schedule one meeting at a time");
        }
        e.preventDefault();
    });

});