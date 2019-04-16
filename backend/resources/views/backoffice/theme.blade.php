@extends('backoffice/layout')
@section('content')
<div class="row" style="text-align: center;">
    <div class="col-12">
        @if(session('result'))
            <div class="alert alert-{{session('result') == 'success' ? 'success' : 'danger'}} animated bounceInRight">
                {{session('message')}}
            </div>
        @endif
        <form action="/backoffice/update-image" method="post" style="display: flex;" enctype="multipart/form-data">
            @csrf
            <div class="col-3">
                <div class="hcenter">
                    <h4>Changer le background :</h4>
                </div>
            </div>
            <div class="col-3">
                <div class="hcenter">
                    <input type="hidden" name="imageName" value="background">
                    <input type="file" required name="image" accept="image/png">
                    <small class="form-text text-muted">Image de fond utilisée pour le quiz</small>
                </div>
            </div>
            <div class="col-3">
                    <div>
                        <span>Image actuelle :</span>
                     <img src="{{asset('../../img/quiz/background.png')}}" alt="background" class="rounded preview" style="width:10vw;">
                    </div>
            </div>
            <div class="col-3">
                <div class="hcenter">
                    <button class="btn btn-primary">Changer</button>
                </div>

            </div>
        </form>
        <hr>
    </div>
    <div class="col-12">
        <form action="/backoffice/update-image" method="post" style="display: flex;" enctype="multipart/form-data">
            @csrf
            <div class="col-3">
                <div class="hcenter">
                    <h4>Changer le fond de la réponse 1</h4>
                </div>
            </div>
            <div class="col-3">
                <div class="hcenter">
                    <input type="hidden" name="imageName" value="answer1">
                    <input type="file" required name="image" accept="image/png">
                    <small class="form-text text-muted">Image de fond utilisée pour la réponse 1</small>
                </div>
            </div>
            <div class="col-3">
                <div>
                    <span>Image actuelle :</span>
                    <img src="{{asset('../../img/quiz/answer1.png')}}" alt="background" class="rounded preview" style="width:200px;">
                </div>
            </div>
            <div class="col-3">
                <div class="hcenter">
                    <button class="btn btn-primary">Changer</button>
                </div>
            </div>
        </form>
        <hr>
    </div>
    <div class="col-12">
        <form action="/backoffice/update-image" method="post" style="display: flex;" enctype="multipart/form-data">
            @csrf
            <div class="col-3">
                <div class="hcenter">
                    <h4>Changer le fond de la réponse 2</h4>
                </div>
            </div>
            <div class="col-3">
                <div class="hcenter">
                    <input type="hidden" name="imageName" value="answer2">
                    <input type="file" required name="image" accept="image/png">
                    <small class="form-text text-muted">Image de fond utilisée pour la réponse 2</small>
                </div>
            </div>
            <div class="col-3">
                <div>
                    <span>Image actuelle :</span>
                    <img src="{{asset('../../img/quiz/answer2.png')}}" alt="background" class="rounded preview" style="width:200px;">
                </div>
            </div>
            <div class="col-3">
                <div class="hcenter">
                    <button class="btn btn-primary">Changer</button>
                </div>
            </div>
        </form>
        <hr>
    </div>
    <div class="col-12">
        <form action="/backoffice/update-image" method="post" style="display: flex;" enctype="multipart/form-data">
            @csrf
            <div class="col-3">
                <div class="hcenter">
                    <h4>Changer le fond de la réponse 3</h4>
                </div>
            </div>
            <div class="col-3">
                <div class="hcenter">
                    <input type="hidden" name="imageName" value="answer3">
                    <input type="file" required name="image" accept="image/png">
                    <small class="form-text text-muted">Image de fond utilisée pour la réponse 3</small>
                </div>
            </div>
            <div class="col-3">
                <div>
                    <span>Image actuelle :</span>
                    <img src="{{asset('../../img/quiz/answer3.png')}}" alt="background" class="rounded preview" style="width:200px;">
                </div>
            </div>
            <div class="col-3">
                <div class="hcenter">
                    <button class="btn btn-primary">Changer</button>
                </div>
            </div>
        </form>
        <hr>
    </div>
    <div class="col-12">
        <form action="/backoffice/update-image" method="post" style="display: flex;" enctype="multipart/form-data">
            @csrf
            <div class="col-3">
                <div class="hcenter">
                    <h4>Changer le fond de la réponse 4</h4>
                </div>
            </div>
            <div class="col-3">
                <div class="hcenter">
                    <input type="hidden" name="imageName" value="answer4">
                    <input type="file" required name="image" accept="image/png">
                    <small class="form-text text-muted">Image de fond utilisée pour la réponse 4</small>
                </div>
            </div>
            <div class="col-3">
                <div>
                    <span>Image actuelle :</span>
                    <img src="{{asset('../../img/quiz/answer4.png')}}" alt="background" class="rounded preview" style="width:200px;">
                </div>
            </div>
            <div class="col-3">
                <div class="hcenter">
                    <button class="btn btn-primary">Changer</button>
                </div>
            </div>
        </form>
        <hr>
    </div>
    <div class="col-12">
        <form action="/backoffice/update-image" method="post" style="display: flex;" enctype="multipart/form-data">
            @csrf
            <div class="col-3">
                <div class="hcenter">
                    <h4>Changer le fond d'une réponse erronée</h4>
                </div>
            </div>
            <div class="col-3">
                <div class="hcenter">
                    <input type="hidden" name="imageName" value="answer_error">
                    <input type="file" required name="image" accept="image/png">
                    <small class="form-text text-muted">Image de fond utilisée pour une réponse erronée</small>
                </div>
            </div>
            <div class="col-3">
                <div>
                    <span>Image actuelle :</span>
                    <img src="{{asset('../../img/quiz/answer_error.png')}}" alt="background" class="rounded preview" style="width:200px;">
                </div>
            </div>
            <div class="col-3">
                <div class="hcenter">
                    <button class="btn btn-primary">Changer</button>
                </div>
            </div>
        </form>
        <hr>
    </div>
    <div class="col-12">
        <form action="/backoffice/update-image" method="post" style="display: flex;" enctype="multipart/form-data">
            @csrf
            <div class="col-3">
                <div class="hcenter">
                    <h4>Changer le fond d'une réponse correcte</h4>
                </div>
            </div>
            <div class="col-3">
                <div class="hcenter">
                    <input type="hidden" name="imageName" value="answer_success">
                    <input type="file" required name="image" accept="image/png">
                    <small class="form-text text-muted">Image de fond utilisée pour une réponse correcte</small>
                </div>
            </div>
            <div class="col-3">
                <div>
                    <span>Image actuelle :</span>
                    <img src="{{asset('../../img/quiz/answer_success.png')}}" alt="background" class="rounded preview" style="width:200px;">
                </div>
            </div>
            <div class="col-3">
                <div class="hcenter">
                    <button class="btn btn-primary">Changer</button>
                </div>
            </div>
        </form>
        <hr>
    </div>
</div>
@endsection