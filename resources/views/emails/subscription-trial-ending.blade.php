<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
    <title>{{ config('app.name') }}</title>
</head>
<body>
<p>
    <b> Hello {{ $data['name'] }}</b>
</p>
<p>
    Your subscription trial period is ending on {{$data['trial_ending_date']}}, If you don't want to continue please cancel.
</p>

</body>
</html>
