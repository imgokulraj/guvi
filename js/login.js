// Redirecting to profile page if already logged in
if(localStorage.getItem("userid") !== null) { 
    window.location.href = 'profile.html' 
}

// On submitting login form 
$('.form-login').submit(function (e) { 
    e.preventDefault();
    
    // Getting Username and Password
    const registerDetails = {
        username : $('#username').val() ,  
        password : $('#password').val()  
    }
    // converting the data to json format to send to the backend
    const data = JSON.stringify(registerDetails) 

    // Using jquery ajax to send the data to the backend
    $.post("php/login.php", {'data' : data},
        function (data, textStatus, jqXHR) {
            console.log(data , textStatus) 
            data = JSON.parse(data)
            // if password matches the data['canlogin'] will be true 
            if(data['canlogin'] === true) {
                localStorage.setItem("userid" , data['username'])
                window.location.href = "./profile.html";
            // Password or Username invalid 
            }else{
                const error = document.querySelector('.msg')
                error.textContent = data['msg'] 
                error.style.color = 'red'
            }
        }
    );
});

// for redirecting to register page
$('.register').click(function (e) { 
    window.location.href = 'register.html'
});