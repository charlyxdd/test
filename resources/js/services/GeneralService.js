import AuthService from "./AuthService";

export default class GeneralService{
    constructor(peticion){
        this.auth = new AuthService();
        this.petition = '/api/' + peticion;
        this.token = this.auth.getToken();
        axios.defaults.headers.common['authorization'] = this.auth.getToken();
        axios.defaults.headers.common['Content-Type'] = 'application/json';
    }

    setPetition(petition){
        this.petition = petition;
    }

    all(page) {
        return axios.get(this.petition + '?page=' + page)
    }

    save(data){
        if(data.id === 0 || !data.id){
            return axios.post(this.petition,data);
        }
        else{
            return axios.put(this.petition, data);
        }
    }

    delete(id){
        return axios.delete(this.petition + '/' + id,);
    }

    find(id, related){
        return axios.get(this.petition + '/' + id + '/' + related);
    }

    fn_filter(params, related){
        return axios.post(this.petition + '/filter/' + related, params);
    }
}