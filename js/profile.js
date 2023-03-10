
// Accessing access to profile page if logged in localstorage and redis
// else redirecting to hte login page
if(localStorage.getItem("userid") === null) { 
    document.querySelector('body').innerHTML = 'You are not logged in'
    window.location.href = 'login.html'
}

// Assining task for the backend
let taskDetails = {
    "username" : localStorage.getItem("userid") ,
    "task" : "login"
}

// Asking profile details to the Backend redis
$.get("php/profile.php", {'data' : JSON.stringify(taskDetails)},
    function (data, textStatus, jqXHR) {
        console.log(data , textStatus) 
        data = JSON.parse(data) 
        const username = data.username ;
        document.querySelector('.section-name').textContent = data.name 
    }
);
// initially profile details are hidden 
$('.mongo-form').hide();
//EVENT LISTENERS 
// edit profile click event
$('.edit-profile').click(function (e) {  
console.log("clicked")
    taskDetails.task = "getdetails"
    taskDetails.username = localStorage.getItem('userid');
    // making a get request for the profile details from MONGODB
    $.get("php/profile.php", {'data' : JSON.stringify(taskDetails)},
    function (data, textStatus, jqXHR) {
        console.log(data)
        data = JSON.parse(data)
        console.log(data)
        // making the profile details visible and filling the datas 
        $('.mongo-form').show() ;
        $('#age').val(data.age);
        $('#phone').val(data.phonenumber);
        $('#address').val(data.address);
        $('#qualification').val(data.qualifications);
        $('#school').val(data.schoolstudied);

        // adding event listner for submitting
        $('.mongo-form').submit(function (e) { 
            e.preventDefault();
            const formDetails = {
                "age" : $('#age').val() , 
                "phonenumber" :$('#phone').val() , 
                "address" : $('#address').val(), 
                "qualifications" : $('#qualification').val(), 
                "schoolstudied" :$('#school').val()  ,
                "username" : localStorage.getItem('userid') , 
                "task" : "updateform"
            }
            $.post("php/profile.php", {'data' : JSON.stringify(formDetails)},
            function (data, textStatus, jqXHR) {
                console.log(data, textStatus)
                //after updating hiding the profile details 
                $('.mongo-form').hide();

    }
);
        });
    }
    );
})
// Logout Click listeners
$('.logout').click(function (e) { 
    localStorage.removeItem('userid') 
    taskDetails.task = "logout" 
    
    $.get("php/profile.php", {'data' : JSON.stringify(taskDetails)},
    function (data, textStatus, jqXHR) {
        console.log(data , textStatus) 
        data = JSON.parse(data) 
        window.location.href = "login.html"
    }
);
});