@extends('backoffice/layout')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="md-form mt-0">
                <input class="form-control" type="text" placeholder="Rechercher" aria-label="Search">
            </div>
            <br>
            @if(session('result'))
                @if(session('result') == 1)
                    <div class="alert alert-success animated bounceInRight">
                        {{session('message')}}
                    </div>
                @endif
            @endif
        </div>
        <div class="col-12" style="text-align: center;">
            <br>
            @if(count($questions) == 0)
                <h3>Aucune question</h3>
                <br>
            @else
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Question</th>
                        <th scope="col">Points</th>
                        <th scope="col">Nombre de fois posée</th>
                        <th scope="col">Type</th>
                        <th scope="col">Catégorie</th>
                        <th scope="col">Réponses</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody id="questions-container">
                    @foreach($questions as $question)
                        <tr>
                            <th scope="row">{{$question->id}}</th>
                            <td>{{$question->label}}</td>
                            <td>{{$question->points}}</td>
                            <td>{{$question->number_of_times_asked}}</td>
                            <td>
                                <a href="/backoffice/types/{{$question->type->id}}/questions/">{{$question->type->label}}</a>
                            </td>
                            <td>
                                <a href="/backoffice/tags/{{$question->tag->id}}/questions/">{{$question->tag->label}}</a>
                            </td>
                            <td>
                                <a href="/backoffice/propositions/read/{{$question->id}}">{{count($question->propositions) }}
                                    <i
                                            class="fas fa-eye"></i></a></td>
                            <td><a href="/backoffice/questions/edit/{{$question->id}}"><i class="fas fa-edit"></i></a>
                            </td>
                            <td><a href="/backoffice/questions/delete/{{$question->id}}"><i class="fas fa-times"
                                                                                            style="color:red;"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        </div>
        <div class="col"></div>
        <div class="col-4">
            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-center">
                    {{$questions->links()}}
                </ul>
            </nav>
        </div>
        <div class="col"></div>
    </div>
@endsection

@section('scripts')
    <script>

    </script>
@endsection