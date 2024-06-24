<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ATS Friendly CV</title>

    <style>
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.8;
            margin: 40px auto;
            max-width: 800px;
            background-color: #f8f8f8;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            color: #333;
        }

        header {
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        header h1 {
            font-size: 28px;
            margin: 0;
            color: #333;
        }

        header p {
            font-size: 16px;
            color: #666;
            margin: 4px 0;
        }

        section {
            margin-bottom: 20px;
        }

        section h2 {
            font-size: 22px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
            margin-bottom: 10px;
            color: #333;
        }

        section ul {
            list-style-type: none;
            padding: 0;
        }

        section li {
            margin-bottom: 10px;
            padding-left: 10px;
            position: relative;
        }

        section li::before {
            content: "•";
            color: #333;
            font-size: larger;
            position: absolute;
            left: 0;
        }

        strong {
            color: #333;
            font-weight: bold;
        }

        .skills li, .experience li {
            padding-left: 15px;
        }

        .skills ul {
            columns: 2;
            -webkit-columns: 2;
            -moz-columns: 2;
        }

        .skills li {
            -webkit-column-break-inside: avoid;
            page-break-inside: avoid;
            break-inside: avoid;
        }
    </style>
</head>
<body>
<header>
    <h1>{{$user->first_name.' '.$user->last_name}}</h1>
    <p>Software Developer | Web Designer</p>
    <p>Email: {{$user->email}} | Phone: {{$user->phone}}</p>
</header>

<section class="education">
    <h2>Education</h2>
    <ul>
    @foreach($user->education as $education)
            @if($education->type === 'university')
                <li>
                    <strong>{{$education->title}}</strong> - {{$education->name}}
                    ({{\Illuminate\Support\Carbon::parse($education->start_date)->format('Y')}} -
                    @if(\Illuminate\Support\Carbon::parse($education->end_date)->format('Y') == now()->format('Y'))
                        Present)
                    @else
                        {{\Illuminate\Support\Carbon::parse($education->end_date)->format('Y')}}
                    @endif
                </li>
            @else
        <li><strong>{{$education->title}}</strong> - {{$education->name}} ({{\Illuminate\Support\Carbon::parse($education->start_date)->format('Y')}} - {{\Illuminate\Support\Carbon::parse($education->end_date)->format('Y')}})</li>

            @endif

    @endforeach
    </ul>
</section>

<section class="experience">
    <h2>Professional Experience</h2>
    <ul>
        @foreach($user->experience as $experience)
                <strong>{{$experience->position}}</strong> - {{$experience->name}} ({{\Illuminate\Support\Carbon::parse($experience->start_date)->format('Y')}}-{{\Illuminate\Support\Carbon::parse($education->end_date)->format('Y') == now()->format('Y')?'present':\Illuminate\Support\Carbon::parse($education->end_date)->format('Y')}})

                    {!! $experience->details !!}


        @endforeach

    </ul>
</section>

<section class="skills">
    <h2>Skills</h2>
    <ul>
        <li>Java, JavaScript, Python</li>
        <li>HTML, CSS, React, Vue.js</li>
        <li>SQL, NoSQL</li>
        <li>Version Control/Git</li>
    </ul>
</section>

</body>
</html>
