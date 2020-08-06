<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Meta Information -->
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta name="robots" content="noindex, nofollow" />

        <!-- Title -->
        <title>Vapor Ui - {{ config('vapor-ui.project') }}</title>

        <!-- Style sheets-->
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" />
        <link href="{{ asset(mix('app.css', 'vendor/vapor-ui')) }}" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <div id="vapor-ui" class="h-screen flex overflow-hidden bg-gray-100" v-cloak>
            <div class="flex flex-shrink-0">
                <div class="flex flex-col w-64">
                    <div class="flex flex-col h-0 flex-1">
                        <div class="flex items-center h-16 flex-shrink-0 px-4 bg-gray-900">
                            <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/workflow-logo-on-dark.svg" alt="Workflow" />
                        </div>
                        <div class="flex-1 flex flex-col overflow-y-auto bg-gray-800">

                            <h3 class="px-3 mt-8 text-xs leading-4 font-semibold text-gray-500 uppercase tracking-wider" id="teams-headline">
                                Logs
                            </h3>

                            <nav class="flex-1 px-2 py-4 bg-gray-800">

                                <router-link
                                    to="/logs/http"
                                    href="#"
                                    active-class="text-white bg-gray-900 focus:outline-none focus:bg-gray-700 transition ease-in-out duration-150"
                                    class="group flex items-center px-2 py-2 text-sm leading-5 font-medium text-gray-300 rounded-md hover:text-white hover:bg-gray-700 focus:outline-none focus:text-white focus:bg-gray-700 transition ease-in-out duration-150"
                                >
                                    <svg class="mr-3 h-6 w-6 text-gray-300 group-hover:text-gray-300 group-focus:text-gray-300 transition ease-in-out duration-150" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"
                                        />
                                    </svg>
                                    HTTP
                                </router-link>
                                <router-link
                                    to="/logs/cli"
                                    href="#"
                                    active-class="text-white bg-gray-900 focus:outline-none focus:bg-gray-700 transition ease-in-out duration-150"
                                    class="mt-1 group flex items-center px-2 py-2 text-sm leading-5 font-medium text-gray-300 rounded-md hover:text-white hover:bg-gray-700 focus:outline-none focus:text-white focus:bg-gray-700 transition ease-in-out duration-150"
                                >
                                    <svg class="mr-3 h-6 w-6 text-gray-400 group-hover:text-gray-300 group-focus:text-gray-300 transition ease-in-out duration-150" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                    CLI
                                </router-link>
                                <router-link
                                    to="/logs/queue"
                                    href="#"
                                    active-class="text-white bg-gray-900 focus:outline-none focus:bg-gray-700 transition ease-in-out duration-150"
                                    class="mt-1 group flex items-center px-2 py-2 text-sm leading-5 font-medium text-gray-300 rounded-md hover:text-white hover:bg-gray-700 focus:outline-none focus:text-white focus:bg-gray-700 transition ease-in-out duration-150"
                                >
                                    <svg class="mr-3 h-6 w-6 text-gray-400 group-hover:text-gray-300 group-focus:text-gray-300 transition ease-in-out duration-150" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                                    </svg>
                                    Queue
                                </router-link>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <router-view></router-view>
        </div>

        <!-- Global App Object -->
        <script>
            window.App = @json($appVars);
        </script>

        <script src="{{ asset(mix('app.js', 'vendor/vapor-ui')) }}"></script>
    </body>
</html>
