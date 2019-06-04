import JQuery from 'jquery'

const API_ENDPOINT = "http://192.168.0.112/api/";

function getActualQuestion(id) {
    var settings = {
        "url": `${API_ENDPOINT}session/${id}/actual-question`,
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
function deleteUser(datas) {
    var settings = {
        "url": `${API_ENDPOINT}users/delete`,
        "async": true,
        "crossDomain": true,
        "method": "POST",
        "data": {
            "id": datas.user_id,
        }
    };
    return JQuery.ajax(settings);
}

function getAllNotStartedSessions(){
    var settings = {
        "url": `${API_ENDPOINT}session/not-started-sessions`,
        "method": "GET",
    };
    return JQuery.ajax(settings);
}

function subscribeUser(datas){
    var settings = {
        "url": `${API_ENDPOINT}session/subscribe-user`,
        "async": true,
        "crossDomain": true,
        "method": "POST",
        "data": {
            "user_id": datas.user_id === '' ? '' : datas.user_id,
            "session_id": datas.session_id === '' ? '' : datas.session_id,
        }
    };
    return JQuery.ajax(settings);
}

function userAnswer(datas){
    var settings = {
        "url": `${API_ENDPOINT}session/${datas.session_id}/answer`,
        "async": true,
        "crossDomain": true,
        "method": "POST",
        "data": {
            "user_id": datas.user_id,
            "proposition_id": datas.proposition_id,
        }
    };
    return JQuery.ajax(settings);
}

function getScore(datas){
    console.log('user id : ' + datas.user_id);
    var settings = {
        "url": `${API_ENDPOINT}session/${datas.session_id}/${datas.user_id}/ranking`,
        "method": "GET",
    };
    return JQuery.ajax(settings);
}

export default {
    getActualQuestion,
    addUser,
    deleteUser,
    getAllNotStartedSessions,
    subscribeUser,
    userAnswer,
    getScore,
}
