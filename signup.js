$(document).ready(function() {

    var emailError = document.createElement("span");
	emailError.id = "emailError";
    $(emailError).insertAfter("#Email");
    
    $( "form" ).submit(function( event ) {
		var email = $("#Email").val();
		var password = $("#Password").val();
		var confirmPassword = $("#ConfirmPassword").val();
        var error = 0;
        //Check if all fields are filled
		if(email.length === 0 || password.length === 0 || confirmPassword.length === 0 )
		{
			error = 1;
			if(email.length === 0 )
			{
				$("#Email").addClass("error");
			}
			if(password.length === 0 )
			{
				$("#Password").addClass("error");
			}
			if(confirmPassword.length === 0 )
			{
				$("#ConfirmPassword").addClass("error");
            }
            $("#errormessage").text("Please fill in all fields");
        }
        //Check if password is the same as confirm password
		else if(password != confirmPassword)
		{
            error = 1;
            $("#errormessage").text("Please input the same password twice");
			$("#Password").addClass("error");
			$("#ConfirmPassword").addClass("error");
			
        }
        
        else if(!emailCheck(email))
        {
            $("#errormessage").text("Please input a valid email");
            $("#Email").addClass("error");
            error = 1;
        }
		else
		{

			$("#errormessage").css("color", "white");
			$("#Email").val("");
			$("#Password").val("");
            $("#ConfirmPassword").val("");
            $("#Email").css("background-color", "white");
			$("#Password").css("background-color", "white");
			$("#ConfirmPassword").css("background-color", "white");
			alert("Your form has been submitted");

		}
		event.preventDefault();

	})

});

//Check if email is in a valid format
function emailCheck(inputText)
{
	if(inputText.includes("@"))
	{
		if(inputText.includes("."))
		{
			var checkText = inputText.replace("@", "");
			checkText = checkText.replace(".", "");
			if(textCheck(checkText))
			{
				var checkArray = inputText.split(".");
				if(checkArray[1].length === 3)
				{
					return true;
				}
				else
				{
					return false;
				}
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}
	else
	{
		return false;
	}
}

//Check if text is only alphanumeric
function textCheck(inputText)
{
	var letters = /^[A-Za-z0-9]+$/;
	if(inputText.match(letters))
	{
		return true;
	}
	else
	{
		return false;
	}
}