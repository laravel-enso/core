<footer id="main-footer" class="main-footer">
    <div class="pull-right hidden-xs">
        <b>
            {{ __("ver") }}
        </b>
        {{ __("1.0") }}
    </div>
    <strong>
        {{ __("Copyright © 2016") }}
        <a href="{{ env('APP_URL') }}">
            {{ config('app.name') }}
        </a>
    </strong>
    {{ __("All rights reserved.") }}
</footer>