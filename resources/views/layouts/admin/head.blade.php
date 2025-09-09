<!DOCTYPE html>
<html lang="pt-pt" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'INFOSI RH - Dashboard')</title>
    <!-- jQuery CDN (necessário para theme-customizer-init.min.js) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" crossorigin="anonymous"></script>
    <!-- Bootstrap CSS local (se existir, senão CDN) -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Tema principal do Duralux (você tem isso) -->
    <link href="{{ asset('assets/css/theme.min.css') }}" rel="stylesheet">
    <!-- Font Awesome para ícones -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" crossorigin="anonymous">
    <!-- Google Fonts para Inter (como no Duralux) -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <!-- Estilos custom para sidebar e temas (melhorado para dinamismo) -->
    <style>
        body { font-family: 'Inter', sans-serif; }
        [data-theme="dark"] {
            --bg-color: #1a1d21;
            --text-color: #ffffff;
            --card-bg: #212529;
            --sidebar-bg: #1a1d21;
            background-color: var(--bg-color);
            color: var(--text-color);
        }
        [data-theme="light"] {
            --bg-color: #ffffff;
            --text-color: #000000;
            --card-bg: #f8f9fa;
            --sidebar-bg: #ffffff;
            background-color: var(--bg-color);
            color: var(--text-color);
        }
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
            width: 250px;
            background-color: var(--sidebar-bg);
            overflow-y: auto;
            transition: width 0.3s ease; /* Animação para dinamismo */
            z-index: 1000;
        }
        .sidebar .nav-link {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: var(--text-color);
            transition: background 0.2s ease;
        }
        .sidebar .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }
        .sidebar .has-submenu .nav-link i.ms-auto {
            transition: transform 0.3s ease; /* Gira a setinha ao colapsar */
        }
        .sidebar .has-submenu.show .nav-link i.ms-auto {
            transform: rotate(180deg);
        }
        .submenu {
            background-color: rgba(0, 0, 0, 0.1);
        }
        .content-wrapper {
            margin-left: 250px;
            padding: 20px;
            transition: margin-left 0.3s ease;
        }
        /* Responsivo para mobile */
        @media (max-width: 768px) {
            .sidebar { width: 100%; transform: translateX(-100%); }
            .sidebar.show { transform: translateX(0); }
            .content-wrapper { margin-left: 0; }
        }
        .form-label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
        }
    </style>
</head>