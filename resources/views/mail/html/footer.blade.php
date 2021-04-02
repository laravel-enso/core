<tr>
    <td>
        <table class="footer" align="center" width="570" cellpadding="0" cellspacing="0">
            <tr>
                <td class="content-cell" align="center">
                    <p>
                    @if(config('enso.config.facebook'))
                        <a href="{{ config('enso.config.facebook') }}">
                            <img src="{{ url('images/emails/facebook.png') }}" alt="facebook">
                        </a>
                    @endif
                    @if(config('enso.config.instagram'))
                        <a href="{{ config('enso.config.facebook') }}">
                            <img src="{{ url('images/emails/instagram.png') }}" alt="instagram">
                        </a>
                    @endif
                    @if(config('enso.config.googleplus'))
                        <a href="{{ config('enso.config.googleplus') }}">
                            <img src="{{ url('images/emails/googleplus.png') }}" alt="googleplus">
                        </a>
                    @endif
                    @if(config('enso.config.twitter'))
                        <a href="{{ config('enso.config.twitter') }}">
                            <img src="{{ url('images/emails/twitter.png') }}" alt="twitter">
                        </a>
                    @endif
                    </p> 
                    {{ Illuminate\Mail\Markdown::parse($slot) }}
                </td>
            </tr>
        </table>
    </td>
</tr>
