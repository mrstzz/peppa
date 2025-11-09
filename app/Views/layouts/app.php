<?php
// app/Views/layouts/app.php

// Inicia a sessão se ainda não foi iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Peppa' ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                },
            },
        }
    </script>
</head>
<body class="font-sans bg-gray-100">
    
    <header>
        <nav id="main-navbar" class="bg-white py-5 fixed w-full shadow-md transition-transform duration-300 ease-in-out z-50">
            <div class="container mx-auto px-4 flex flex-wrap items-center justify-between">
                <a class="text-red-600 font-bold text-2xl" href="/">
                    <i class="bi bi-x-diamond-fill"></i>
                    Peppa
                </a>
                <form class="hidden md:flex" role="search" action="comerciantes" method="post">
                    <input class="border border-gray-300 rounded-md py-2 px-5 w-80 mr-2 focus:outline-none focus:ring-2 focus:ring-red-500" type="search" placeholder="Buscar..." aria-label="Search"/>
                    <button class="border border-red-500 text-red-500 hover:bg-red-500 hover:text-white font-semibold py-2 px-4 rounded-md transition-colors" type="submit">Buscar</button>
                </form>
                <button id="navbar-toggler" class="lg:hidden p-2 rounded-md text-gray-700 hover:bg-gray-100" type="button" aria-label="Toggle navigation">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                </button>
                <div class="hidden lg:flex lg:items-center lg:w-auto w-full" id="navbarNav">
                    <ul class="flex flex-col lg:flex-row lg:items-center lg:space-x-6 pt-4 lg:pt-0 w-full lg:w-auto text-center lg:text-left">
                        
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <li class="py-2 lg:py-0">
                                <span class="text-gray-700">Olá, <?= htmlspecialchars($_SESSION['user_name']) ?>!</span>
                            </li>
                            <?php if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'comerciante'): ?>
                                <li class="py-2 lg:py-0">
                                    <a class="font-semibold text-gray-700 hover:text-red-600" href="/dashboard-comerciante">Dashboard</a>
                                </li>
                            <?php elseif (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'cliente'): ?>
                                <li class="py-2 lg:py-0">
                                    <a class="font-semibold text-gray-700 hover:text-red-600" href="/dashboard">Dashboard</a>
                                </li>
                            <?php endif; ?>
                            <li class="py-2 lg:py-0 lg:ml-3">
                                <a href="/logout" class="block border border-red-500 text-red-500 hover:bg-red-500 hover:text-white font-semibold py-2 px-4 rounded-md transition-colors">Sair</a>
                            </li>
                        
                        <?php else: ?>
                            <li class="relative group py-2 lg:py-0">
                                <a class="font-semibold text-gray-700 hover:text-red-600 cursor-pointer">
                                    CADASTRE-SE GRÁTIS
                                    <i class="bi bi-chevron-down text-xs"></i>
                                </a>
                                <ul class="absolute hidden group-hover:block bg-white shadow-lg rounded-md py-2 w-48 z-10 lg:right-0 border border-gray-100 text-left">
                                    <li><a class="block px-4 py-2 text-gray-700 hover:bg-gray-100 hover:text-red-600" href="/register?type=usuario">Sou Cliente</a></li>
                                    <li><a class="block px-4 py-2 text-gray-700 hover:bg-gray-100 hover:text-red-600" href="/info-comerciante">Sou Comerciante</a></li>
                                </ul>
                            </li>
                            <li class="py-2 lg:py-0 lg:ml-4">
                                <a class="font-semibold text-gray-700 hover:text-red-600" href="/login">LOGIN</a>
                            </li>

                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class="pt-20 min-h-screen"> 
        <?php echo $content; ?>
    </main>

    <footer class="bg-gray-800 text-gray-400 pt-16 pb-8">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                
                <div>
                    <h5 class="text-white font-semibold mb-6">Para você</h5>
                    <ul class="space-y-3">
                        <li><a href="#" class="hover:text-white hover:underline">Supermercados</a></li>
                        <li><a href="#" class="hover:text-white hover:underline">Drogarias</a></li>
                        <li><a href="#" class="hover:text-white hover:underline">Investimentos</a></li>
                        <li><a href="#" class="hover:text-white hover:underline">Seguros</a></li>
                        <li><a href="#" class="hover:text-white hover:underline">Consórcios</a></li>
                    </ul>
                </div>

                <div>
                    <h5 class="text-white font-semibold mb-6">Para sua empresa</h5>
                    <ul class="space-y-3">
                        <li><a href="#" class="hover:text-white hover:underline">Investimentos</a></li>
                        <li><a href="#" class="hover:text-white hover:underline">Meios de Pagamento</a></li>
                        <li><a href="#" class="hover:text-white hover:underline">Divulgações</a></li>
                        <li><a href="#" class="hover:text-white hover:underline">Outros</a></li>
                    </ul>
                </div>

                <div>
                    <h5 class="text-white font-semibold mb-6">A Peppa</h5>
                    <ul class="space-y-3">
                        <li><a href="#" class="hover:text-white hover:underline">Institucional</a></li>
                        <li><a href="#" class="hover:text-white hover:underline">Central de Relacionamento</a></li>
                        <li><a href="#" class="hover:text-white hover:underline">Trabalhe Conosco</a></li>
                        <li><a href="#" class="hover:text-white hover:underline">Segurança</a></li>
                        <li><a href="#" class="hover:text-white hover:underline">Política de Privacidade</a></li>
                    </ul>
                </div>

                <div>
                    <h5 class="text-white font-semibold mb-6">Contato</h5>
                    <p class="mb-1"><strong class="text-white">Telefone:</strong> (XX) XXXX-XXXX</p>
                    <p><strong class="text-white">Email:</strong> contato@peppa.com</p>
                    <div class="flex space-x-4 mt-3">
                        <a href="#" class="text-2xl hover:text-white"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="text-2xl hover:text-white"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="text-2xl hover:text-white"><i class="bi bi-linkedin"></i></a>
                        <a href="#" class="text-2xl hover:text-white"><i class="bi bi-twitter-x"></i></a>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-700 pt-6 mt-8 text-center">
                <p class="text-sm text-gray-500 mb-0">&copy; <?= date('Y') ?> Peppa. Todos os direitos reservados.</p>
                <p class="text-sm text-gray-500">CNPJ: XX.XXX.XXX/0001-XX | Rua Fictícia, 123 - Cidade, Estado</p>
            </div>
        </div>
    </footer>

    <script>
        const toggler = document.getElementById('navbar-toggler');
        const menu = document.getElementById('navbarNav');

        if (toggler && menu) {
            toggler.addEventListener('click', () => {
                menu.classList.toggle('hidden');
            });
        }
    
        const mainNavbar = document.getElementById('main-navbar');
        let lastScrollTop = 0;

        window.addEventListener('scroll', function() {
            let scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            if (scrollTop > lastScrollTop && scrollTop > mainNavbar.offsetHeight) {
                mainNavbar.classList.add('-translate-y-full'); 
            } else {
                mainNavbar.classList.remove('-translate-y-full'); 
            }
            lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
        });
    </script>

    <?php
    if (isset($show_chat) && $show_chat === true):
        include_once __DIR__ . '/../partials/_chat_widget.php';
    endif;
    ?>
</body>
</html>