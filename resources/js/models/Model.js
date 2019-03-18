import GeneralService from "../services/GeneralService";
import Functions from "../services/Functions";

export default class Model{
    constructor(peticion){
        this.peticion = peticion;
        this.services = new GeneralService(peticion);
        this.functions = new Functions();
        this.clean_values();
    }

    clean_values(){
        this.filter={};
        this.related = [];
        this.page = 1;
        this.last_page = 1;
    }

    all(page, related){
        return new Promise((resolve, reject) => {
            if(related) {
                this.services.setPetition(this.peticion + '/related/' + this.functions.serialize(this.related));
            }
            this.services.all(page)
                .then((response)=>{
                   resolve(response);
                })
                .catch(function(err){
                    reject(err);
                });
            this.services.setPetition(this.peticion);
        });
    }

    find(id, related){
        return new Promise((resolve, reject)=>{
            let r = [];
            if(related) {
                r = this.related;
            }
            this.services.find(id, this.functions.serialize(r))
                .then((response)=>{
                    if(response.data.result === 'success'){
                        resolve(response.data.data);
                    }
                    else{
                        reject(response.data.error);
                    }
                })
                .catch(function(err){
                    reject(err);
                });
            this.services.setPetition(this.peticion);
        });
    }

    fn_filter(params, related){
        return new Promise((resolve,reject) =>{
            let r = [];
            if(related) {
                r = this.related;
            }
            r = this.functions.serialize(r);
            this.services.fn_filter(params, r)
                .then((response)=>{
                    if(response.data.result === 'success'){
                        resolve(response.data.data);
                    }
                    else{
                        reject(response.data.error);
                    }
                })
                .catch(function(err){
                    reject(err);
                });
            this.services.setPetition(this.peticion);
        });
    }

    save(data){
        return new Promise((resolve,reject) =>{
            this.services.save(data)
                .then((response)=>{
                    if(response.data.result === 'success'){
                        resolve();
                    }
                    else{
                        reject();
                    }
                })
                .catch(function(err){
                    reject(err.data);
                });
        });
    }

    delete(id){
        return new Promise((resolve,reject) =>{
            this.services.delete(id)
                .then((response)=>{
                    resolve(response);
                })
                .catch(function(err){
                    reject(err);
                });
        });
    }

    where(field, value){
        this.filter[field] = value;
        return this;
    }

    with(relation){
        this.related.push(relation);
        return this;
    }
}