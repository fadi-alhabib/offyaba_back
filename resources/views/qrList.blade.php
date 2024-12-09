<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>List of QR codes</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            /*box-sizing: border-box;*/
        }

        .main {
            justify-content: center;
            align-items: center;
            margin-top: 10px;
            display: grid;
            margin-left: 15px;
        }

        img {
            width: 200px;
            height: 200px;
            object-fit: cover;
            object-position: center;
            margin-left: 40px;
            margin-top: 40px;
        }

        h1 {
            text-align: center;
            padding: 40px;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
<div><h1>Off Yaba</h1></div>
<div class="main">
    @foreach($arr as $ar)
        <img
            src="data:image/png;base64, {!!base64_encode( QrCode::format('svg')->size(200)->errorCorrection('H')->generate($ar))!!}">
        @if($loop->iteration%12==0)
            <div style="padding: 20px"></div>
            <div><h1>Off Yaba</h1></div>
        @endif
    @endforeach
</div>
</body>
</html>
