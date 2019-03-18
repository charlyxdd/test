export default class AuthService{
    constructor() {
    }

    signIn(userToLogin) {
        axios.defaults.headers.common['Content-Type'] = 'application/json';
        return axios.post('/api/login', userToLogin);
            /*.then((reponse) => {
                console.log(response);
            })
            .catch((error) => {
                console.log(error);
            });*/
    }

    getIdentity() {
        let ident = localStorage.getItem('identity');
        if (ident !== undefined && ident != null) {
            ident = JSON.parse(localStorage.getItem('identity'));
            if (ident !== undefined) {
                this.identity = ident;
            } else {
                this.identity = '';
            }
        } else {
            ident = (sessionStorage.getItem('identity'));
            if (ident !== undefined) {
                ident = JSON.parse(sessionStorage.getItem('identity'));
                this.identity = ident;
            } else {
                this.identity = '';
            }
        }

        return this.identity;

    }

    getToken() {
        let token = localStorage.getItem('auth');
        if (token !== 'undefined' && token != null) {
            this.token = token;
        } else {
            token = sessionStorage.getItem('auth');
            if (token !== 'undefined' && token != null) {
                this.token = token;
            } else {
                this.token = '';
            }
        }
        return this.token;
    }

    check() {
        const auth = localStorage.getItem('auth');
        const auth2 = sessionStorage.getItem('auth');
        return !(auth == null && auth2 == null);
    }

    login(user, token, remember) {
        if (remember) {
            localStorage.setItem('auth', 'Bearer ' + token);
            localStorage.setItem('identity', JSON.stringify(user));
        } else {
            sessionStorage.setItem('auth', 'Bearer ' + token);
            sessionStorage.setItem('identity', JSON.stringify(user));
        }
        // Config.dispatchEvent('update_user', {});
    }
}