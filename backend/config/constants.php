<?php
/* Florian Mudespacher
 * Quiz interactif - Diploma work
 * CFPT - T.IS-E2A - 2019
 */

use App\Configuration;

return [
    'backoffice' => [
        'NUMBER_OF_DISPLAYED_QUESTIONS_PER_PAGE' => 10,
        'NUMBER_OF_DISPLAYED_TAGS_PER_PAGE' => 10,
        'NUMBER_OF_DISPLAYED_TEAMS_PER_PAGE' => 10,
        'NUMBER_OF_DISPLAYED_USERS_PER_PAGE' => 10,
        'NUMBER_OF_DISPLAYED_SESSIONS_PER_PAGE' => 10,

    ],
    'propositions' => [
        'MINIMUM_PROPOSITION_LABEL_LENGTH' => null,
        'MAXIMUM_PROPOSITION_LABEL_LENGTH' => null,
    ],
    'questions' => [
        'MINIMUM_QUESTION_LABEL_LENGTH' => null,
        'MAXIMUM_QUESTION_LABEL_LENGTH' => null,
        'MINIMUM_QUESTION_POINTS' => null,
        'MAXIMUM_QUESTION_POINTS' => null,
    ],
    'sessions' => [
        'NUMBER_OF_ASKED_QUESTION' => null,
        'NUMBER_OF_DISPLAYED_USERS' => null,
        'MINIMUM_SESSION_LABEL_LENGTH' => null,
        'MAXIMUM_SESSION_LABEL_LENGTH' => null,
    ],
    'tags' => [
        'MINIMUM_TAG_NAME_LENGTH' => null,
        'MAXIMUM_TAG_NAME_LENGTH' => null,
    ],
    'teams' => [
        'MINIMUM_TEAM_NAME_LENGTH' => null,
        'MAXIMUM_TEAM_NAME_LENGTH' => null,
    ],
    'types' => [
        'MINIMUM_TYPE_NAME_LENGTH' => null,
        'MAXIMUM_TYPE_NAME_LENGTH' => null,
    ],
    'users' => [
        'MINIMUM_USERNAME_LENGTH' => null,
        'MAXIMUM_USERNAME_LENGTH' => null,
        'MINIMUM_PASSWORD_LENGTH' => null,
        'MAXIMUM_PASSWORD_LENGTH' => null,
        'MINIMUM_NAME_LENGTH' => null,
        'MAXIMUM_NAME_LENGTH' => null,
        'MINIMUM_SURNAME_LENGTH' => null,
        'MAXIMUM_SURNAME_LENGTH' => null,
    ],
];

?>
