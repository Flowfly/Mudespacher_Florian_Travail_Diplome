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
            <h3 style="margin: 6% 0 6% 0;">Inscription</h3>
        </div>

        <!-- Login Form -->
        <form action="/backoffice/register" method="post">
            @csrf
            <input type="text" id="login" class="fadeIn second {{$errors->has('username') ? 'is-invalid' : ''}}" name="username" placeholder="Nom d'utilisateur" value="{{old('username')}}">
            @foreach($errors->get('username') as $message)
                <p style="color:#db1313;">{{$message}}</p>
            @endforeach
            <input type="password" id="password" class="fadeIn third {{$errors->has('password') ? 'is-invalid' : ''}}" name="password" placeholder="Mot de passe">
            @foreach($errors->get('password') as $message)
                <p style="color:#db1313;">{{$message}}</p>
            @endforeach
            <input type="password" id="password" class="fadeIn third {{$errors->has('password_confirmation') ? 'is-invalid' : ''}}" name="password_confirmation"
                   placeholder="Confirmer le mot de passe">
            <input type="submit" class="fadeIn fourth" value="S'inscrire">
        </form>

        <!-- Remind Passowrd -->
        <div id="formFooter">
            <a class="underlineHover" href="/backoffice/login">Déjà un compte ? Se connecter</a>
        </div>

    </div>
</div>
</body>
</html>