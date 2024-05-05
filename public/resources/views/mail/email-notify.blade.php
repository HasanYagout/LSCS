<!doctype html>
<html lang="en-US">

<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
    <title>{{ __('Email Template') }}</title>
    <meta name="description" content="{{ __('Email Template') }}.">
    <link rel="stylesheet" href="">
</head>

<body>
    <div>
        <table cellspacing="0">
            <tr>
                <td>
                    <table cellpadding="0" cellspacing="0">
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>
                                <a href="{{env('APP_URL')}}" title="{{ __('logo') }}" target="_blank">
                                    <img src="{{getFileUrl(getOption('app_logo'))}}"/>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>
                                <table cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            {!! getEmailTemplate($template, 'body', $link??NULL, $customData??NULL, $userData) !!}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>
                    @if(getOption('app_copyright') !=null)
                        <p> <strong>{{getOption('app_copyright')}}</strong> </p>
                    @endif
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>
        </table>
    </div>
</body>

</html>
