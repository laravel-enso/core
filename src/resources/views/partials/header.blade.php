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
                <user-menu :store="store"></user-menu>
                <li>
                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                </li>
            </ul>
        </div>
    </nav>
</header>