const MIN_PROPOSITION_NUMBER = 1; //0 means 1 answer, 1 means 2 answers etc.
const MAX_PROPOSITION_NUMBER = 3; //3 means 4 answers, 5 means 6 answers etc.
const SINGLE_ANSWER_QUESTION_TYPE_ID = 1;
const MUSICAL_QUESTION_TYPE_ID = 3;


/**
 * Function that allows to add a proposition field to the page
 */
function addProposition(divToFill, isEditing) {
    var lastId = (parseInt(divToFill.lastElementChild.id.split('-')[1]) + 1);
    console.log(lastId);
    if (lastId <= MAX_PROPOSITION_NUMBER) {
        //Creation of the text input that allows to add the text of the proposition
        var inputTextToAdd = document.createElement('input');
        inputTextToAdd.setAttribute('type', 'text');
        inputTextToAdd.setAttribute('class', 'form-control col-10');
        inputTextToAdd.setAttribute('name', `prop-${isEditing ? 'add' : lastId}`);
        inputTextToAdd.setAttribute('required', true);

        //Creation of the radio input that allows to set if the proposition is the right one or not
        var inputRadioToAdd = document.createElement('input');
        inputRadioToAdd.setAttribute('type', 'radio');
        inputRadioToAdd.setAttribute('name', 'isGoodAnswer');
        inputRadioToAdd.setAttribute('class', 'form-control col-1');
        inputRadioToAdd.setAttribute('value', lastId);

        //Creation of the container
        var container = document.createElement('div');
        container.setAttribute('id', 'prop-' + lastId);
        container.setAttribute('style', 'display:flex;');
        container.setAttribute('class', 'form-group');

        //Adding the elements into the container
        container.appendChild(inputTextToAdd);
        container.appendChild(inputRadioToAdd);
        container.innerHTML += "Bonne réponse";
        //Adding the container to the group
        divToFill.appendChild(container);


        //Changing the text "Number of elements"
        document.querySelector('#proposition-number').innerHTML = parseInt(lastId) + 1;
    }

}

/**
 * Function that allows to remove a proposition field from the web page
 */
function removeProposition(divToFill) {
    var lastId = divToFill.lastElementChild.id.split('-')[1];
    if (lastId > MIN_PROPOSITION_NUMBER) {
        var lastElement = divToFill.lastElementChild;
        divToFill.removeChild(lastElement);
        document.querySelector('#proposition-number').innerHTML = lastId;
    }
}

/**
 * Function that allows to add multiple attributes to a html element at once
 * @param el HTML element
 * @param attrs Attributes (object)
 */
function setAttributes(el, attrs) {
    for (var key in attrs) {
        el.setAttribute(key, attrs[key]);
    }
}

/**
 * Function that allows to load a component in a html field depending of the question type
 * @param typeNumber The id of the type
 * @param divToFill The div to fill. Needs to be to the jQuery form. Example : $("#a-div")
 */
function checkQuestionType(typeNumber, divToFill) {
    typeNumber = parseInt(typeNumber);
    if (typeNumber === MUSICAL_QUESTION_TYPE_ID) {
        var label = document.createElement('label');
        label.setAttribute('for', ' question-file');
        label.innerHTML = "Fichier : ";
        var fileInput = document.createElement('input');
        setAttributes(fileInput, {
            'type': 'file',
            'id': 'question-file',
            'required': true,
            'accept': 'audio/*',
            'name': 'question-file'
        });
        divToFill.append(label)
            .append('<br>')
            .append(fileInput);
    } else if (typeNumber === SINGLE_ANSWER_QUESTION_TYPE_ID) {
        divToFill.html('');
    }
}

