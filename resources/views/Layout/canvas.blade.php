<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>friendquiz</title>

    <!-- Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,400;0,500;0,600;0,700;0,800;1,600&display=swap"
        rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons" />

    <link rel="stylesheet" href="https://friendquiz.jp/public/build/assets/app.65f72412.css" /><script type="module" src="https://friendquiz.jp/public/build/assets/app.372bdf01.js"></script>

</head>

<body>

    <header>
        <nav class="navbar navbar-collapse-lg bg-nav">
            <div class="container-fluid">
                <a href="/"><img src="{{ URL::asset('/public/images/logo.png') }}" alt="" width="35" height="35"></a>
                <p class="brand-name"><span class="fw-bold">FriendQuiz フレンドクイズ</span><br> by BoxFresh</p>
                <p></p>
            </div>
        </nav>
    </header>

    <div class="container">

        @yield('content')

    </div>

    <footer>
        <div class="container">

            <div class="section-game my-0 bg-grey rounded-3" style="min-height: 190px">

                <div class="ad-section">
                    <p class="text-center fs-9 fw-regular">
                        
                    </p>
                </div>



            </div>

            <!-- <ul class="social">
                <li>
                    <a href="http://"><img src="{{ URL::asset('/images/twitter.png') }}" alt="facebook"></a>

                </li>
                <li>
                    <a href="http://"><img src="{{ URL::asset('/images/instagram.png') }}" alt="facebook"></a>

                </li>
                <li>
                    <a href="http://"><img src="{{ URL::asset('/images/facebook.png') }}" alt="facebook"></a>

                </li>
            </ul> -->

            <ul class="footer_link">
                <li>
                    <a href="https://www.app-cm.co.jp/terms/">利用規約</a>
                </li>
                <li>
                    <a href="https://www.app-cm.co.jp/privacy/">プライバシーポリシー</a>
                </li>
            </ul>

            <ul class="copyright">
                <li>
                    <p>copyright@App-CM Inc.</p>
                </li>
            </ul>
        </div>
    </footer>
</body>

</html>
