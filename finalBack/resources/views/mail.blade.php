<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<div>
    <table class="table" border="1">
        <thead>
        <tr>
            <th colspan="4">Report</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>From</td>
            <td>{{$startDate}}</td>
            <td>To</td>
            <td>{{$endDate}}</td>
        </tr>
        <tr>
            <td>Income</td>
            <td>{{$income}}</td>
            <td>Tax</td>
            <td>{{$tax}}</td>
        </tr>
        </tbody>
    </table>
</div>
</body>
</html>
