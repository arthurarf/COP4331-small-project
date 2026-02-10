const urlBase = 'http://cop4331-huff.xyz';
const extension = 'php';

let userId = 0;
let firstName = "";
let lastName = "";

function doLogin()
{
	userId = 0;
	firstName = "";
	lastName = "";
	
	let login = document.getElementById("loginName").value;
	let password = document.getElementById("loginPassword").value;
	
    // Get the result element 
    let resultDiv = document.getElementById("loginResult");
    
    // Reset the banner: clear text, hide it, and remove the red style
	resultDiv.innerHTML = "";
    resultDiv.style.display = "none"; 
    resultDiv.className = ""; 

	let tmp = {login:login,password:password};
	let jsonPayload = JSON.stringify( tmp );
	
	let url = urlBase + '/Login.' + extension;

	let xhr = new XMLHttpRequest();
	xhr.open("POST", url, true);
	xhr.setRequestHeader("Content-type", "application/json; charset=UTF-8");
	try
	{
		// Fetch response
		xhr.onreadystatechange = function() 
		{
			if (this.readyState == 4 && this.status == 200) 
			{
				// Response found check response through parse
				let jsonObject = JSON.parse( xhr.responseText );
				userId = jsonObject.id;
		
				if( userId < 1 )
				{		
                    // Show Error Banner
					resultDiv.innerHTML = "User/Password combination incorrect";
                    resultDiv.className = "error-banner"; // Add the CSS class
                    resultDiv.style.display = "block";    // Make it visible
					return;
				}
		
				firstName = jsonObject.firstName;
				lastName = jsonObject.lastName;

				saveCookie();
	
				window.location.href = "contacts.html"; // This points to contacts page might have to change name
			}
		};
		xhr.send(jsonPayload);
	}
	catch(err)
	{
        // Show System Error Banner 
		resultDiv.innerHTML = err.message;
        resultDiv.className = "error-banner";
        resultDiv.style.display = "block";
	}
}

function doRegister()
{
	userId = 0;
	firstName = "";
	lastName = "";
	
	// 1. Get values from the HTML inputs
	let first = document.getElementById("firstName").value;
	let last = document.getElementById("lastName").value;
	let login = document.getElementById("loginName").value;
	let password = document.getElementById("loginPassword").value;
	
    // 2. Get the result/error div
    let resultDiv = document.getElementById("registerResult");
    
    // Reset the banner styling
	resultDiv.innerHTML = "";
    resultDiv.style.display = "none"; 
    resultDiv.className = ""; 

	if ( !isEmailValid(login) )
    {
        resultDiv.innerHTML = "Please enter a valid email address for your Username.";
        resultDiv.className = "error-banner";
        resultDiv.style.display = "block";
        return; // Stop the function here
    }

	// 3. Create the JSON payload matches Register.php expectations
	let tmp = {firstName:first, lastName:last, login:login, password:password};
	let jsonPayload = JSON.stringify( tmp );
	
	let url = urlBase + '/Register.' + extension;

	let xhr = new XMLHttpRequest();
	xhr.open("POST", url, true);
	xhr.setRequestHeader("Content-type", "application/json; charset=UTF-8");
	try
	{
		xhr.onreadystatechange = function() 
		{
			if (this.readyState == 4 && this.status == 200) 
			{
				let jsonObject = JSON.parse( xhr.responseText );
				
				// Register.php returns an error string if the insert fails (e.g., duplicate login)
				if( jsonObject.error && jsonObject.error.length > 0 )
				{		
					resultDiv.innerHTML = jsonObject.error;
                    resultDiv.className = "error-banner";
                    resultDiv.style.display = "block";
					return;
				}

				// Show green success message
				resultDiv.innerHTML = "Account created successfully!";
    			resultDiv.className = "success-banner"; // Turn it GREEN
    			resultDiv.style.display = "block";

				// Success: Save user data locally
				userId = jsonObject.id; // Register.php returns the new ID
				firstName = first;
				lastName = last;

				saveCookie();
	
				// Redirect to the main app page (same as login)
				window.location.href = "contacts.html"; // This points to contacts page might have to change name
			}
		};
		xhr.send(jsonPayload);
	}
	catch(err)
	{
		resultDiv.innerHTML = err.message;
        resultDiv.className = "error-banner";
        resultDiv.style.display = "block";
	}
}

function saveCookie()
{
	let minutes = 20;
	let date = new Date();
	date.setTime(date.getTime()+(minutes*60*1000));	
	document.cookie = "firstName=" + firstName + ",lastName=" + lastName + ",userId=" + userId + ";expires=" + date.toGMTString();
}

function readCookie()
{
	userId = -1;
	let data = document.cookie;
	let splits = data.split(",");
	for(var i = 0; i < splits.length; i++) 
	{
		let thisOne = splits[i].trim();
		let tokens = thisOne.split("=");
		if( tokens[0] == "firstName" )
		{
			firstName = tokens[1];
		}
		else if( tokens[0] == "lastName" )
		{
			lastName = tokens[1];
		}
		else if( tokens[0] == "userId" )
		{
			userId = parseInt( tokens[1].trim() );
		}
	}
	
	if( userId < 0 )
	{
		window.location.href = "contacts.html";
	}
	else
	{
	// document.getElementById("userName").innerHTML = "Logged in as " + firstName + " " + lastName;
	}
}

function doLogout()
{
	userId = 0;
	firstName = "";
	lastName = "";
	document.cookie = "firstName= ; expires = Thu, 01 Jan 1970 00:00:00 GMT";
	window.location.href = "contacts.html";
}

function isEmailValid(email) 
{
    // Regex for basic email validation
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}