<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Gestion de stock CHPO">
    <meta name="author" content="Anas ER-RAKIBI">
    <meta name="robots" content="noindex, nofollow">
    <meta name="googlebot" content="noindex, nofollow">
    <meta name="bingbot" content="noindex, nofollow">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="theme-color" content="#ffffff">
    <link rel="shortcut icon" href="{{ asset('/assets/images/logos/favicon.png') }}" type="image/x-icon">
    <script src="https://unpkg.com/xlsx/dist/xlsx.full.min.js"></script>
    <title>@yield('title', 'app.name')</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@2.44.0/tabler-icons.min.css">
    <!-- Core Css -->
    <link rel="stylesheet" href="{{ asset('/assets/css/theme.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    @yield('csslink')
</head>

<body class=" bg-white">
    <main>
        <!--start the project-->
        <div id="main-wrapper" class=" flex">
            @include('components.aside')
            <div class=" w-full page-wrapper overflow-hidden">

                <!--  Header Start -->
                @include('components.header')
                <!--  Header End -->

                @yield('content')
                <!-- Main Content End -->
            </div>
        </div>
        <!--end of project-->
    </main>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="./assets/libs/simplebar/dist/simplebar.min.js"></script>
    <script src="./assets/libs/iconify-icon/dist/iconify-icon.min.js"></script>
    <script src="./assets/libs/@preline/dropdown/index.js"></script>
    <script src="./assets/libs/@preline/overlay/index.js"></script>
    <script src="./assets/js/sidebarmenu.js"></script>
    <script src="./assets/libs/apexcharts/dist/apexcharts.min.js"></script>
    <script src="./assets/js/dashboard.js"></script>
    <script>
        // Fonction de confirmation avant la suppression avec SweetAlert2
        function confirmDelete(Id) {
            Swal.fire({
                title: 'Êtes-vous sûr?',
                text: "Cette action est irréversible!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Oui, supprimer!',
                cancelButtonText: 'Annuler',
                reverseButtons: true,
                customClass: {
                    confirmButton: 'bg-red-700 text-white hover:bg-red-800', // Couleur du bouton de confirmation
                    cancelButton: 'bg-blue-300 text-white hover:bg-blue-600' // Couleur du bouton d'annulation
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Soumettre le formulaire de suppression si confirmé
                    document.getElementById('delete-form-' + Id).submit();
                }
            });
        }
        window.onload = function() {
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Succès!',
                    text: "{{ session('success') }}",
                    showConfirmButton: false,
                    timer: 1500
                });
            @elseif (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Erreur!',
                    text: "{{ session('error') }}",
                    showConfirmButton: false,
                    timer: 1500
                });
            @endif
        };
        // Add datatable to the table with the id 'table'
        $(document).ready(function() {
            $('#table').DataTable();
            $('#table2').DataTable();


        });
    </script>
    @yield('jslink')
    <script>
        // Disable right click
        document.addEventListener('contextmenu', e => e.preventDefault());

        document.addEventListener('DOMContentLoaded', () => {
            // Disable right click with better performance
            document.addEventListener('contextmenu', e => e.preventDefault(), {
                passive: true
            });

            // Optimize keyboard event listener
            document.addEventListener('keydown', e => {
                if ((e.ctrlKey && e.shiftKey && (e.key === 'I' || e.key === 'J' || e.key === 'C')) ||
                    (e.ctrlKey && e.key === 'u') ||
                    (e.ctrlKey && e.key === 'U') ||
                    (e.key === 'F12')) {
                    e.preventDefault();
                }
            }, {
                passive: false
            });

            // More efficient DevTools detection
            let devToolsCheck = () => {
                const threshold = 160;
                const widthThreshold = window.outerWidth - window.innerWidth > threshold;
                const heightThreshold = window.outerHeight - window.innerHeight > threshold;
                if (widthThreshold || heightThreshold) {
                    window.location.reload();
                }
            };
            setInterval(devToolsCheck, 1000);
        });
    </script>
</body>

</html>
