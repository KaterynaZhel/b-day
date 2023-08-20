<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
           with font-awesome or any other icon font library -->
        <li class="nav-item">
            <a href={{ route('admin.celebrants.nearestCelebrants') }} class="nav-link" style="padding-left: 0.4rem">

                <i class="nav-iconn fas fa-solid fa-gift"></i>

                <p style="padding-left: 0.4rem"></p>
                Найближчі іменинники
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href={{ route('admin.celebrants.index') }} class="nav-link" style="padding-left: 0.1rem">

                <i class="nav-icon fas fa-birthday-cake"></i>

                <p>
                    Іменинники
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href={{ route('admin.users.index') }} class="nav-link" style="padding-left: 0.1rem">
                <i class="nav-icon fas fa-unlock"></i>
                Менеджери
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href={{ route('admin.greetings.index') }} class="nav-link" style="padding-left: 0.1rem">

                <i class="nav-icon far fa-comments"></i>

                <p>
                    Привітання від гостей
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href={{ route('admin.mainGreetingsCompany.index') }} class="nav-link" style="padding-left: 0.1rem">

                <i class="nav-icon fas fa-comment-dots"></i>

                <p>
                    Привітання від компаній
                </p>
            </a>
        </li>
    </ul>
</nav>