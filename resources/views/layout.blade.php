<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Meta Information -->
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta name="robots" content="noindex, nofollow" />

        <!-- Title -->
        <title>Vapor UI - {{ config('vapor-ui.project') }} - {{ config('vapor-ui.environment') }}</title>

        <!-- Style sheets -->
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" />
        <link href="{{ asset(mix('app.css', 'vendor/vapor-ui')) }}" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <!-- Vue App-->
        <div id="vapor-ui" class="font-sans antialiased h-screen flex overflow-hidden bg-gray-100" v-cloak>
            <div class="flex flex-shrink-0">
                <div class="flex flex-col w-64">
                    <div class="flex flex-col h-0 flex-1">

                        <!-- Logo -->
                        <div class="flex items-center h-16 px-4 bg-gray-900 text-xl text-white font-medium">
                            <svg viewBox="0 0 40 40" class="h-12 w-12" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M4.345 9h10.55L9.618 20 4.345 9zm21.099 0h10.55l-5.276 11-5.274-11z" fill="#E9F9FD" fill-opacity=".1"/><path fill-rule="evenodd" clip-rule="evenodd" d="M9.62 20h10.549l-5.275 11L9.62 20z" fill="#25C4F2" fill-opacity=".22"/><path fill-rule="evenodd" clip-rule="evenodd" d="M20.169 20h10.55l-5.275 11-5.275-11z" fill="#25C4F2" fill-opacity=".2"/><path fill-rule="evenodd" clip-rule="evenodd" d="M20.169 20H9.619l5.275-11 5.275 11z" fill="#25C4F2" fill-opacity=".4"/><path fill-rule="evenodd" clip-rule="evenodd" d="M30.718 20h-10.55l5.276-11 5.274 11z" fill="#25C4F2" fill-opacity=".4"/><path fill-rule="evenodd" clip-rule="evenodd" d="M25.444 31h-10.55l5.275-11 5.275 11z" fill="#25C4F2" fill-opacity=".5"/><path fill-rule="evenodd" clip-rule="evenodd" d="M3.494 8.467A1 1 0 0 1 4.34 8h10.55a1 1 0 0 1 .902.568l4.373 9.12 4.373-9.12A1 1 0 0 1 25.44 8h10.55a1 1 0 0 1 .902 1.432L26.345 31.424a1.001 1.001 0 0 1-.905.576H14.89a1 1 0 0 1-.902-.568l-10.55-22a1 1 0 0 1 .056-.965zm21.95 2.846L29.13 19h-7.372l3.686-7.687zM5.934 10l3.686 7.687L13.306 10H5.933zm8.96 1.313L18.58 19h-7.372l3.686-7.687zM27.032 10l3.686 7.687L34.405 10h-7.373zm-1.588 18.687L21.758 21h7.372l-3.686 7.687zM23.855 30l-3.686-7.687L16.483 30h7.372zm-8.96-1.313L11.207 21h7.372l-3.686 7.687z" fill="#25C4F2"/></svg>
                            <div class="ml-2" style="padding-top: 2px;">Laravel Vapor</div>
                        </div>

                        <div class="flex-1 flex flex-col overflow-y-auto bg-gray-800">
                            <!-- Project Name -->
                            <div class="px-4 pt-4 space-y-6 sm:flex-row sm:space-y-0 sm:space-x-8 xl:flex-col xl:space-x-0 xl:space-y-6">
                                <div class="flex items-center space-x-2">
                                    <icon-cloud size="4" class="text-gray-300"></icon-cloud>
                                    <span class="text-sm text-gray-300 leading-5 font-medium">{{ config('vapor-ui.project') }} > {{ config('vapor-ui.environment') }}</span>
                                </div>
                            </div>

                            <!-- Project Environment -->
                            <div class="px-4 pt-4 space-y-6 sm:flex-row sm:space-y-0 sm:space-x-8 xl:flex-col xl:space-x-0 xl:space-y-6">
                                <div class="flex items-center space-x-2">
                                    <icon-flag size="4" class="text-gray-300"></icon-flag>
                                    <span class="text-sm text-gray-300 leading-5 font-medium">{{ config('vapor-ui.region') }}</span>
                                </div>
                            </div>

                            <hr class="h-px mt-6 bg-gray-700 border-none" />

                            <!-- Logs tabs -->
                            <h3 class="px-3 mt-8 text-xs leading-4 font-semibold text-gray-500 uppercase tracking-wider">
                                Logs
                            </h3>

                            <nav class="px-2 py-4 bg-gray-800">
                                <router-link
                                    :to="{ name: `logs-index`, query: this.$route.query, params: { group: 'http' } }"
                                    href="#"
                                    active-class="text-white bg-gray-900 focus:outline-none focus:bg-gray-900 transition ease-in-out duration-150"
                                    class="group flex items-center px-2 py-2 text-sm leading-5 font-medium text-gray-300 rounded-md hover:text-white hover:bg-gray-700 focus:outline-none focus:text-white focus:bg-gray-700 transition ease-in-out duration-150"
                                >
                                    <icon-desktop-computer size="6" class="mr-3 text-gray-400 group-hover:text-gray-300 group-focus:text-gray-300 transition ease-in-out duration-150"> </icon-desktop-computer>
                                    HTTP
                                </router-link>
                                <router-link
                                    :to="{ name: `logs-index`, query: this.$route.query, params: { group: 'cli' } }"
                                    href="#"
                                    active-class="text-white bg-gray-900 focus:outline-none focus:bg-gray-900 transition ease-in-out duration-150"
                                    class="mt-1 group flex items-center px-2 py-2 text-sm leading-5 font-medium text-gray-300 rounded-md hover:text-white hover:bg-gray-700 focus:outline-none focus:text-white focus:bg-gray-700 transition ease-in-out duration-150"
                                >
                                    <icon-terminal size="6" class="mr-3 text-gray-400 group-hover:text-gray-300 group-focus:text-gray-300 transition ease-in-out duration-150"> </icon-terminal>
                                    CLI
                                </router-link>
                                <router-link
                                    :to="{ name: `logs-index`, query: this.$route.query, params: { group: 'queue' } }"
                                    href="#"
                                    active-class="text-white bg-gray-900 focus:outline-none focus:bg-gray-900 transition ease-in-out duration-150"
                                    class="mt-1 group flex items-center px-2 py-2 text-sm leading-5 font-medium text-gray-300 rounded-md hover:text-white hover:bg-gray-700 focus:outline-none focus:text-white focus:bg-gray-700 transition ease-in-out duration-150"
                                >
                                    <icon-collection size="6" class="mr-3 text-gray-400 group-hover:text-gray-300 group-focus:text-gray-300 transition ease-in-out duration-150"> </icon-collection>
                                    Queue
                                </router-link>
                            </nav>

                            <!-- Logs tabs -->
                            <h3 class="px-3 text-xs leading-4 font-semibold text-gray-500 uppercase tracking-wider">
                                Jobs
                            </h3>

                            <nav class="px-2 py-4 bg-gray-800">
                                <router-link
                                    :to="{ name: `jobs-metrics`, query: this.$route.query }"
                                    href="#"
                                    active-class="text-white bg-gray-900 focus:outline-none focus:bg-gray-900 transition ease-in-out duration-150"
                                    class="group flex items-center px-2 py-2 text-sm leading-5 font-medium text-gray-300 rounded-md hover:text-white hover:bg-gray-700 focus:outline-none focus:text-white focus:bg-gray-700 transition ease-in-out duration-150"
                                >
                                    <icon-chart-bar size="6" class="mr-3 text-gray-400 group-hover:text-gray-300 group-focus:text-gray-300 transition ease-in-out duration-150"> </icon-chart-bar>
                                    Metrics
                                </router-link>

                                <router-link
                                    :to="{ name: `jobs-index`, query: this.$route.query, params: { group: 'failed' } }"
                                    href="#"
                                    active-class="text-white bg-gray-900 focus:outline-none focus:bg-gray-900 transition ease-in-out duration-150"
                                    class="group flex items-center px-2 py-2 text-sm leading-5 font-medium text-gray-300 rounded-md hover:text-white hover:bg-gray-700 focus:outline-none focus:text-white focus:bg-gray-700 transition ease-in-out duration-150"
                                >
                                    <icon-x-circle size="6" class="mr-3 text-gray-400 group-hover:text-gray-300 group-focus:text-gray-300 transition ease-in-out duration-150"> </icon-x-circle>
                                    Failed
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
