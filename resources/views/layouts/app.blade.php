<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Video Games</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    </head>
    <body class="bg-gray-900 text-white">
        <header class="border-b border-gray-800">
            <nav class="container mx-auto flex items-center justify-between px-4 py-6">
                <div class="flex items-center">
                    <a href="/">
                        <img src="laracasts-logo.svg" alt="laracasts" srcset="" class="w-32 flex-none">
                    </a>
                    <ul class="flex ml-16 space-x-8">
                        <li><a href="#" class="hover:text-gray-400">Games</a></li>
                        <li><a href="#" class="hover:text-gray-400">Reviews</a></li>
                        <li><a href="#" class="hover:text-gray-400">Coming soon</a></li>
                    </ul>
                </div>

                <div class="flex items-center">
                    <div class="relative">
                        <input type="text" class="bg-gray-800 text-sm rounded-full w-64 px-3 pl-8 py-1 focus:outline-none focus:ring" placeholder="Search...">
                        <div class="absolute top-0 flex items-center h-full ml-2">
                             <svg class="fill-current text-gray-400 w-4" viewBox="0 0 24 24"><path class="heroicon-ui" d="M16.32 14.9l5.39 5.4a1 1 0 01-1.42 1.4l-5.38-5.38a8 8 0 111.41-1.41zM10 16a6 6 0 100-12 6 6 0 000 12z"/></svg>
                        </div>
                    </div>
                    <div class="ml-6">
                        <a href="#">
                            <img src="/avatar.jpg" alt="avatar" srcset="" class="rounded-full w-8">
                        </a>
                    </div>

                </div>
            </nav>
        </header>
    </body>
</html>