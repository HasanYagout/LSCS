
<html>
<head>
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif;
    }
</style>
</head>
<body>


<htmlpageheader name="myheader">
{{--<table width="100%">--}}
{{--<tr>--}}
{{--<td width="50%" style="color:#0000BB; "><span style="font-weight: bold; font-size: 14pt;">Acme Trading Co.</span><br />123 Anystreet<br />Your City<br />GD12 4LP<br /><span style="font-family:dejavusanscondensed;">&#9742;</span> 01777 123 567</td>--}}
{{--<td width="50%" style="text-align: right;">Invoice No.<br /><span style="font-weight: bold; font-size: 12pt;">0012345</span></td>--}}
{{--</tr>--}}
{{--</table>--}}
</htmlpageheader>

<htmlpagefooter name="myfooter">
{{--<div style="border-top: 1px solid #000000; font-size: 9pt; text-align: center; padding-top: 3mm; ">--}}
{{--Page {PAGENO} of {nb}--}}
{{--</div>--}}
</htmlpagefooter>

<sethtmlpageheader name="myheader" value="on" show-this-page="1" />
<sethtmlpagefooter name="myfooter" value="on" />



<table width="100%" style="font-family: serif;" cellpadding="10">
    <tr>
        <td width="30%" style="border: 0.1mm solid #888888;background-color: #003147 ">
            <table  style="font-family: serif; " cellpadding="10">
                <tr style="width: 100%">
                <tr>
                    <td>
                        <span style="font-size: 50px; color: white">{{$cv->first_name}}<br>{{$cv->last_name}}</span>
                    </td>
                    <hr>
                </tr>
                <tr>
                    <td><span style="font-size: 30px; color: white; font-weight: bold">
                            Contact Info
                        </span>
                    </td>
                </tr>
                <tr>
                    <td>Phone:
                        <span>{{$cv->phone}}</span></td>
                </tr>
                <tr>
                    <td>Email:
                        <i class="fas fa-envelope"></i>
                        <i class="fas fa-envelope"></i>
                        <i class="fas fa-envelope"></i>

                        <span>{{$cv->email}}</span></td>

                </tr>
                <tr>
                    <td>Address:
                    {{$cv->address}}</td>
                </tr>

                <tr>
                    <td style="color: white; font-weight: bold">Education</td>
                </tr>
                @foreach(json_decode($cv->education) as $education)
                    <tr style="margin: 0; padding: 0">
                        <td style="margin: 0; padding: 0">{{$education->start_date.' -- '.$education->end_date}}</td>
                    </tr>

                    <tr style="margin: 0; padding: 0">
                        <td style="margin: 0; padding: 0">{{$education->title}}</td>
                    </tr>
                    <tr style="margin: 0; padding: 0">
                        <td style="margin: 0; padding: 0">{{$education->name}}</td>
                    </tr>

                @endforeach
                <tr>
                    <td style="color: white; font-weight: bold">Language</td>
                </tr>
                @foreach(json_decode($cv->languages) as $language)

                    <tr style="margin: 0; padding: 0">
                        <td style="margin: 0; padding: 0">{{$language->name}}</td>

                    </tr>

                    <tr style="margin: 0; padding: 0">
                        <td style="margin: 0; padding: 0">{{$language->level}}</td>
                    </tr>


                @endforeach



            </table>
    </td>
        <td width="45%" style="border: 0.1mm solid #888888;">
            <table>
                <tr>
                    <td>Profile</td>
                </tr>
                <tr>
                    {!! $cv->profile !!}
                </tr>

                <tr>
                    <li>
                        Experience
                    </li>
                </tr>
                <table>
                        @foreach(json_decode($cv->experience) as $experience)
                    <tr>
                            <td>
                                {{$experience->start_date.' -- '.$experience->end_date}}<br>
                                <span>{{$experience->company}}</span>
                                {{$experience->position}}<br>
                                <span>{{$experience->details}}</span>
                            </td>

                    </tr>
                        @endforeach

{{dd('adaad')}}

                </table>

            </table>
        </td>
    </tr>

</table>
</body>
</html>
