@extends('backoffice/layout')
@section('content')
    <div class="row">
        <div class="col-12">
            @if(session('result'))
                <div class="alert alert-{{session('result') == 'success' ? 'success' : 'danger'}} animated bounceInRight">
                    {{session('message')}}
                </div>
            @endif
            @if(count($sessions) == 0)
                <h3>Aucune question</h3>
                <br>
            @else
                <table class="table table-striped" style="text-align: center;">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Libellé</th>
                        <th scope="col">Statut</th>
                        <th scope="col">Question actuelle</th>
                        <th scope="col">Question associée</th>
                        <th scope="col">Catégorie</th>
                        <th scope="col">Date de création</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($sessions as $session)
                        <tr>
                            <th scope="row">{{$session->id}}</th>
                            <td>{{$session->label}}</td>
                            @switch($session->status)
                                @case('Not started')
                                <td style="color:#3fc12e;">Pas démarrée</td>
                                @break
                                @case('Started')
                                <td style="color:#ffa319;">En cours</td>
                                @break
                                @case('Ended')
                                <td style="color:#f23535;">Terminée</td>
                                @break
                            @endswitch
                            <td>
                                {{$session->current_game_question}}
                            </td>
                            <td>
                                <a href="/backoffice/questions/{{$session->question->id}}">{{$session->question->label}}</a>
                            </td>
                            @if($session->tag == null)
                                <td>Aucune</td>
                            @else
                                <td><a href="/backoffice/tags/{{$session->tag->id}}/questions">{{$session->tag->label}}</a></td>
                            @endif
                            <td>{{$session->date_of_session}}</td>
                            <td><a href="/backoffice/sessions/{{$session->id}}/restart"><i class="fas fa-undo"
                                                                                           style="color:#a446e2;"></i></a>
                            </td>
                            <td><a href="/backoffice/sessions/edit/{{$session->id}}"><i class="fas fa-edit"></i></a>
                            </td>
                            <td><a href="/backoffice/sessions/delete/{{$session->id}}"><i class="fas fa-times"
                                                                                          style="color:red;"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
@endsection