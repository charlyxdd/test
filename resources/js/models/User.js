import Model from "./Model";

export default class User extends Model {
    constructor() {
        super('users');
    }

    get id() {
        return this._id;
    }

    set id(value) {
        this._id = value;
    }

    get name() {
        return this._name;
    }

    set name(value) {
        this._name = value;
    }

    get email() {
        return this._email;
    }

    set email(value) {
        this._email = value;
    }

    get password() {
        return this._password;
    }

    set password(value) {
        this._password = value;
    }

    get status() {
        return this._status;
    }

    set status(value) {
        this._status = value;
    }

    get image() {
        return this._image;
    }

    set role_id(value) {
        this._role_id = value;
    }

    get role_id() {
        return this._role_id;
    }

    get initials(){
        if(this._username) {
            return this._username.substring(0,1).toUpperCase();
        }
        return "";
    }

    init_values(id, name, email, password, status, role_id) {
        this._id = id;
        this.name = name;
        this.email = email;
        this._password = password;
        this._status = status;
        this.role_id = role_id;
        this._image = "https://images.pexels.com/photos/370799/pexels-photo-370799.jpeg?cs=srgb&dl=light-art-blue-370799.jpg&fm=jpg";
    }

    find(id) {
        return new Promise((resolve, reject) => {
            super.find(id, this.related.length > 0)
                .then((data) => {
                    const u = new User();
                    u.init_values(data.id, data.name, data.email, '', data.status, data.role_id);
                    resolve(u);
                })
                .catch((err) => {
                    console.log(err);
                });
        });
    }

    get() {
        return new Promise((resolve, reject) => {
            if (Object.getOwnPropertyNames(this.filter).length > 0) {
                super.fn_filter(this.filter, this.related.length > 0)
                    .then((data) => {
                        const users = [];
                        for (let i = 0; i < data.length; i++) {
                            const u = new User();
                            u.init_values(data[i].id, data[i].name, data[i].email, '', data[i].status, data[i].role_id);
                            users.push(u);
                        }
                        resolve(users);
                    })
                    .catch((err) => {
                        reject('Error');
                        console.log(err);
                    });
            }
            else {
                super.all(this.page, this.related.length > 0)
                    .then((data) => {
                        data = data.data.data;
                        console.log('data',data);
                        const users = [];
                        for (let i = 0; i < data.data.length; i++) {
                            const u = new User();
                            u.init_values(data.data[i].id, data.data[i].name, data.data[i].email, '', data.data[i].status, data.data[i].role_id);
                            users.push(u);
                        }
                        resolve(users);
                    })
                    .catch((err) => {
                        reject('Error');
                        console.log(err);
                    });
            }
        });
    }

    save() {
        return new Promise((resolve, reject) => {
            super.save(this.json())
                .then((data) => {
                    console.log(data);
                })
                .catch((err) => {
                    reject(err);
                });
        });
    }

    json() {
        return {
            id: this._id,
            name: this.name,
            password: this.password,
            role_id: this.role_id,
            status: this._status
        }
    }
}