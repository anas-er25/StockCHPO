<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StockPro</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/heroicons@1.0.6/dist/heroicons.umd.js"></script>
</head>

<body class="min-h-screen bg-white">
    <!-- Navigation -->
    <nav class="bg-white border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center">
                    {{-- <img class="h-8 w-8 text-blue-600" src="path_to_building_icon.svg" alt="Icône de bâtiment"> --}}
                    <span class="ml-2 text-xl font-bold text-gray-900">StockPro</span>
                </div>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#features" class="text-gray-600 hover:text-gray-900">Fonctionnalités</a>
                    <button onclick="window.location.href='/login'"
                        class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                        Commencer
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Section Héro -->
    <div class="relative bg-white overflow-hidden">
        <div class="max-w-7xl mx-auto">
            <div class="relative z-10 pb-8 bg-white sm:pb-16 md:pb-20 lg:pb-28 xl:pb-32">
                <main class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 lg:mt-16 lg:px-8 xl:mt-20">
                    <div class="sm:text-center lg:text-left">
                        <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 sm:text-5xl md:text-6xl">
                            <span class="block">Transformez votre</span>
                            <span class="block text-blue-600">gestion des stocks</span>
                        </h1>
                        <p
                            class="mt-3 text-base text-gray-500 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                            Rationalisez votre gestion des stocks, améliorez l'efficacité et prenez des décisions basées
                            sur des données grâce à notre solution puissante de gestion des stocks.
                        </p>
                        <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start">
                            <div class="rounded-md shadow">
                                <button onclick="window.location.href='/login'"
                                    class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 md:py-4 md:text-lg md:px-10">
                                    Commencez votre gestion
                                </button>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
        <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2">
            <img class="h-56 w-full object-cover sm:h-72 md:h-96 lg:w-full lg:h-full"
                src="https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=2070&q=80"
                alt="Gestion de l'entrepôt" />
        </div>
    </div>

    <!-- Section Fonctionnalités -->
    <div id="features" class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:text-center">
                <h2 class="text-base text-blue-600 font-semibold tracking-wide uppercase">Fonctionnalités</h2>
                <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                    Tout ce dont vous avez besoin pour gérer vos stocks
                </p>
            </div>

            <div class="mt-10">
                <div class="grid grid-cols-1 gap-10 sm:grid-cols-2 lg:grid-cols-3">
                    <!-- Fonctionnalité 1 -->
                    <div class="relative p-6 bg-white rounded-lg shadow-md hover:shadow-lg transition">
                        <div class="text-blue-600 mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20"
                                fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M10 2a8 8 0 110 16 8 8 0 010-16zm-1 4a1 1 0 112 0v4a1 1 0 11-2 0V6zm0 6a1 1 0 112 0v2a1 1 0 11-2 0v-2z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900">Analyse en temps réel</h3>
                        <p class="mt-2 text-base text-gray-500">Obtenez des informations instantanées sur vos niveaux de
                            stock, tendances des ventes et prévisions.</p>
                    </div>

                    <!-- Fonctionnalité 2 -->
                    <div class="relative p-6 bg-white rounded-lg shadow-md hover:shadow-lg transition">
                        <div class="text-blue-600 mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20"
                                fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M10 2a8 8 0 110 16 8 8 0 010-16zm-1 4a1 1 0 112 0v4a1 1 0 11-2 0V6zm0 6a1 1 0 112 0v2a1 1 0 11-2 0v-2z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900">Suivi des stocks</h3>
                        <p class="mt-2 text-base text-gray-500">Suivez vos stocks à travers plusieurs emplacements avec
                            précision et facilité.</p>
                    </div>

                    <!-- Fonctionnalité 3 -->
                    <div class="relative p-6 bg-white rounded-lg shadow-md hover:shadow-lg transition">
                        <div class="text-blue-600 mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20"
                                fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M10 2a8 8 0 110 16 8 8 0 010-16zm-1 4a1 1 0 112 0v4a1 1 0 11-2 0V6zm0 6a1 1 0 112 0v2a1 1 0 11-2 0v-2z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900">Prévisions des ventes</h3>
                        <p class="mt-2 text-base text-gray-500">Des prévisions basées sur l'IA pour optimiser vos
                            niveaux de stock et prévenir les ruptures de stock.</p>
                    </div>

                    <!-- Plus de fonctionnalités... -->
                </div>
            </div>
        </div>
    </div>

    <!-- Section Appel à l'action -->
    <div class="bg-blue-600">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8 lg:flex lg:items-center lg:justify-between">
            <h2 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl">
                <span class="block">Prêt à commencer ?</span>
                <span class="block text-blue-200">Commencez votre gestion gratuitement aujourd'hui.</span>
            </h2>
            <div class="mt-8 flex lg:mt-0 lg:flex-shrink-0">
                <div class="inline-flex rounded-md shadow">
                    <button onclick="window.location.href='/login'"
                        class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-blue-600 bg-white hover:bg-blue-50">
                        Commencer
                        <svg class="ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M12.293 14.293a1 1 0 011.414 0l4-4a1 1 0 010-1.414l-4-4a1 1 0 111.414-1.414l5 5a3 3 0 010 4.242l-5 5a1 1 0 01-1.414-1.414l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <div class="mt-8 border-t border-gray-800 pt-8 flex justify-between items-center">
                <p class="text-gray-400">&copy; 2024 StockPro. Tous droits réservés.</p>
                <div class="flex space-x-6">
                    <a href="https://wa.me/+212696486911" class="text-gray-400 hover:text-white">
                        <svg viewBox="0 0 256 259" width="20" height="20" xmlns="http://www.w3.org/2000/svg"
                            preserveAspectRatio="xMidYMid">
                            <path
                                d="m67.663 221.823 4.185 2.093c17.44 10.463 36.971 15.346 56.503 15.346 61.385 0 111.609-50.224 111.609-111.609 0-29.297-11.859-57.897-32.785-78.824-20.927-20.927-48.83-32.785-78.824-32.785-61.385 0-111.61 50.224-110.912 112.307 0 20.926 6.278 41.156 16.741 58.594l2.79 4.186-11.16 41.156 41.853-10.464Z"
                                fill="#00E676" />
                            <path
                                d="M219.033 37.668C195.316 13.254 162.531 0 129.048 0 57.898 0 .698 57.897 1.395 128.35c0 22.322 6.278 43.947 16.742 63.478L0 258.096l67.663-17.439c18.834 10.464 39.76 15.347 60.688 15.347 70.453 0 127.653-57.898 127.653-128.35 0-34.181-13.254-66.269-36.97-89.986ZM129.048 234.38c-18.834 0-37.668-4.882-53.712-14.648l-4.185-2.093-40.458 10.463 10.463-39.76-2.79-4.186C7.673 134.63 22.322 69.058 72.546 38.365c50.224-30.692 115.097-16.043 145.79 34.181 30.692 50.224 16.043 115.097-34.18 145.79-16.045 10.463-35.576 16.043-55.108 16.043Zm61.385-77.428-7.673-3.488s-11.16-4.883-18.136-8.371c-.698 0-1.395-.698-2.093-.698-2.093 0-3.488.698-4.883 1.396 0 0-.697.697-10.463 11.858-.698 1.395-2.093 2.093-3.488 2.093h-.698c-.697 0-2.092-.698-2.79-1.395l-3.488-1.395c-7.673-3.488-14.648-7.674-20.229-13.254-1.395-1.395-3.488-2.79-4.883-4.185-4.883-4.883-9.766-10.464-13.253-16.742l-.698-1.395c-.697-.698-.697-1.395-1.395-2.79 0-1.395 0-2.79.698-3.488 0 0 2.79-3.488 4.882-5.58 1.396-1.396 2.093-3.488 3.488-4.883 1.395-2.093 2.093-4.883 1.395-6.976-.697-3.488-9.068-22.322-11.16-26.507-1.396-2.093-2.79-2.79-4.883-3.488H83.01c-1.396 0-2.79.698-4.186.698l-.698.697c-1.395.698-2.79 2.093-4.185 2.79-1.395 1.396-2.093 2.79-3.488 4.186-4.883 6.278-7.673 13.951-7.673 21.624 0 5.58 1.395 11.161 3.488 16.044l.698 2.093c6.278 13.253 14.648 25.112 25.81 35.575l2.79 2.79c2.092 2.093 4.185 3.488 5.58 5.58 14.649 12.557 31.39 21.625 50.224 26.508 2.093.697 4.883.697 6.976 1.395h6.975c3.488 0 7.673-1.395 10.464-2.79 2.092-1.395 3.487-1.395 4.882-2.79l1.396-1.396c1.395-1.395 2.79-2.092 4.185-3.487 1.395-1.395 2.79-2.79 3.488-4.186 1.395-2.79 2.092-6.278 2.79-9.765v-4.883s-.698-.698-2.093-1.395Z"
                                fill="#FFF" />
                        </svg>
                    </a>
                    <a href="https://www.linkedin.com/in/anas-er-rakibi/" class="text-gray-400 hover:text-white">
                        <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg"
                            preserveAspectRatio="xMidYMid" viewBox="0 0 256 256">
                            <path
                                d="M218.123 218.127h-37.931v-59.403c0-14.165-.253-32.4-19.728-32.4-19.756 0-22.779 15.434-22.779 31.369v60.43h-37.93V95.967h36.413v16.694h.51a39.907 39.907 0 0 1 35.928-19.733c38.445 0 45.533 25.288 45.533 58.186l-.016 67.013ZM56.955 79.27c-12.157.002-22.014-9.852-22.016-22.009-.002-12.157 9.851-22.014 22.008-22.016 12.157-.003 22.014 9.851 22.016 22.008A22.013 22.013 0 0 1 56.955 79.27m18.966 138.858H37.95V95.967h37.97v122.16ZM237.033.018H18.89C8.58-.098.125 8.161-.001 18.471v219.053c.122 10.315 8.576 18.582 18.89 18.474h218.144c10.336.128 18.823-8.139 18.966-18.474V18.454c-.147-10.33-8.635-18.588-18.966-18.453"
                                fill="#0A66C2" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </footer>

</body>

</html>
