@extends('backoffice/layout')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="md-form mt-0">
                <input class="form-control" type="text" placeholder="Rechercher" aria-label="Search">
            </div>
            <br>
        </div>
        <div class="col-12">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Catégorie</th>
                    <th scope="col">Questions associées</th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody>
                @foreach($tags as $tag)
                    <tr>
                        <th scope="row">{{$tag->id}}</th>
                        <td>{{$tag->label}}</td>
                        <td><a href="/backoffice/tags/{{$tag->id}}/questions">{{count($tag->questions) }} <i
                                        class="fas fa-eye"></i></a></td>
                        <td><a href="/backoffice/tags/edit/{{$tag->id}}"><i class="fas fa-edit"></i></a></td>
                        <td><a href="/backoffice/tags/delete/{{$tag->id}}"><i class="fas fa-times"
                                                                               style="color:red;"></i></a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            @if(session('result'))
                @if(session('result') == 1)
                    <div class="alert alert-success animated bounceInRight">
                        {{session('message')}}
                    </div>
                @endif
            @endif
        </div>
        <div class="col"></div>
        <div class="col-4">
            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-center">
                    {{$tags->links()}}
                </ul>
            </nav>
        </div>
        <div class="col"></div>
    </div>
@endsection