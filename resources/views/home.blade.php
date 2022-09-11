<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-neutral-content">
    {{-- Navbar--}}
    <div class="navbar bg-base-100">
        <div class="flex-1">
            <a class="btn btn-ghost upper-case text-xl">
                <x-icons.logo class="mr-3"/>
                 Interstartas
            </a>
        </div>
        <div class="flex-none">
            <ul class="menu menu-horizontal p-0">
                <li>
                    <a>About Us</a>
                </li>
                <li>
                    <a href="{{route('login')}}">Forum</a>
                </li>
            </ul>
        </div>
    </div>

    {{-- HERO 1 --}}
    <div class="hero h-96 w-auto rounded m-20 drop-shadow-xl"
         style="background-image: url({{url('/images/hero-1.jpg')}});
            background-position: bottom;">
        <div class="hero-overlay bg-opacity-60"></div>
        <div class="hero-content text-center text-neutral-content">
            <div class="max-w-md">
                <h1 class="mb-5 text-5xl font-bold">
                </h1>
                <p class="mb-5">
                    Provident cupiditate voluptatem et in. Quaerat fugiat ut assumenda excepturi exercitationem quasi. In deleniti eaque aut repudiandae et a id nisi.
                </p>
            </div>
        </div>
    </div>


    {{-- HERO 2--}}
    <div class="hero h-96 w-auto rounded m-20 drop-shadow-xl"
         style="background-image: url({{url('/images/hero-2.jpg')}});">
        <div class="hero-overlay bg-opacity-60"></div>
        <div class="hero-content text-center text-neutral-content">
            <div class="max-w-md">
                <h1 id="hero2-title" class="mb-5 text-5xl font-bold uppercase">
                    Join Our Forum
                </h1>
                <p id="hero2-par" class="mb-5">
                    Share and discover topics, ideas and more on our forum! Free to register and use.
                </p>
                <button class="btn btn-primary" onClick="location.href='{{route('login')}}'">Get Started</button>
            </div>
        </div>
    </div>

    {{-- FOOTER --}}
    <footer class="footer footer-center p-4 bg-base-100 text-primary-content">
        <div>
            <x-icons.logo/>
            <p class="font-bold">
                UAB "Interstartas" <br>Programavimo paslaugos
            </p>
            <p>Copyright © 2022 - All right reserved</p>
        </div>
    </footer>

    <script>
        function toggle(divName) {
            var title = document.getElementById(divName+'-title');
            var paragraph = document.getElementById(divName+'-par');
            var editDiv = document.getElementById(divName+'-edit');
            var editBtn = document.getElementById(divName+'-edit-button');

            if (editDiv.style.display === "none") {
                editDiv.style.display = "block";
                title.style.display = "none";
                paragraph.style.display = "none";
                editBtn.style.display = "none";
            } else {
                editDiv.style.display = "none";
                title.style.display = "block";
                paragraph.style.display = "block";
                editBtn.style.display = "block";
            }
        }
        function hide(divName) {
            document.getElementById(divName).style.display = "none";
        }
    </script>
</body>
</html>
