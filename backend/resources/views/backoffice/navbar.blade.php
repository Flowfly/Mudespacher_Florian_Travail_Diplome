<nav class="col-xl-1 col-lg-2 col-md-2 col-sm-2 col-xs-2 nav">
    <div class="row nav">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a href="/backoffice" class="nav-link"><i class="fas fa-home navigation-link"></i> Accueil</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                   aria-expanded="false"><i class="fas fa-question navigation-link"></i> Questions</a>
                <div class="dropdown-menu">
                    <a href="/backoffice/questions" class="dropdown-item navigation-link"><i class="fas fa-eye"></i> Voir</a>
                    @if(auth()->check())
                        @if(auth()->user()->role_id == 3)
                            <a href="/backoffice/questions/add" class="dropdown-item navigation-link"><i class="fas fa-plus"></i>
                                Ajouter</a>
                        @endif
                    @endif
                </div>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                   aria-expanded="false"><i class="fas fa-tags navigation-link"></i> Catégories</a>
                <div class="dropdown-menu">
                    <a href="/backoffice/tags" class="dropdown-item"><i class="fas fa-eye navigation-link"></i> Voir</a>
                    @if(auth()->check())
                        @if(auth()->user()->role_id == 3)
                            <a href="/backoffice/tags/add" class="dropdown-item"><i class="fas fa-plus navigation-link"></i> Ajouter</a>
                        @endif
                    @endif
                </div>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                   aria-expanded="false"><i class="fas fa-stream navigation-link"></i> Types</a>
                <div class="dropdown-menu">
                    <a href="/backoffice/types" class="dropdown-item"><i class="fas fa-eye navigation-link"></i> Voir</a>
                    @if(auth()->check())
                        @if(auth()->user()->role_id == 3)
                            <a href="/backoffice/types/add" class="dropdown-item navigation-link"><i class="fas fa-plus"></i>
                                Ajouter</a>
                        @endif
                    @endif
                </div>
            </li>

            <li class="nav-item">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                   aria-expanded="false"><i class="fas fa-user navigation-link"></i> Utilisateurs</a>
                <div class="dropdown-menu">
                    <a href="/backoffice/users" class="dropdown-item navigation-link"><i class="fas fa-eye"></i> Voir</a>
                    @if(auth()->check())
                        @if(auth()->user()->role_id == 3)
                            <a href="/backoffice/users/add" class="dropdown-item navigation-link"><i class="fas fa-plus"></i>
                                Ajouter</a>
                        @endif
                    @endif
                </div>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                   aria-expanded="false"><i class="fas fa-users navigation-link"></i> Équipes</a>
                <div class="dropdown-menu">
                    <a href="/backoffice/teams" class="dropdown-item"><i class="fas fa-eye navigation-link"></i> Voir</a>
                    @if(auth()->check())
                        @if(auth()->user()->role_id == 3)
                            <a href="/backoffice/teams/add" class="dropdown-item"><i class="fas fa-plus navigation-link"></i>
                                Ajouter</a>
                        @endif
                    @endif
                </div>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                   aria-expanded="false"><i class="fas fa-spinner fa-spin navigation-link"></i> Sessions</a>
                <div class="dropdown-menu">
                    <a href="/backoffice/sessions" class="dropdown-item"><i class="fas fa-eye navigation-link"></i> Voir</a>
                    @if(auth()->check())
                        @if(auth()->user()->role_id == 3)
                            <a href="/backoffice/sessions/add" class="dropdown-item"><i class="fas fa-plus navigation-link"></i>
                                Ajouter</a>
                        @endif
                    @endif
                </div>
            </li>
            <li class="nav-item">
                <a href="/backoffice/theme" class="nav-link" role="button" aria-haspopup="true"
                   aria-expanded="false"><i class="fas fa-palette navigation-link"></i> Apparence</a>
            </li>
        </ul>

    </div>

</nav>