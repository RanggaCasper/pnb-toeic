@extends('layouts.mail')

@section('content')
<td align="center" style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly;">
    <table style="width: 100%;" cellpadding="0" cellspacing="0" role="presentation">
        <tr>
            <td class="sm-px-24"
                style="mso-line-height-rule: exactly; border-radius: 4px; background-color: #ffffff; padding: 24px; text-align: left; font-family: Montserrat, -apple-system, 'Segoe UI', sans-serif; font-size: 16px; line-height: 24px; color: #626262;">
                <p
                    style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly; margin-bottom: 0; font-size: 16px; font-weight: 600;">
                    Hi,</p>
                <p
                    style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly; margin-top: 0; font-size: 16px; font-weight: 700; color: #0099ff;">
                    {{ $result['email'] }}</p>
                <p
                    style="font-family: 'Montserrat', sans-serif; font-size: 12px; mso-line-height-rule: exactly; margin: 0; margin-bottom: 8px;">
                    Please use the unique code below to reset your password. It is valid until {{ $result['expired_at'] }} WIB.
                </p>
                <hr style="border-top:dashed 1px">
                <b
                    style="text-align: center; font-family: 'Montserrat', sans-serif; font-size: 16px; mso-line-height-rule: exactly; margin: 0;">
                    {{ $result['token'] }}
                </b>
                <hr style="border-top:dashed 1px">
                <p
                    style="font-family: 'Montserrat', sans-serif; font-size: 12px; mso-line-height-rule: exactly; margin: 0; margin-bottom: 8px;">
                    Thank you for the trust you have placed in us. If you did not initiate this password reset, please disregard this email.
                </p>
                <p
                    style="font-family: 'Montserrat', sans-serif; font-size: 12px; mso-line-height-rule: exactly; margin: 0; margin-bottom: 8px;">
                    Support, <br style="text-transform: uppercase;"><b>{{ config('app.name') }}.</b></p>
                <hr style="border-top:dashed 1px">
                <p
                    style="font-family: 'Montserrat', sans-serif; font-size: 12px; mso-line-height-rule: exactly; margin: 0; margin-bottom: 8px;">
                    Website : <a href="{{ route('home') }}">{{ route('home') }}</a>
                    <br>
                </p>
            </td>
        </tr>
        <tr>
            <td
                style="font-family: 'Montserrat', sans-serif; font-size: 12px; mso-line-height-rule: exactly; height: 8px;">
            </td>
        </tr>
    </table>
</td>
@endsection