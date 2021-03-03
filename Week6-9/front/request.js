function getSession(firstName,lastName) {
    axios({
        method: 'post',
        url: 'session.php',
        data: {
            'action': 'getSession',
            'first_name': firstName,
            'last_name': lastName
        },
    })
}

function logoutRequest() {
    axios({
        method: 'post',
        url: '/session.php',
        data: {
            'action': 'logout'
        },
    })
}

function login(email, pass) {
    return axios({
        method: 'post',
        url: USER_URL,
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded; charset=utf-8',
        },
        data: {
            email: email,
            pass: pass,
        },
    }).then(function (response) {
        return response.data;
    });
}

function signIn(firstName, lastName, email, pass) {
    return axios({
        method: 'post',
        url: USER_URL,
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded; charset=utf-8',
        },
        data: {
            first_name: firstName,
            last_name: lastName,
            email: email,
            pass: pass
        }
    }).then(function (response) {
        return response.data;
    });
}
function phoneInCheck(number){
    return axios({
        method: 'post',
        url: USER_URL,
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded; charset=utf-8',
        },
        data: {
            number: number
        }
    }).then(function (response) {
        return response.data;
    });
}
function phoneIn(number,code){
    return axios({
        method: 'post',
        url: USER_URL,
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded; charset=utf-8',
        },
        data: {
            number: number,
            code: code
        }
    }).then(function (response) {
        return response.data;
    });
}

function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}
