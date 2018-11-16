$(document).ready(function() {

    var emailError = document.createElement("span");
	emailError.id = "emailError";
    $(emailError).insertAfter("#Email");
    var error = 0;
    
    $( "form" ).submit(function( event ) {
		var email = $("#Email").val();
		var password = $("#Password").val();
		var confirmPassword = $("#ConfirmPassword").val();
        
        //Check if all fields are filled
		if(email.length === 0 || password.length === 0 || confirmPassword.length === 0 )
		{
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
            $("#errormessage").text("Please input the same password twice");
			$("#Password").addClass("error");
			$("#ConfirmPassword").addClass("error");
			
        }
        
        else if(!emailCheck(email))
        {
            $("#errormessage").text("Please input a valid email");
            $("#Email").addClass("error");
        }
        else if(!checkPassword(password))
        {
            $("#errormessage").text("Your password must contain at least one letter and number");
            $("#Password").addClass("error");
			$("#ConfirmPassword").addClass("error");
        }
		else
		{
            //Check if email exists in database
            $.ajax
            ({
                type: "GET",
                url: "emailCheck.php",
                data: { Email: email},
                async: false,
                success: function(response)
                {
                    error = response;
                },
                error: function (request, status, error) {
                    alert(request.responseText);
                }
            });
            if(error == "1")
            {
                $.ajax
                ({
                    type: "POST",
                    url: "signup.php",
                    data: { Email: email, Password: password},
                    async: false,
                    success: function(response)
                    {
                        error = response;
                    },
                    error: function (request, status, error) {
                        alert(request.responseText);
                    }
                });

                //Redirect to home page
                window.location.href = "home.php";


            }
            else
            {
                $("#errormessage").text("This email is already associated with an account");
                $("#Email").addClass("error");
            }
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

//Check if password contains a letter and number
function checkPassword(inputText)
{
    var regex = /[A-Z]/i;
    if(inputText.match(regex))
    {
        regex = /[0-9/]/i;
        if(inputText.match(regex))
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

