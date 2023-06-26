<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
           with font-awesome or any other icon font library -->

        <li class="nav-item">
            <a href={{ route('admin.celebrants.index') }} class="nav-link">

                <i class="nav-icon fas fa-birthday-cake"></i>

                <p>
                    Іменинники
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href={{ route('admin.users.index') }} class="nav-link">
                <i class="nav-icon fas fa-unlock"></i>
                Адміністратори
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href={{ route('admin.greetings.index') }} class="nav-link">

                <i class="nav-icon fas fa-comment-dots"></i>

                <p>
                    Привітання від гостей
                </p>
            </a>
        </li>
    </ul>
</nav>