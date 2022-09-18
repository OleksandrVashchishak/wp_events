export const userLogin = (axios, login, password, setIsLogin, isRegistr) => {
    var apiHost = 'http://cars/wp-json';
    axios({
        method: 'POST',
        url: apiHost + '/jwt-auth/v1/token',
        params: {
            username: login,
            password: password
        }
    }).then((response) => {
        console.log(response.data);
        localStorage.setItem("token", response.data.token);
        localStorage.setItem("email", response.data.user_email);
        setIsLogin(true)

        getUserId(response.data.user_email, axios)

    }).catch(function () {
        alert('Uncorrect login or password')
    });
}

const getUserId = (email, axios) => {
    var apiHost = 'http://cars/wp-json';
    axios({
        method: 'POST',
        url: apiHost + '/wm/v1/get_user_id',
        params: {
            email: email,
        }
    }).then((response) => {
        if (response.data) {
            localStorage.setItem("user_id", response.data);
        }

    }).catch(function () {
        alert('Uncorrect login or password')
    });
}