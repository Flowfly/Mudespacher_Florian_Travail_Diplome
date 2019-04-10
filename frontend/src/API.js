import JQuery from 'jquery'

const API_ENDPOINT = "http://localhost/api/";

function getActualQuestion() {
    var settings = {
        "url": `${API_ENDPOINT}session/1/actual-question`,
        "method": "GET",
    };
    return JQuery.ajax(settings);
}

function addUser(datas) {
    var settings = {
        "url": `${API_ENDPOINT}users/add`,
        "async": true,
        "crossDomain": true,
        "method": "POST",
        "data": {
            "username": datas.username === '' ? '' : datas.username,
            "password": datas.password === '' ? '' : datas.password,
            "password_confirmation": datas.password_confirmation === '' ? '' : datas.password_confirmation,
            "name": datas.name === '' ? '' : datas.name,
            "surname": datas.surname === '' ? '' : datas.surname,
            "date": datas.date === '' ? '' : datas.date,
            "email": datas.email === '' ? '' : datas.email,
            "phone": datas.phone === '' ? '' : datas.phone,
        }
    };
    return JQuery.ajax(settings);
}

export default {
    getActualQuestion,
    addUser,
}
