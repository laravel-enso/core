<tr>
    <td>
        <table class="footer" align="center" width="570" cellpadding="0" cellspacing="0">
            <tr>
                <td class="content-cell" align="center">
                    <p>
                    @if(config('enso.config.facebook'))
                        <a href="{{ config('enso.config.facebook') }}"
                            style="text-decoration: unset">
                            <img src="{{ url('images/emails/facebook.svg') }}"
                                alt="facebook"
                                style="max-width: 32px">
                        </a>
                    @endif
                    @if(config('enso.config.instagram'))
                        <a href="{{ config('enso.config.instagram') }}"
                            style="text-decoration: unset">
                            <img src="{{ url('images/emails/instagram.svg') }}"
                                alt="instagram"
                                style="max-width: 32px">
                        </a>
                    @endif
                    @if(config('enso.config.twitter'))
                        <a href="{{ config('enso.config.twitter') }}"
                            style="text-decoration: unset">
                            <img src="{{ url('images/emails/twitter.svg') }}"
                                alt="twitter"
                                style="max-width: 32px">
                        </a>
                    @endif
                    @if(config('enso.config.tiktok'))
                        <a href="{{ config('enso.config.tiktok') }}"
                            style="text-decoration: unset">
                            <img src="{{ url('images/emails/tiktok.svg') }}"
                                alt="tiktok"
                                style="max-width: 32px">
                        </a>
                    @endif
                    </p> 
                    {{ Illuminate\Mail\Markdown::parse($slot) }}
                </td>
            </tr>
        </table>
    </td>
</tr>
