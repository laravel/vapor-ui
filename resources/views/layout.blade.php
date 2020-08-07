<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Meta Information -->
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta name="robots" content="noindex, nofollow" />

        <!-- Title -->
        <title>Vapor Ui - {{ config('vapor-ui.project') }} - {{ config('vapor-ui.environment') }}</title>

        <!-- Style sheets-->
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" />
        <link href="{{ asset(mix('app.css', 'vendor/vapor-ui')) }}" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <div id="vapor-ui" class="font-sans antialiased h-screen flex overflow-hidden bg-gray-100" v-cloak>
            <div class="flex flex-shrink-0">
                <div class="flex flex-col w-64">
                    <div class="flex flex-col h-0 flex-1">
                        <div class="flex items-center h-16 flex-shrink-0 px-4 bg-gray-900">
                            <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/workflow-logo-on-dark.svg" alt="Workflow" />
                        </div>
                        <div class="flex-1 flex flex-col overflow-y-auto bg-gray-800">

                            <!-- Project / Environment  Information -->
                            <div class="px-4 pt-4 space-y-6 sm:flex-row sm:space-y-0 sm:space-x-8 xl:flex-col xl:space-x-0 xl:space-y-6">
                                <div class="flex items-center space-x-2">
                                    <icon-cloud size="6" class="text-gray-300"></icon-cloud>
                                    <span class="text-sm text-gray-300 leading-5 font-medium">{{ config('vapor-ui.project.name') }}</span>
                                </div>
                            </div>

                            <hr class="h-px mt-6 bg-gray-700 border-none" />
                            
                            <!-- Logs tabs -->
                            <h3 class="px-3 mt-8 text-xs leading-4 font-semibold text-gray-500 uppercase tracking-wider" id="teams-headline">
                                Logs
                            </h3>

                            <nav class="flex-1 px-2 py-4 bg-gray-800">
                                <router-link
                                    to="/logs/http"
                                    href="#"
                                    active-class="text-white bg-gray-900 focus:outline-none focus:bg-gray-900 transition ease-in-out duration-150"
                                    class="group flex items-center px-2 py-2 text-sm leading-5 font-medium text-gray-300 rounded-md hover:text-white hover:bg-gray-700 focus:outline-none focus:text-white focus:bg-gray-700 transition ease-in-out duration-150"
                                >
                                    <icon-desktop-computer size="6" class="mr-3 text-gray-400 group-hover:text-gray-300 group-focus:text-gray-300 transition ease-in-out duration-150"> </icon-desktop-computer>
                                    HTTP
                                </router-link>
                                <router-link
                                    to="/logs/cli"
                                    href="#"
                                    active-class="text-white bg-gray-900 focus:outline-none focus:bg-gray-900 transition ease-in-out duration-150"
                                    class="mt-1 group flex items-center px-2 py-2 text-sm leading-5 font-medium text-gray-300 rounded-md hover:text-white hover:bg-gray-700 focus:outline-none focus:text-white focus:bg-gray-700 transition ease-in-out duration-150"
                                >
                                    <icon-terminal size="6" class="mr-3 text-gray-400 group-hover:text-gray-300 group-focus:text-gray-300 transition ease-in-out duration-150"> </icon-terminal>
                                    CLI
                                </router-link>
                                <router-link
                                    to="/logs/queue"
                                    href="#"
                                    active-class="text-white bg-gray-900 focus:outline-none focus:bg-gray-900 transition ease-in-out duration-150"
                                    class="mt-1 group flex items-center px-2 py-2 text-sm leading-5 font-medium text-gray-300 rounded-md hover:text-white hover:bg-gray-700 focus:outline-none focus:text-white focus:bg-gray-700 transition ease-in-out duration-150"
                                >
                                    <icon-collection size="6" class="mr-3 text-gray-400 group-hover:text-gray-300 group-focus:text-gray-300 transition ease-in-out duration-150"> </icon-collection>
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
