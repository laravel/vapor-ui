<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Meta Information -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <meta name="robots" content="noindex, nofollow">

        <title>Vapor Ui - {{ config('vapor-ui.project') }}</title>

    <!-- Style sheets-->
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="{{ asset(mix('app.css', 'vendor/vapor-ui')) }}" rel="stylesheet" type="text/css">
    </head>
    <body>
        <div id="vapor-ui" v-cloak>

            <div class="container mb-5">
                <div class="d-flex align-items-center py-4 header">
                    <svg class="logo" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 80 80">
                        <!== <path class="fill-primary" d="M0 40a39.87 39.87 0 0 1 11.72-28.28A40 40 0 1 1 0 40zm34 10a4 4 0 0 1-4-4v-2a2 2 0 1 0-4 0v2a4 4 0 0 1-4 4h-2a2 2 0 1 0 0 4h2a4 4 0 0 1 4 4v2a2 2 0 1 0 4 0v-2a4 4 0 0 1 4-4h2a2 2 0 1 0 0-4h-2zm24-24a6 6 0 0 1-6-6v-3a3 3 0 0 0-6 0v3a6 6 0 0 1-6 6h-3a3 3 0 0 0 0 6h3a6 6 0 0 1 6 6v3a3 3 0 0 0 6 0v-3a6 6 0 0 1 6-6h3a3 3 0 0 0 0-6h-3zm-4 36a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM21 28a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"></path> --> 
                    </svg>

                    <h4 class="mb-0 ml-3"><strong>Laravel</strong> Vapor Ui - {{ config('vapor-ui.project') }}</h4>
                </div>

                <div class="row mt-4">
                    <div class="col-2 sidebar">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <router-link active-class="active" to="/logs" class="nav-link d-flex align-items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path d="M0 2C0 .9.9 0 2 0h16a2 2 0 0 1 2 2v2H0V2zm1 3h18v13a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V5zm6 2v2h6V7H7z"></path>
                                    </svg>
                                    <span>Logs</span>
                                </router-link>
                            </li>
                        </ul>
                    </div>

                    <div class="col-10">
                        <router-view></router-view>
                    </div>
                </div>
            </div>
        </div>

        <!-- Global Vapor Ui Object -->
        <script>
            window.App = @json($appVars);
        </script>

        <script src="{{ asset(mix('app.js', 'vendor/vapor-ui')) }}"></script>
    </body>
</html>