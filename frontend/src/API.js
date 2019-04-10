import JQuery from 'jquery'

function getActualQuestion() {
    var settings = {
        "url": "http://localhost/api/session/1/actual-question",
        "method": "GET",
    };

    return JQuery.ajax(settings);
}

export default {
    getActualQuestion,
}
