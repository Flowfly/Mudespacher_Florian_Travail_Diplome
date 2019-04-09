<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="{{asset('../../img/logo.png')}}">
    @if(session()->get('theme') && session()->get('integrity'))
        <link rel="stylesheet" href="{{session('theme')}}"
              integrity="{{session('integrity')}}"
              crossorigin="anonymous">
    @else
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
              integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
              crossorigin="anonymous">
    @endif

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css"
          type="text/css">

    <link rel="stylesheet" href="{{asset('../../css/style.css')}}" type="text/css">

    <title>Premier backoffice</title>
</head>

<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-12" style="display: flex;">

            <div class="col-1">
                <a href="/backoffice">
                    <img src="{{asset('../../img/logo.png')}}" alt="logo" class="logo">
                </a>
            </div>
            <div class="col-10 title">
                <h2 class="hcenter">Quiz - Backoffice</h2>
            </div>
            <div class="col-1" style="text-align: right">
                <a href="#" class="dropdown-toggle login-link hcenter" data-toggle="dropdown">
                    <img src="{{asset('../../img/login.png')}}" alt="login" class="login-img">
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    @if(auth()->check())
                        <a href="/backoffice/my-account">
                            <button class="dropdown-item" type="button">Mon compte</button>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="/backoffice/logout">
                            <button class="dropdown-item" type="button">Déconnexion</button>
                        </a>
                    @else
                        <a href="/backoffice/login">
                            <button class="dropdown-item" type="button">Connexion</button>
                        </a>
                        <a href="/backoffice/register">
                            <button class="dropdown-item" type="button">Inscription</button>
                        </a>
                    @endif
                </div>

            </div>

        </div>
        <div class="col-12" style="margin-bottom: 1%;">
            <hr>
        </div>

        @include('backoffice/navbar')
        <div class="col">
            @yield('content')
        </div>
    </div>
</div>

</body>
<script>
    const MIN_PROPOSITION_NUMBER = 1; //0 means 1 answer, 1 means 2 answers etc.
    const MAX_PROPOSITION_NUMBER = 3; //3 means 4 answers, 5 means 6 answers etc.

    function addProposition() {
        var group = document.querySelector('#proposition-group');
        var lastId = (parseInt(group.lastElementChild.id.split('-')[1]) + 1);
        if (lastId <= MAX_PROPOSITION_NUMBER) {
            //Creation of the text input that allows to add the text of the proposition
            var inputTextToAdd = document.createElement('input');
            inputTextToAdd.setAttribute('type', 'text');
            inputTextToAdd.setAttribute('class', 'form-control col-10');
            inputTextToAdd.setAttribute('name', 'prop-' + lastId);
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
            group.appendChild(container);


            //Changing the text "Number of elements"
            document.querySelector('#proposition-number').innerHTML = parseInt(lastId) + 1;
        }

    }

    function removeProposition() {
        var group = document.querySelector('#proposition-group');
        var lastId = group.lastElementChild.id.split('-')[1];
        if (lastId > MIN_PROPOSITION_NUMBER) {
            var lastElement = group.lastElementChild;
            group.removeChild(lastElement);
            document.querySelector('#proposition-number').innerHTML = lastId;
        }
    }
</script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
<script defer src="https://use.fontawesome.com/releases/v5.8.1/js/all.js"
        integrity="sha384-g5uSoOSBd7KkhAMlnQILrecXvzst9TdC09/VM+pjDTCM+1il8RHz5fKANTFFb+gQ"
        crossorigin="anonymous"></script>

</html>