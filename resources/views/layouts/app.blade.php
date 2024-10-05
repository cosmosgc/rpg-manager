<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'RPG Manager')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- Custom Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @yield('styles')
    <style>
        :root {
            --background-image-url: url('{{ asset('storage/images/background/snowy-mountain-peak-starry-galaxy-majesty-generative-ai.jpg') }}');
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <nav class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <img src="https://via.placeholder.com/70" alt="Profile Picture">
            <h4>RPG</h4>
            <span>Manager</span>
        </div>

        <div class="menu-items">
        <a href="{{route('home')}}"><span class="icon"><i class="fas fa-home"></i></span> Home</a>
        <a href="{{route('characters.index')}}"><span class="icon"><i class="fas fa-user"></i></span> Personagens</a>
        <a href="#"><span class="icon"><i class="fas fa-briefcase"></i></span> Skills</a>
        <a href="#"><span class="icon"><i class="fas fa-gem"></i></span> Items</a>
        <a href="#"><span class="icon"><i class="fas fa-ghost"></i></span> Monstros</a>
        <a href="#"><span class="icon"><i class="fas fa-map"></i></span> Cenas</a>


            <div class="separator"></div>

            <a href="#"><span class="icon"><i class="fas fa-bell"></i></span> Notifications <span class="badge">24</span></a>
            <a href="#"><span class="icon"><i class="fas fa-comment"></i></span> Chat <span class="badge">13</span></a>
            <a href="#"><span class="icon"><i class="fas fa-gift"></i></span> Present</a>

            <div class="separator"></div>

            <a href="#"><span class="icon"><i class="fas fa-moon"></i></span> Dark Mode</a>
            <a href="#"><span class="icon"><i class="fas fa-cog"></i></span> Settings</a>
            <a href="#"><span class="icon"><i class="fas fa-sign-out-alt"></i></span> Log out</a>
        </div>
    </nav>

    <!-- Button to toggle sidebar on mobile -->
    <button class="toggle-btn" id="toggle-btn">&#9776;</button>

    <!-- Main content -->
    <div class="content">
        @yield('content')
    </div>

    <!-- Bootstrap JS (optional for collapse or interactive features) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Script to toggle the sidebar -->
    <script>
        const sidebar = document.getElementById('sidebar');
        const toggleBtn = document.getElementById('toggle-btn');

        toggleBtn.addEventListener('click', function() {
            sidebar.classList.toggle('open');
        });
    </script>
</body>
</html>
