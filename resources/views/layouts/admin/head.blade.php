<!DOCTYPE html>
<html lang="pt-pt" data-theme="light"> <!-- Começa em light, JS muda para dark -->
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'INFOSI RH - Dashboard')</title>
    <!-- Bootstrap do Duralux -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Tema principal do Duralux -->
    <link href="{{ asset('assets/css/theme.min.css') }}" rel="stylesheet">
    <!-- Demo ou custom CSS do Duralux -->
    <link href="{{ asset('assets/css/demo.min.css') }}" rel="stylesheet">
    <!-- Font Awesome para ícones (resolve ícones ausentes) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" crossorigin="anonymous">
    <!-- Google Fonts se usado no Duralux -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <!-- Estilos para theme (baseado em imagens Duralux) -->
    <style>
        [data-theme="dark"] {
            --bg-color: #1a1d21;
            --text-color: #ffffff;
            --card-bg: #212529;
            background-color: var(--bg-color);
            color: var(--text-color);
        }
        [data-theme="light"] {
            --bg-color: #ffffff;
            --text-color: #000000;
            --card-bg: #f8f9fa;
            background-color: var(--bg-color);
            color: var(--text-color);
        }
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
            width: 250px;
            background-color: var(--card-bg);
            overflow-y: auto;
        }
        .content-wrapper {
            margin-left: 250px;
            padding: 20px;
        }
        /* Evitar sobreposições em forms */
        .form-label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
        }
    </style>
</head>