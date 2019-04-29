const TIME_TO_ANSWER = 50;//in seconds
const WEB_SOCKET_SERVICE = {
    broadcaster: 'pusher',
    key: 'c04beebc0bd8d8c9866f',
    cluster: 'eu',
    encrypted: true,
};
const REGISTRATION_RULES = {
    username: {
        min: 4,
        max: 15,
    },
    password: {
        min: 5,
        max: 20,
    },
    name: {
        min: 2,
        max: 30,
    },
    surname: {
        min: 2,
        max: 30,
    },
};
const REGISTRATION_ERROR_MESSAGES = {
    username: {
        min: getMinMaxMessage("nom d'utilisateur", true, REGISTRATION_RULES.username.min),
        max: getMinMaxMessage("nom d'utilisateur", false, REGISTRATION_RULES.username.max),
        required: getRequiredMessage("nom d'utilisateur"),
    },
    password: {
        min: getMinMaxMessage("mot de passe", true, REGISTRATION_RULES.password.min),
        max: getMinMaxMessage("mot de passe", false, REGISTRATION_RULES.password.max),
        required: getRequiredMessage("mot de passe"),
    },
    name:{
        min: getMinMaxMessage("prénom", true, REGISTRATION_RULES.name.min),
        max: getMinMaxMessage("prénom", false, REGISTRATION_RULES.name.max),
        required: getRequiredMessage("prénom"),
    },
    surname:{
        min: getMinMaxMessage("nom de famille", true, REGISTRATION_RULES.surname.min),
        max: getMinMaxMessage("nom de famille", false, REGISTRATION_RULES.surname.max),
        required: getRequiredMessage("nom de famille"),
    },
    email: {
        required: getRequiredMessage("email"),
    },
    phone:{
        required: getRequiredMessage("téléphone"),
    }
};


function getRequiredMessage(field){
    return `Le champ ${field} est obligatoire`;
}

function getMinMaxMessage(field, isMinimum ,numberOfChar) {
    return `Le ${field} ne doit pas être ${isMinimum ? 'inférieur' : 'supérieur'} à ${numberOfChar} caractères`;
};
export default {
    TIME_TO_ANSWER,
    REGISTRATION_RULES,
    REGISTRATION_ERROR_MESSAGES,
    WEB_SOCKET_SERVICE,
}