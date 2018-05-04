@extends('emails.layouts.main')

@section('content')
    <table style="margin: 0 auto;" cellspacing="0" cellpadding="0" class="force-width-80">
        <tr>
            <td style="text-align:left; color: #6f6f6f;" class="spaced-out-lines">
                <br>
                {{$line1}}
                <br>
                <br>
                {{$line2}}
                <br>
                <br>
            </td>
        </tr>
    </table>
@endsection

@section('buttons')
    <a href="{{$resetURL}}" style="background-color:#f5774e;color:#ffffff;display:inline-block;font-family:'Source Sans Pro', Helvetica, Arial, sans-serif;font-size:18px;font-weight:400;line-height:45px;text-align:center;text-decoration:none;width:220px;-webkit-text-size-adjust:none;">Reset Your Password</a>
@endsection