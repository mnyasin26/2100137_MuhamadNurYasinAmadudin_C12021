

/*

Mau coba pake localstorage buat nge test aja, tapi gabisa



const signUp = e => {
    let email = document.getElementById('email').value,
        username = document.getElementById('username').value,
        password = document.getElementById('password').value,
        code = document.getElementById('code').value;

    let formData = JSON.parse(localStorage.getItem('formData')) || [];

    let exist = formData.length && 
        JSON.parse(localStorage.getItem('formData')).some(data => 
            data.email.toLowerCase() == email.toLowerCase() &&
            data.code.toLowerCase() == code.toLowerCase()
        );

    if(!exist){
        formData.push({ email, username, password, code });
        localStorage.setItem('formData', JSON.stringify(formData));
        document.querySelector('form').reset();
        document.getElementById('username').focus();
        alert("Account Created.");
    }
    else{
        alert("Duplicate found!!!\nYou have already signed up");
    }
    e.preventDefault();
}

function signIn(e) {
    let username = document.getElementById('username').value, 
        password = document.getElementById('password').value;

    let formData = JSON.parse(localStorage.getItem('formData')) || [];

    let exist = formData.length && 
        JSON.parse(localStorage.getItem('formData')).some(data => data.username.toLowerCase() == username && data.password.toLowerCase() == password);

    if(!exist){
        alert("Incorrect login credentials");
    }
    else{
        location.href = "index.html";
    }
    e.preventDefault();
}

*/