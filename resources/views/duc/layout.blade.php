<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        @page {
            margin: 140px 50px 100px 50px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        header {
            position: fixed;
            top: -160px;   /* era -120px */
            left: 0;
            right: 0;
            height: 140px;
        }

        footer {
            position: fixed;
            bottom: -80px;
            left: 0;
            right: 0;
            height: 150px;
        }

        .content {
            margin-top: 10px;
        }

        
    </style>
</head>
<body>

<header>
    @include('header')
</header>

<footer>
    @include('footer')
</footer>

<div class="content">
    @yield('content')
</div>

</body>
</html>
