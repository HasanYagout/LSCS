@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="fs-6 fw-400 lh-28 text-para-color border border-3 border border-dark p-30">
        <h1>Terms and Conditions</h1>
        <p>Last updated: {{now()->toDateString()}}</p>

        <h2>Introduction</h2>
        <p>Welcome to the website of Lebanese International University ("we", "our", "us"). By accessing or using our website, you agree to comply with and be bound by these Terms and Conditions.</p>

        <h2>Use of Our Website</h2>
        <p>You agree to use our website only for lawful purposes. You must not use our website in any way that breaches any applicable local, national, or international law or regulation.</p>

        <h2>Intellectual Property</h2>
        <p>All content on our website, including text, graphics, logos, and images, is the property of Lebanese International University and is protected by copyright and other intellectual property laws. You may not use, reproduce, or distribute any content without our prior written permission.</p>

        <h2>Limitation of Liability</h2>
        <p>We will not be liable for any loss or damage arising from your use of our website. This includes, but is not limited to, direct, indirect, incidental, punitive, and consequential damages.</p>

        <h2>Changes to These Terms</h2>
        <p>We reserve the right to amend these Terms and Conditions at any time. Your continued use of our website after any changes indicates your acceptance of the new terms.</p>

        <h2>Governing Law</h2>
        <p>These Terms and Conditions are governed by and construed in accordance with the laws of Lebanon. You agree to submit to the exclusive jurisdiction of the courts located in Lebanon for any disputes arising out of or relating to these Terms and Conditions or your use of our website.</p>

        <h2>Contact Us</h2>
        <p>If you have any questions about these Terms and Conditions, please contact us at info@liu.edu.lb.</p>
        </div>
    </div>
@endsection
