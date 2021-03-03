const ua = new Map([
    //general informations
    ["mainHeading", "Тестова аутентифікація"],
    ["formSign", "Зареєструватись"],
    ["formLogin", "Увійти"],
    ["contactUs", "Зв'яжіться з нами"],
    //LoginForm
    ["labelEmailIn", "Електронна пошта"],
    ["labelPasswordIn", "Пароль"],
    ["forgotPassword", "Забули пароль?"],
    ["loginSubmit", "Увійти"],
    ["delimiter", "-АБО-"],
    ["signDescription", "Увійдіть за допомогою номера телефону. Ми надішлемо вам 6-значний код, щоб гарантувати, що лише ви маєте доступ до своєї медичної команди"],
    ["phoneIn", "ваш номер телефону"],
    ["phoneSubmit", "Надіслати код підтвердження"],
    //SignInForm
    ["firstNameSIn", "Ім'я"],
    ["lastNameSIn", "Прізвище"],
    ["emailSIn", "Електронна пошта"],
    ["passSIn", "Пароль (мінімум 6 символів)"],
    ["checkboxDesc", "<span class = 'custom-label'> Я погоджуюсь з <a class='custom-link'> Політикою конфіденційності </a> & <a class='custom-link'> Умовами використання </a> </span >"],
    ["signInSubmit", "Розпочати!"],
    //Errors, PopUp
    ["signFirstNameValidation", "Введіть ім’я"],
    ["signLastNameValidation", "Введіть прізвище"],
    ["signEmailValidation", "Некоректна електронна адреса"],
    ["signPassValidation", "Пароль має бути > 6 символів"],
    ["signEmailAlreadyOccupied", "Ця електронна адресса вже зайнята"],
    ["loginSubmitError", "Недійсний логін / пароль"],
    ["phonePasswordError", "Недійсний номер телефону"],
    ["phonePasswordHeader", "Вхід за допомогою телефону"],
    ["phonePasswordBody", "Код підтвердження надіслано"],
    ["phonePasswordHolder", "Код"],
    ["phonePasswordButton", "Підтвердити"],
    ["phonePasswordPopError", "Неправильний код"],
    ["forgotPasswordHeader", "Відновлення паролю"],
    ["forgotPasswordBody", "Введіть адресу електронної пошти і ми надішлемо вам посилання для зміни паролю"],
    ["forgotPasswordButton", "Надіслати"],
    ["forgotPasswordButtonHolder", "Електронна пошта"],
    ["forgotPasswordEmail", "Недійсна пошта"],
    ["forgotPasswordSend", "Електронний лист надіслано"]
]);
const eng = new Map([
    //general informations
    ["mainHeading", "Test auth page"],
    ["formSign", "Sign Up"],
    ["formLogin", "Log In"],
    ["contactUs", "Contact Us"],
    //LoginForm
    ["labelEmailIn", "Email"],
    ["labelPasswordIn", "Password"],
    ["forgotPassword", "Forgot password?"],
    ["loginSubmit", "Log In"],
    ["delimiter", "-OR-"],
    ["signDescription", "Sign in with your phone number. We will send you a 6-digit code to ensure that only you have access to your care team"],
    ["phoneIn", "your phone number"],
    ["phoneSubmit", "Send verification code"],
    //SignInForm
    ["firstNameSIn", "First Name"],
    ["lastNameSIn", "Last Name"],
    ["emailSIn", "Email"],
    ["passSIn", "Password (min. 6 characters)"],
    ["checkboxDesc", "<span class='custom-label'>I agree to <a class='custom-link'>Privacy Policy</a> & <a class='custom-link'>Terms of Use</a></span>"],
    ["signInSubmit", "Get Started!"],
    //Errors, PopUp
    ["signFirstNameValidation", "Еnter first name"],
    ["signLastNameValidation", "Еnter last name"],
    ["signEmailValidation", "Incorrect email"],
    ["signPassValidation", "Password must be > 6 characters"],
    ["signEmailAlreadyOccupied", "This Email Already Occupied"],
    ["loginSubmitError", "Invalid login/password"],
    ["phonePasswordError", "Invalid phone number"],
    ["phonePasswordHeader", "Sign in with phone"],
    ["phonePasswordBody", "The verification code has been sent"],
    ["phonePasswordHolder", "code"],
    ["phonePasswordButton", "Confirm"],
    ["phonePasswordPopError", "Incorrect code"],
    ["forgotPasswordHeader", "Password recovery"],
    ["forgotPasswordBody", "Please enter your email address we'll send you a link to change the password"],
    ["forgotPasswordButton", "Send"],
    ["forgotPasswordButtonHolder", "Email"],
    ["forgotPasswordEmail", "Invalid Email"],
    ["forgotPasswordSend", "The email was send"]
]);
var lang = eng;

function changeLanguage() {
    //loginForm
    document.getElementById('mainHeading').innerText = lang.get("mainHeading");
    document.getElementById('formSign').innerText = lang.get("formSign");
    document.getElementById('formLogin').innerText = lang.get("formLogin");
    document.getElementById('labelEmailIn').innerText = lang.get("labelEmailIn");
    document.getElementById('labelPasswordIn').innerText = lang.get("labelPasswordIn");
    document.getElementById('forgotPassword').innerText = lang.get("forgotPassword");
    document.getElementById('loginSubmit').value = lang.get("loginSubmit");
    document.getElementById('delimiter').innerText = lang.get("delimiter");
    //phoneForm
    document.getElementById('signDescription').innerText = lang.get("signDescription");
    document.getElementById('phoneIn').placeholder = lang.get("phoneIn");
    document.getElementById('phoneSubmit').value = lang.get("phoneSubmit");
    document.getElementById('contactUs').innerText = lang.get("contactUs");
    //signInForm
    document.getElementById('labelFirstNameSIn').innerText = lang.get("firstNameSIn");
    document.getElementById('labelLastNameSIn').innerText = lang.get("lastNameSIn");
    document.getElementById('labelEmailSIn').innerText = lang.get("emailSIn");
    document.getElementById('labelPassSIn').innerText = lang.get("passSIn");
    document.getElementById('checkboxDesc').innerHTML = lang.get("checkboxDesc");
    document.getElementById('signInSubmit').value = lang.get("signInSubmit");
}

languages.onclick = function (event) {
    var target = event.target;
    if (target.tagName != 'LI') return;
    document.getElementById('currentLang').innerText = target.textContent;
    lang = target.id == "ua" ? ua : eng;
    changeLanguage();
    removeValidationText();
};

forms.onclick = function (event) {
    let target = event.target;
    if (target.tagName != 'LI' && target.tagName != 'SPAN') return;
    let elem = document.getElementById('currentForm').innerText;
    if (elem == target.innerText) return;
    changeForm(elem);
};

function changeForm(elem) {
    if (elem == lang.get("formLogin")) {
        formElemChange("currentForm", "rgb(115, 82, 225)", "", "rgb(39, 203, 192)", "50%");
        document.getElementById('loginPart').style.display = 'none';
        document.getElementById('registerPart').style.display = 'block';
        history.replaceState(null, null, AUTH_REGISTER_URL);
    } else {
        formElemChange("", "rgb(39, 203, 192)", "currentForm", "rgb(115, 82, 225)", "0%");
        document.getElementById('registerPart').style.display = 'none';
        document.getElementById('loginPart').style.display = 'block';
        history.replaceState(null, null, AUTH_LOGIN_URL);
    }
    removeValidationText();
}

function formElemChange(signId, signColom, logId, logColor, shift) {
    var formElem = document.getElementById('forms').children;
    formElem[0].id = signId;
    formElem[0].style.color = signColom;
    formElem[1].id = logId;
    formElem[1].style.color = logColor;
    formElem[2].style.right = shift;
}

loginSubmit.onclick = function (event) {
    let pass = document.getElementById('passwordIn');
    let email = document.getElementById('emailIn');
    emailValidation(email,true);
    passValidation(pass,true);
    let errors = document.getElementById("loginPart").querySelector('.error');
    if (errors.innerHTML ==""  ) {
    let response = login(email.value, pass.value);
    response.then(function (response) {
        if (typeof response['status'] != 'undefined') {
            getSession(response['first_name'], response['last_name']);
            homePage(response['first_name'], response['last_name']);
        } else {
            signError(email, 'loginError', 'loginSubmitError');
        }
    })}
    return false;
};

function homePage(firstName, lastName) {
    document.getElementById('loginForm').reset();
    document.getElementById('signForm').reset();
    document.getElementById('phoneForm').reset();
    document.getElementById('left-section').style.display = 'none';
    document.getElementById('right-section').style.display = 'none';
    var div = createElement('div', 'homeMessage', 'home custom-text custom-field'
        , 'Hello, <strong>' + firstName + " " + lastName);
    div.style = "margin: 15% 35% 15% 35%";
    var button = createElement('button', 'logout', 'home custom-button ', 'logout');
    button.onclick = function () {
        logout();
    }
    div.append(button);
    document.body.append(div);
    history.replaceState(null, null, HOME_URL);
}

function logout() {
    var arr = document.getElementsByClassName('home');
    arr[0].remove();
    document.getElementById('left-section').style.display = 'block';
    document.getElementById('right-section').style.display = 'block';
    logoutRequest();
    removeValidationText();
    history.replaceState(null, null, AUTH_LOGIN_URL);
}

const popUp = document.getElementById("popUp");
const popUpHeader = document.getElementById("popUpHeader");
const popUpBody = document.getElementById("popUpBody");
const span = document.getElementsByClassName("closepopUp")[0];

phoneSubmit.onclick = function (event) {
    let phoneNumber = document.getElementById("phoneIn").value;
    let len = String(parseInt(phoneNumber));
    if (phoneNumber.length == 10 && len.length == 10) {
        let response = phoneInCheck(phoneNumber);
        response.then(function (response){
            if(typeof response['status'] != 'undefined') {
                phonePopUp();
                removeValidationText();
            }else{
                signError(phoneNumber, 'phoneError', "phonePasswordError");
            }
        })
    } else {
        signError(phoneNumber, 'phoneError', "phonePasswordError");
    }
    return false;
}
function phonePopUp(){
    popUpHeader.innerText = lang.get("phonePasswordHeader");
    popUpBody.innerText = lang.get("phonePasswordBody");
    if (document.getElementById('phonePasswordInForm') == null) {
        let innerHtml = "<input type='text' class='custom-input'   style='margin:0 0 4% 30%;width:40%' placeholder='" + lang.get("phonePasswordHolder")
            + "' id = 'phonePasswordIn' required/>" +
            "<input type='submit' class='custom-button' style='margin:0 0 4% 25%;width:50%' value='" + lang.get("phonePasswordButton")
            + "' id = 'phonePasswordSubmit' onclick='phonePasswordSubmit()'>"
        let div = createElement('div', "phonePasswordInForm", "custom-field", innerHtml);
        div.style.height = "auto";
        popUp.children[0].append(div);
    }
    popUp.style.display = "block";
}
function phonePasswordSubmit() {
    let number = document.getElementById("phoneIn").value;
    let code = document.getElementById("phonePasswordIn");
        let response = phoneIn(number,code.value);
        response.then(function (response){
            if (typeof response['status'] != 'undefined') {
                getSession(response['first_name'], response['last_name']);
                homePage(response['first_name'], response['last_name']);
                popUp.style.display = "none";
            } else {
                signError(code, 'phonePopError', 'phonePasswordPopError');
            }
        })
}

forgotPassword.onclick = function (event) {
    popUpHeader.innerText = lang.get("forgotPasswordHeader");
    popUpBody.innerText = lang.get("forgotPasswordBody");
    if (document.getElementById('forgotPasswordInForm') == null) {
        let innerHtml = "<input type='email' class='custom-input'  style='margin-bottom:4%;' placeholder='" + lang.get("forgotPasswordButtonHolder")
            + "' id = 'forgotPasswordIn' required/><input type='submit' class='custom-button'value='" + lang.get("forgotPasswordButton")
            + "' id = 'forgotPasswordSubmit' onclick='forgotPasswordSubmit()'>"
        let div = createElement('div', "forgotPasswordInForm", "custom-field", innerHtml);
        div.style.height = "auto";
        popUp.children[0].append(div);
    }
    popUp.style.display = "block";
}

signInSubmit.onclick = function (event) {
    let firstName = document.getElementById('firstNameSIn');
    let lastName = document.getElementById('lastNameSIn');
    let email = document.getElementById('emailSIn');
    let pass = document.getElementById('passSIn');
    let checkbox = document.getElementById('checkboxSIn');
    nameValidation(firstName, lastName);
    emailValidation(email);
    passValidation(pass);
    chechboxValidation(checkbox);
    signLogged(firstName, lastName, email, pass, checkbox);
    return false;
}

function signLogged(firstName, lastName, email, pass, checkbox) {
    let errors = document.getElementById("registerPart").querySelector('.error');
    if (errors == null && checkbox.checked == true) {
        let response = signIn(firstName.value, lastName.value, email.value, pass.value);
        response.then(function (response) {
            if (response['status'] == 'ok') {
                getSession(firstName.value, lastName.value)
                homePage(firstName.value, lastName.value);
            } else {
                if (response['Error'].indexOf("Duplicate entry") != -1) {
                    signError(email, 'signEmailError', 'signEmailAlreadyOccupied');
                }
            }
        })

    }
}

function signError(elem, errorElementId, errorText) {
    let error = document.getElementById(errorElementId);
    if (error == null) {
        let div = createElement('div', errorElementId, 'error', lang.get(errorText));
        elem.after(div);
        elem.style.borderColor = "red";
    } else {
        error.innerText = lang.get(errorText);
    }
}

function nameValidation(firstName, lastName) {
    if (firstName.value.length == 0) {
        signError(firstName, 'signFirstNameError', 'signFirstNameValidation');
    }
    if (lastName.value.length == 0) {
        signError(lastName, 'signLastNameError', 'signLastNameValidation');
    }
}

function emailValidation(email,isLogin=false) {
    let pos = email.value.indexOf("@");
    if (pos + 1 == email.value.length || pos == -1) {
        if(isLogin==false){signError(email, 'signEmailError', 'signEmailValidation');}
        else{
            signError(document, 'loginError', 'loginSubmitError');
        }
    }
}

function passValidation(pass,isLogin=false) {
    if (pass.value.length < 6) {
        if(isLogin==false){signError(pass, 'signPassError', 'signPassValidation');}
        else{
            signError(pass, 'loginError', 'loginSubmitError');
        }
    }
}

function chechboxValidation(checkbox) {
    if (checkbox.checked != true) {
        checkbox.parentElement.children[1].style.color = "red";
    }
}

emailIn.onfocus = function () {
    fieldFocus(emailIn)
};

emailIn.onblur = function () {
    fieldBlur(emailIn)
};

emailIn.onkeydown = function () {
    fieldKeyDown('loginError')
};
passwordIn.onfocus = function () {
    fieldFocus(passwordIn)
};

passwordIn.onblur = function () {
    fieldBlur(passwordIn)
};

passwordIn.onkeydown = function () {
    fieldKeyDown('loginError')
};
firstNameSIn.onfocus = function () {
    fieldFocus(firstNameSIn)
};

firstNameSIn.onblur = function () {
    fieldBlur(firstNameSIn)
};

firstNameSIn.onkeydown = function () {
    fieldKeyDown('signFirstNameError')
};

lastNameSIn.onfocus = function () {
    fieldFocus(lastNameSIn)
};

lastNameSIn.onblur = function () {
    fieldBlur(lastNameSIn)
};

lastNameSIn.onkeydown = function () {
    fieldKeyDown('signLastNameError')
};

emailSIn.onfocus = function () {
    fieldFocus(emailSIn)
};

emailSIn.onblur = function () {
    fieldBlur(emailSIn)
};

emailSIn.onkeydown = function () {
    fieldKeyDown('signEmailError')
};

passSIn.onfocus = function () {
    fieldFocus(passSIn)
};

passSIn.onblur = function () {
    fieldBlur(passSIn)
};

passSIn.onkeydown = function () {
    fieldKeyDown('signPassError')
};

checkboxSIn.onfocus = function () {
    document.getElementById('checkboxDesc').style.color = "black";
}

function fieldFocus(field) {
    field.style.borderColor = "rgb(39, 203, 192)";
}

function fieldKeyDown(id,$isLogin=false) {
    try {
        if($isLogin=false){document.getElementById(id).remove();}
        else{document.getElementById(id).innerText="";}
    } catch {
    }
}

function fieldBlur(field) {
    field.style.borderColor = "rgb(228, 231, 236)";
}

function forgotPasswordSubmit() {
    let email = document.getElementById('forgotPasswordInForm');
    let pos = email.children[0].value.indexOf("@");
    if (pos + 1 == email.children[0].value.length || pos == -1) {
        if (document.getElementById('forgotPasswordError') == null) {
            let div = createElement('div', 'forgotPasswordError', 'error', lang.get("forgotPasswordEmail"));
            div.style.marginTop = "-5px";
            div.style.marginBottom = "10px";
            document.getElementById('forgotPasswordSubmit').before(div);
        }
    } else {
        email.remove();
        popUpBody.innerText = lang.get("forgotPasswordSend");
    }
    return false;
}

function createElement(element, id = "", className = "", innerHtml = "") {
    let elem = document.createElement(element);
    elem.id = id;
    elem.className = className;
    elem.innerHTML = innerHtml;
    return elem;
}

span.onclick = function () {
    popUp.style.display = "none";
    try {
        document.getElementById('forgotPasswordInForm').remove();
    } catch {
    }
    try {
        document.getElementById('phonePasswordInForm').remove();
    } catch {
    }
    removeValidationText();
}

window.onclick = function (event) {
    if (event.target == popUp) {
        popUp.style.display = "none";
        try {
            document.getElementById('forgotPasswordInForm').remove();
        } catch {
        }
        try {
            document.getElementById('phonePasswordInForm').remove();
        } catch {
        }
        removeValidationText();
    }
}

function removeValidationText() {
    var errors = document.body.querySelectorAll('.error');
    for (var i = 0; i < errors.length; i++) {
        errors[i].innerText = "";
    }
}
