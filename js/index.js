// If already logged in .. it redirects to the profile page 
if(localStorage.getItem("userid") !== null) { 
    window.location.href = 'profile.html' 
}