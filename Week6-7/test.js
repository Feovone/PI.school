 document.addEventListener("DOMContentLoaded", () => {
     history.replaceState(null, null, '/auth/login');
 });

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
     ["loginSubmitError", "Недійсний логін / пароль"],
     ["phonePasswordError", "Недійсний номер телефону"],
     ["phonePasswordHeader", "Вхід за допомогою телефону"],
     ["phonePasswordBody", "Код підтвердження надіслано"],
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
     ["loginSubmitError", "Invalid login/password"],
     ["phonePasswordError", "Invalid phone number"],
     ["phonePasswordHeader", "Sign in with phone"],
     ["phonePasswordBody", "The verification code has been sent"],
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
     removeValidation();
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
         history.replaceState(null, null, '/auth/register');
     } else {
         formElemChange("", "rgb(39, 203, 192)", "currentForm", "rgb(115, 82, 225)", "0%");
         document.getElementById('registerPart').style.display = 'none';
         document.getElementById('loginPart').style.display = 'block';
         history.replaceState(null, null, '/auth/login');
     }
     removeValidation();
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
     let pass = document.getElementById('passwordIn').value;
     let email = document.getElementById('emailIn').value;
     if (pass == "1234567" && email == "admin") {
         document.getElementById('left-section').style.display = 'none';
         document.getElementById('right-section').style.display = 'none';
         var p = createElement('p', '', '', 'Hello, Admin!');
         document.body.appendChild(p);
         history.replaceState(null, null, '/home');
     } else {
         addError('loginError', 'loginSubmitError');
     }
     return false;
 };

 const popUp = document.getElementById("popUp");
 const popUpHeader = document.getElementById("popUpHeader");
 const popUpBody = document.getElementById("popUpBody");
 const span = document.getElementsByClassName("closepopUp")[0];

 phoneSubmit.onclick = function (event) {
     let phoneNumber = document.getElementById("phoneIn").value;
     debugger
     let len = String(parseInt(phoneNumber));
     if (phoneNumber.length == 10 && len.length == 10) {
         popUpHeader.innerText = lang.get("phonePasswordHeader");
         popUpBody.innerText = lang.get("phonePasswordBody");
         popUp.style.display = "block";
         removeValidation();
     } else {
         addError('phoneError', "phonePasswordError");
     }
 }

 forgotPassword.onclick = function (event) {
     popUpHeader.innerText = lang.get("forgotPasswordHeader");
     popUpBody.innerText = lang.get("forgotPasswordBody");
     if (document.getElementById('forgotPasswordIn') == null) {
         let innerHtml = "<input type='email' class='custom-input'  style='margin-bottom:4%;' placeholder='" + lang.get("forgotPasswordButtonHolder") + "' id='forgotPasswordIn' required/><input type='submit' class='custom-button'value='" + lang.get("forgotPasswordButton") + "' id = 'forgotPasswordSubmit' onclick='forgotPasswordSubmit()'>"
         let div = createElement('div', "forgotPasswordIn", "custom-field", innerHtml);
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
     logged(firstName.value, lastName.value, checkbox);
     return false;
 }

 function logged(firstName, lastName, checkbox) {
     let errors = document.getElementById("registerPart").querySelector('.error');
     if (errors == null && checkbox.checked == true) {
         document.getElementById('left-section').style.display = 'none';
         document.getElementById('right-section').style.display = 'none';
         let p = createElement('p', '', '', "Hello, " + firstName + " " + lastName);
         document.body.appendChild(p);
         history.replaceState(null, null, '/home');
     }
 }

 function nameValidation(firstName, lastName) {
     if (firstName.value.length == 0) {
         let elem = document.getElementById('signfirstNameError');
         if (elem == null) {
             let div = createElement('div', 'signfirstNameError', 'error', lang.get("signFirstNameValidation"));
             firstName.after(div);
             firstName.style.borderColor = "red";
         } else {
             elem.innerText = lang.get("signFirstNameValidation");
         }
     }
     if (lastName.value.length == 0) {
         let elem = document.getElementById('signlastNameError');
         if (elem == null) {
             let div = createElement('div', 'signlastNameError', 'error', lang.get("signLastNameValidation"));
             lastName.after(div);
             lastName.style.borderColor = "red";
         } else {
             elem.innerText = lang.get("signLastNameValidation");
         }
     }
 }

 function emailValidation(email) {
     let pos = email.value.indexOf("@");
     if (pos + 1 == email.value.length || pos == -1) {
         let elem = document.getElementById('signemailError');
         if (elem == null) {
             let div = createElement('div', 'signemailError', 'error', lang.get("signEmailValidation"));
             email.after(div);
             email.style.borderColor = "red";
         } else {
             elem.innerText = lang.get("signEmailValidation");
         }
     }
 }

 function passValidation(pass) {
     if (pass.value.length < 6) {
         let elem = document.getElementById('signpassError');
         if (elem == null) {
             let div = createElement('div', 'signpassError', 'error', lang.get("signPassValidation"));
             pass.after(div);
             pass.style.borderColor = "red"
         } else {
             elem.innerText = lang.get("signPassValidation");
         }
     }
 }

 function chechboxValidation(checkbox) {
     if (checkbox.checked != true) {
         checkbox.parentElement.children[1].style.color = "red";
     };
 }

 firstNameSIn.onfocus = function () {
     fieldFocus(firstNameSIn)
 };

 firstNameSIn.onblur = function () {
     fieldBlur(firstNameSIn)
 };

 firstNameSIn.onkeydown = function () {
     fieldKeyDown('signfirstNameError')
 };

 lastNameSIn.onfocus = function () {
     fieldFocus(lastNameSIn)
 };

 lastNameSIn.onblur = function () {
     fieldBlur(lastNameSIn)
 };

 lastNameSIn.onkeydown = function () {
     fieldKeyDown('signlastNameError')
 };

 emailSIn.onfocus = function () {
     fieldFocus(emailSIn)
 };

 emailSIn.onblur = function () {
     fieldBlur(emailSIn)
 };

 emailSIn.onkeydown = function () {
     fieldKeyDown('signemailError')
 };

 passSIn.onfocus = function () {
     fieldFocus(passSIn)
 };

 passSIn.onblur = function () {
     fieldBlur(passSIn)
 };

 passSIn.onkeydown = function () {
     fieldKeyDown('signpassError')
 };

 checkboxSIn.onfocus = function () {
     document.getElementById('checkboxDesc').style.color = "black";
 }

 function fieldFocus(field) {
     field.style.borderColor = "rgb(39, 203, 192)";
 }

 function fieldKeyDown(id) {
     try {
         let elem = document.getElementById(id).remove();
     } catch {

     }
 }

 function fieldBlur(field) {
     field.style.borderColor = "rgb(228, 231, 236)";
 }

 function forgotPasswordSubmit() {
     let email = document.getElementById('forgotPasswordIn');
     let pos = email.children[0].value.indexOf("@");
     if (pos + 1 == email.children[0].value.length || pos == -1) {
         if (document.getElementById('fogotPasswordError') == null) {
             let div = createElement('div', 'fogotPasswordError', 'error', lang.get("forgotPasswordEmail"));
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
     try{
     document.getElementById('forgotPasswordIn').remove();
     } catch {}
     removeValidation();
 }

 window.onclick = function (event) {
     if (event.target == popUp) {
         popUp.style.display = "none";
         try{
         document.getElementById('forgotPasswordIn').remove();
         }catch {}
         removeValidation();
     }
 }

 function addError(id, text) {
     var error = document.getElementById(id);
     error.style.marginbottom = "15px";
     error.innerText = lang.get(text);
 }

 function removeValidation() {
     var errors = document.body.querySelectorAll('.error');
     for (var i = 0; i < errors.length; i++) {
         errors[i].innerText = "";
     }
 }
