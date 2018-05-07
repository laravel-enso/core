<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>{{$htmlTitle or ''}}</title>


    @include('emails.partials.css')


    <!-- Originally designed by https://github.com/kaytcat -->
    <!-- Header image designed by Freepik.com -->

    @yield('css')

</head>
<body offset="0" class="body"
      style="padding:0; margin:0; display:block; background:#eeebeb; -webkit-text-size-adjust:none" bgcolor="#eeebeb">
    <table align="center" cellpadding="0" cellspacing="0" width="100%" height="100%">
    <tr>
        <td align="center" valign="top" style="background-color:#eeebeb" width="100%">

            <center>

                <table cellspacing="0" cellpadding="0" width="600" class="w320">
                    <tr>
                        <td align="center" valign="top">

                            @include('emails.partials.header')

                            <table cellspacing="0" cellpadding="0" width="100%" class="force-full-width"
                                   bgcolor="#ffffff">
                                <tr>
                                    <td style="background-color:#ffffff;">
                                        <br>
                                        <center>
                                            <table style="margin: 0 auto;" cellspacing="0" cellpadding="0" class="force-width-80">
                                                <tr>
                                                    <td style="text-align:left; color: #6f6f6f;" class="spaced-out-lines">
                                                        @yield('content')
                                                    </td>
                                                </tr>
                                            </table>
                                        </center>

                                        <table style="margin:0 auto;" cellspacing="0" cellpadding="10" width="100%">
                                            <tr>
                                                <td style="text-align:center; margin:0 auto;">
                                                    <br>
                                                    <div>
                                                        <!--[if mso]>
                                                        <v:rect xmlns:v="urn:schemas-microsoft-com:vml"
                                                                xmlns:w="urn:schemas-microsoft-com:office:word"
                                                                href="http://"
                                                                style="height:45px;v-text-anchor:middle;width:220px;"
                                                                stroke="f" fillcolor="#f5774e">
                                                            <w:anchorlock/>
                                                            <center>
                                                        <![endif]-->
                                                        @yield('buttons')
                                                        <!--[if mso]>
                                                        </center>
                                                        </v:rect>
                                                        <![endif]-->
                                                    </div>
                                                    <br>
                                                </td>
                                            </tr>
                                        </table>

                                        @include('emails.partials.footer')
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </center>
        </td>
    </tr>
</table>
</body>
</html>