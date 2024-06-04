document.getElementById("loginForm").addEventListener("submit", function(event) {
    event.preventDefault(); // Prevent default form submission
    
    // Get the values of username and password inputs
    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;

    // Check if the username and password are correct (for demonstration purposes)
    if (username === "example" && password === "password") {
        // If correct, you can redirect to another page or perform any other action
        window.location.href="HomePage.php";
    } else {
        // If incorrect, display an error message
        document.getElementById("error").innerText = "Invalid username or password";
    }
});
