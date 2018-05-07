<table style="margin:0 auto;" cellspacing="0" cellpadding="0" width="100%">
    <tr>
        <td style="text-align: center;">
            @include('emails.partials.logo')
        </td>
    </tr>
</table>

<table cellspacing="0" cellpadding="0" width="100%" style="background-color:#3bcdb0;">
    <tr>
        <td style="background-color:#3bcdb0;">

            <table cellspacing="0" cellpadding="0" width="100%">
                <tr>
                    <td style="font-size:40px; font-weight: 600; color: #ffffff; text-align:center;" class="mobile-spacing">
                        <div class="mobile-br">&nbsp;</div>
                        {{$title or ''}}
                        <br>
                    </td>
                </tr>
                <tr>
                    <td style="font-size:24px; text-align:center; padding: 0 75px; color:#6f6f6f;" class="w320 mobile-spacing; ">
                        {{$subtitle or ''}}
                    </td>
                </tr>
            </table>

            <table cellspacing="0" cellpadding="0" width="100%">
                <tr>
                    <td>
                        <img src="{{Config::get('app.url')}}/images/emails/background.gif" style="max-width:100%; display:block;">
                    </td>
                </tr>
            </table>

        </td>
    </tr>
</table>