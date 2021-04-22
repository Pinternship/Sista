@component('mail::message')
# Internship application notification

Your internship application to {{$job->job_title}} has been accepted

<!-- @component('mail::button', ['url' => ''])
Button Text
@endcomponent -->

Thank you for using SISTA<br>
{{ config('app.name') }}

Made with ❤️ SISTA Teams
@endcomponent
