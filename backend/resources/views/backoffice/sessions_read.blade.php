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
                        <th scope="col">Status</th>
                        <th scope="col">Question actuelle</th>
                        <th scope="col">Question associée</th>
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
                                <td><i class="fas fa-stop-circle" style="color:#db3434;"></i></td>
                                @break
                                @case('Started')
                                <td><i class="fas fa-spinner fa-spin" style="color:#f9a54a;"></i></td>
                                @break
                                @case('Ended')
                                <td><i class="fas fa-check-circle" style="color: #35cc5a;"></i></td>
                                @break
                            @endswitch
                            <td>
                                {{$session->current_game_question}}
                            </td>
                            <td>
                                <a href="/backoffice/questions/{{$session->question->id}}">{{$session->question->label}}</a>
                            </td>
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