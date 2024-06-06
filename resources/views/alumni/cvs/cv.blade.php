<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CV</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        body {
            font-size: 14px;
        }
        .container {
            display: flex;
        }
        .left, .right {
            padding: 20px;
        }
        .left {
            width: 35%;
            background-color: #002a5c;
            color: white;
            padding: 20px;
        }
        .right {
            width: 65%;
            background-color: #f1a527;
            padding: 20px;
        }
        .left h1 {
            font-size: 30px;
            margin-bottom: 10px;
        }
        .left h2 {
            font-size: 20px;
            margin-bottom: 5px;
        }
        .left p, .right p {
            margin-bottom: 10px;
        }
        .left hr {
            border: 1px solid white;
            margin: 10px 0;
        }
        .section-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .experience-item, .education-item, .language-item {
            margin-bottom: 10px;
        }
        .experience-item span, .education-item span, .language-item span {
            display: block;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="left">
        <h1>{{$cv->first_name}} {{$cv->last_name}}</h1>
        <hr>
        <h2>Contact Info</h2>
        <p>Phone: {{$cv->phone}}</p>
        <p>Email: {{$cv->email}}</p>
        <p>Address: {{$cv->address}}</p>
        <hr>
        <h2>Education</h2>
        @foreach(json_decode($cv->education) as $education)
            <div class="education-item">
                <span>{{$education->start_date}} - {{$education->end_date}}</span>
                <span>{{$education->title}}</span>
                <span>{{$education->name}}</span>
            </div>
        @endforeach
        <hr>
        <h2>Languages</h2>
        @foreach(json_decode($cv->languages) as $language)
            <div class="language-item">
                <span>{{$language->name}}</span>
                <span>{{$language->level}}</span>
            </div>
        @endforeach
    </div>
    <div class="right">
        <div class="section-title">Profile</div>
        <p>{!! $cv->profile !!}</p>
        <hr>
        <div class="section-title">Experience</div>
        @foreach(json_decode($cv->experience) as $experience)
            <div class="experience-item">
                <span>{{$experience->start_date}} - {{$experience->end_date}}</span>
                <span>{{$experience->company}}</span>
                <span>{{$experience->position}}</span>
                <span>{{$experience->details}}</span>
            </div>
        @endforeach
    </div>
{{--    {{dd('dsadsa')}}--}}
</div>
</body>
</html>
