@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="fs-6 fw-400 lh-28 text-para-color border border-3 border border-dark p-30">
        <h1>Cookie Policy</h1>
        <p>Last updated: {{now()->toDateString()}}</p>
        <h2>Introduction</h2>
        <p>Lebanese International University ("we", "our", "us") uses cookies on our website. By using our website, you consent to the use of cookies.</p>

        <h2>What are Cookies?</h2>
        <p>Cookies are small text files that are stored on your device (computer, tablet, or mobile) when you visit a website. They help the website remember your preferences and improve your user experience.</p>

        <h2>How We Use Cookies</h2>
        <p>We use cookies to understand how you interact with our website, to improve our services, and to provide a better user experience. We may also use cookies for security purposes.</p>

        <h2>Types of Cookies We Use</h2>
        <p>We use both session cookies (which expire once you close your web browser) and persistent cookies (which stay on your device until you delete them). The cookies we use fall into the following categories:</p>
        <ul>
            <li><strong>Essential Cookies:</strong> These are necessary for the website to function and cannot be switched off in our systems.</li>
            <li><strong>Performance Cookies:</strong> These cookies help us understand how visitors interact with our website by providing information about the areas visited, time spent on the website, and any issues encountered.</li>
            <li><strong>Functional Cookies:</strong> These cookies allow our website to remember choices you make and provide more personal features.</li>
        </ul>

        <h2>Managing Cookies</h2>
        <p>You can manage your cookie preferences through your web browser settings. Please note that if you disable cookies, some features of our website may not function properly.</p>

        <h2>Contact Us</h2>
        <p>If you have any questions about our use of cookies, please contact us at info@liu.edu.lb.</p>
        </div>
    </div>
@endsection
