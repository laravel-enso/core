<header id="main-header" class="main-header">
    <a href="#" class="logo">
        <span class="logo-mini"><img src="/images/logo_small.png"></span>
        <span class="logo-lg"><img src="/images/logo.png"></span>
    </a>
    <nav class="navbar navbar-static-top">
        <a href="#" id="sidebar-toggle" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        </a>
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                @includeIf('laravel-enso/notifications::notifications')
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle"
                        data-toggle="dropdown">
                        <img src="{{ $user->avatar_link }}"
                            class="user-image user-avatar"
                            alt="User Image">
                        <span class="hidden-xs">
                            {{ $user->first_name }}
                        </span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="user-header">
                            <img src="{{ $user->avatar_link }}"
                                class="img-square user-avatar"
                                alt="User Image">
                            <p>
                                {{ $user->first_name }}
                                <small>
                                    {{ $user->role->name }}
                                </small>
                            </p>
                            <div class="pull-left">
                                <a href="/administration/users/{{ $user->id }}"
                                    id="profile-button"
                                    class="btn btn-sm btn-default">
                                    {{ __("Profile") }}
                                </a>
                            </div>
                            <div class="pull-right">
                                <a href="/logout"
                                  class="btn btn-sm btn-default" id="logout-button"
                                  onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                  {{ __("Logout") }}
                                </a>
                            </div>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                </li>
            </ul>
        </div>
    </nav>
    <form id="logout-form" action="/logout" method="POST" style="display: none;">
        {{ csrf_field() }}
    </form>
</header>