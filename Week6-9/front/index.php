<?php
require_once 'config.php';
session_start();
if (!isset($_SESSION['first_name'])) {
    Setcookie(COOKIE_NAME, "", time() - 3600, "/");
}
?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="reset.css">
    <link rel="stylesheet" href="sign.css">
    <title>Test Page</title>
</head>
<body>
<div class="left" id="left-section"><img src="mother.jpg"></div>
<div class="section" id="right-section">
    <div class="langSelector">
        <ul>
            <li><span id="currentLang" class="leftstr">English</span><img src="arrow.svg" class="rightstr" width="15"
                                                                          height="15"></li>
            <ul id="languages">
                <li class="language" id="eng">English</li>
                <li class="language" id="ua">Українська</li>
            </ul>
        </ul>
    </div>
    <div class="text mainHeading"><img src="logo.png" class="mainHeadingImg"><span
                id="mainHeading">Test auth page</span></div>
    <div class="formController">
        <div class="menu" id="forms">
            <li id="" style="color:rgb(39, 203, 192)"><span id="formSign">Sign Up</span></li>
            <li id="currentForm" style="color:rgb(115, 82, 225)"><span id="formLogin">Log In</span></li>
            <div class="line"></div>
        </div>
        <div class="lineshadow"></div>
    </div>
    <div id="loginPart">
        <form id="loginForm">
            <div class="custom-field">
                <label for="emailIn" id="labelEmailIn">Email</label>
                <input type="text" class="custom-input" id="emailIn" name="emailIn" required/>
            </div>
            <div class="custom-field">
                <label for="passwordIn" class="leftstr" id="labelPasswordIn">Password</label>
                <label class="rightstr text" id="forgotPassword">Forgot password?</label>
                <input type="password" class="custom-input" id="passwordIn" name="passwordIn" required/>
            </div>
            <div class="error" id="loginError"><span></span></div>
            <div class="custom-field">
                <input type="submit" class="custom-button" id="loginSubmit" value="Log In">
            </div>
        </form>
        <div class="bigColorText"><span id="delimiter">-OR-</span></div>
        <form id="phoneForm">
            <div class="custom-field custom-text"><span id="signDescription">Sign in with your phone number. We will send you a 6-digit code to ensure that only you have access to your care team</span>
            </div>
            <div class="custom-field">
                <input type="text" class="custom-input" id="phoneIn" placeholder="your phone number" required/>
            </div>
            <div class="error" id="phoneError"><span></span></div>
            <div class="custom-field">
                <input type="submit" class="custom-button" id="phoneSubmit" value="Send verification code">
            </div>
        </form>
    </div>
    <div id="registerPart" style="display: none">
        <form id="signForm">
            <div class="custom-field">
                <label for="firstNameSIn" id="labelFirstNameSIn">First Name</label>
                <input type="text" class="custom-input" id="firstNameSIn" required/>
            </div>
            <div class="custom-field">
                <label for="lastNameSIn" id="labelLastNameSIn">Last Name</label>
                <input type="text" class="custom-input" id="lastNameSIn" required/>
            </div>
            <div class="custom-field">
                <label for="emailSIn" id="labelEmailSIn">Email</label>
                <input type="text" class="custom-input" id="emailSIn" required/>
            </div>
            <div class="custom-field">
                <label for="passSIn" id="labelPassSIn">Password (min. 6 characters)</label>
                <input type="text" class="custom-input" id="passSIn" required/>
            </div>
            <div class="custom-field custom-checkbox">
                <input type="checkbox" id="checkboxSIn"/>
                <div id="checkboxDesc"><span class="custom-label">I agree to <a class="custom-link">Privacy Policy</a> & <a
                                class="custom-link">Terms of Use</a></span></div>
            </div>
            <div class="custom-field">
                <input type="submit" class="custom-button" id="signInSubmit" value="Get Started!">
            </div>
        </form>
    </div>
    <div class="text footer" id="contactUs">Contact Us</div>
</div>
<div id="popUp" class="popUp">
    <div class="popUp-content">
        <div class="popUpHeader">
            <h2 id="popUpHeader"></h2>
            <span class="closepopUp">&times;</span></div>
        <div id="popUpBody"><span></span></div>
    </div>
</div>
</body>
<script src="./node_modules/axios/dist/axios.min.js"></script>
<script src="config.js"></script>
<script src="request.js"></script>
<script src="main.js"></script>
<?php
if (isset($_SESSION['first_name']) && isset($_SESSION['last_name'])) {
    echo "<script>homePage('" . $_SESSION['first_name'] . "','" . $_SESSION['last_name'] . " ');</script>";
} else {
    echo "<script> history.replaceState(null, null, '" . AUTH_LOGIN . "' );</script>";
}
?>
</html>
