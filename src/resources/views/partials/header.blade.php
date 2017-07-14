<header id="main-header" class="main-header">
    <a href="#" class="logo">
        <span class="logo-mini">
            <img style="height:30px"
                src="/images/logo.svg">
        </span>
        <span class="logo-lg">
            <img style="height:40px"
                src="/images/logo.svg"> {{ config('app.name') }}
        </span>
    </a>
    <nav class="navbar navbar-static-top">
        <a href="#" id="sidebar-toggle" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        </a>
        <a href="#">
            @includeIf('laravel-enso/core::partials.env')
        </a>
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                @includeIf('laravel-enso/notifications::notifications')
                <user-menu></user-menu>
                <li>
                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                </li>
            </ul>
        </div>
    </nav>
</header>