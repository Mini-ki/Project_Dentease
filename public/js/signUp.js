console.log("Cek")
document.getElementById('kolomSignUp').addEventListener('submit', function(submit) {
    const signUpStatus = document.getElementById('signUpStatus').getAttribute('data-status');
    document.querySelectorAll('.errorText').forEach(el => el.innerText = '');

    let username = document.getElementById('username').value.trim();
    let email = document.getElementById('email').value.trim();
    let password = document.getElementById('password').value.trim();
    let confirmPassword = document.getElementById('confirmPassword').value.trim();

    let isValid = true;

    if (username === '') {
        document.getElementById('errorUsername').innerText = 'Username is required!';
        isValid = false;
    }

    if (email === '' || !/^\S+@\S+\.\S+$/.test(email)) {
        document.getElementById('errorEmail').innerText = 'Please enter a valid email address!';
        isValid = false;
    }

    if (password === '') {
        document.getElementById('errorPassword').innerText = 'Password is required!';
        isValid = false;
    } else if (!/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/.test(password)) {
        document.getElementById('errorPassword').innerText = 'Password must be at least 8 characters and include a letter, number, and special character.';
        isValid = false;
    }

    if (confirmPassword === '' || confirmPassword !== password) {
        document.getElementById('errorConfirmPassword').innerText = 'Confirm password does not match!';
        isValid = false;
    }

    if (signUpStatus == "success" && isValid) {
        submit.preventDefault();                               
        document.getElementById('iconSignUpSukses').classList.add('show');
        setTimeout(() => {
            window.location.href = 'signUp.php';                           
        }, 2000);
    }
    else if(signUpStatus == "failed" && !isValid){
        submit.preventDefault();
    }
});