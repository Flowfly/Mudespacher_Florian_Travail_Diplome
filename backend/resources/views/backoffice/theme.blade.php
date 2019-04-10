@extends('backoffice/layout')
@section('content')
<div class="row" style="text-align: center;">
    <div class="col-12">
        <form action="" style="display: flex;">
            @csrf
            <div class="col-3">
                <div class="hcenter">
                    <h4>Changer le background :</h4>
                </div>
            </div>
            <div class="col-3">
                <div class="hcenter">
                    <input type="file">
                    <small class="form-text text-muted">Image de fond utilisée pour le quiz</small>
                </div>
            </div>
            <div class="col-3">
                    <div>
                        <span>Image actuelle :</span>
                     <img src="{{asset('../../img/background.png')}}" alt="background" class="rounded preview">
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
        <form action="" style="display: flex;">
            @csrf
            <div class="col-3">
                <div class="hcenter">
                    <h4>Changer le fond de la réponse 1</h4>
                </div>
            </div>
            <div class="col-3">
                <div class="hcenter">
                    <input type="file">
                    <small class="form-text text-muted">Image de fond utilisée pour la réponse 1</small>
                </div>
            </div>
            <div class="col-3">
                <div>
                    <span>Image actuelle :</span>
                    <img src="{{asset('../../img/button.png')}}" alt="background" class="rounded preview" style="width:200px;">
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
        <form action="" style="display: flex;">
            @csrf
            <div class="col-3">
                <div class="hcenter">
                    <h4>Changer le fond de la réponse 2</h4>
                </div>
            </div>
            <div class="col-3">
                <div class="hcenter">
                    <input type="file">
                    <small class="form-text text-muted">Image de fond utilisée pour la réponse 2</small>
                </div>
            </div>
            <div class="col-3">
                <div>
                    <span>Image actuelle :</span>
                    <img src="{{asset('../../img/button.png')}}" alt="background" class="rounded preview" style="width:200px;">
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
        <form action="" style="display: flex;">
            @csrf
            <div class="col-3">
                <div class="hcenter">
                    <h4>Changer le fond de la réponse 3</h4>
                </div>
            </div>
            <div class="col-3">
                <div class="hcenter">
                    <input type="file">
                    <small class="form-text text-muted">Image de fond utilisée pour la réponse 3</small>
                </div>
            </div>
            <div class="col-3">
                <div>
                    <span>Image actuelle :</span>
                    <img src="{{asset('../../img/button.png')}}" alt="background" class="rounded preview" style="width:200px;">
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
        <form action="" style="display: flex;">
            @csrf
            <div class="col-3">
                <div class="hcenter">
                    <h4>Changer le fond de la réponse 4</h4>
                </div>
            </div>
            <div class="col-3">
                <div class="hcenter">
                    <input type="file">
                    <small class="form-text text-muted">Image de fond utilisée pour la réponse 4</small>
                </div>
            </div>
            <div class="col-3">
                <div>
                    <span>Image actuelle :</span>
                    <img src="{{asset('../../img/button.png')}}" alt="background" class="rounded preview" style="width:200px;">
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