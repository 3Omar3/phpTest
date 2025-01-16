$('#loginForm').submit(function (e) {
    e.preventDefault();  // Prevent default form submission

    const email = $('#email').val();
    const password = $('#password').val();
    console.log(email)
    $.ajax({
        url: 'http://localhost/crud/apiTest/rest.php?endpoint=login',
        method: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({ email: email, password: password }),
        success: function (response) {
            const data = response;

            if (data.success) {
                window.location.href = 'views'; // Redirect on successful login
            } else {
                $('#error-message').removeClass('d-none').text(data.message);
            }
        },
        error: function () {
            $('#error-message').removeClass('d-none').text('An error occurred while logging in.');
        }
    });
});