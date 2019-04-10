<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="{{asset('../../css/login_style.css')}}" type="text/css">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css"
          integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
<body>
<div class="wrapper fadeInDown">
    <div id="formContent">
        <!-- Tabs Titles -->

        <!-- Icon -->
        <div class="fadeIn first">
            <h3 style="margin: 6% 0 6% 0;">Connexion</h3>
        </div>

        <!-- Login Form -->
        <form action="/backoffice/login" method="post">
            @csrf
            <input type="text" id="login" class="fadeIn second {{$errors->has('username') ? 'is-invalid' : ''}}" name="username" placeholder="Nom d'utilisateur">
            @foreach($errors->get('login') as $message)
                <p class="invalid-feedback">{{$message}}</p>
            @endforeach
            <input type="password" id="password" class="fadeIn third {{$errors->has('password') ? 'is-invalid' : ''}}" name="password" placeholder="Mot de passe">
            @foreach($errors->get('password') as $message)
                <p class="invalid-feedback">{{$message}}</p>
            @endforeach
            <input type="submit" class="fadeIn fourth" value="Se connecter">
        </form>

        <!-- Remind Passowrd -->
        <div id="formFooter">
            <a class="underlineHover" href="/backoffice/register">Pas encore de compte ? S'inscrire</a>
        </div>

    </div>
</div>
</body>
</html>