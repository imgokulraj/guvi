
// redirecting to profile page if already logged in
if(localStorage.getItem("userid") !== null) { 
    window.location.href = 'profile.html' 
}

// When Register form is submitted
$('.formregister').submit(function (e) { 
    e.preventDefault();

    // getting form details 
    const registerDetails = {
        name : $('#name').val()  ,
        username : $('#username').val() , 
        email : $('#email').val() , 
        password : $('#password').val()  
    }

    
    const data = JSON.stringify(registerDetails)
    // sending the form details to the backend 
    $.post("php/register.php", {'data' : data},
        function (data, textStatus, jqXHR) {
            console.log(data , textStatus) 
            data = JSON.parse(data)
            // if username already exits then it returns failed and notified to the user
            if(data['status'] === 'failed'){
                const error = document.querySelector('.msg') 
                error.textContent = data['msg'] 
                error.style.color = 'red'
            }else{
                // A Success message is shown the user 
                const msg = document.querySelector('.msg') 
                msg.textContent = data['msg'] 
                msg.style.color = 'green'
            }
        }
    );
    
});

// To redirect to login page

$('.login').click(function (e) { 
    e.preventDefault();
    window.location.href = 'login.html' 
});