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
    <title><?= $title ?? 'mrst' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { 
            font-family: 'Inter', sans-serif; 
            background-color: #f8f9fa;
        }
        .navbar {
            box-shadow: 0 2px 4px rgba(0,0,0,.04);
            transition: transform 0.3s ease-in-out;
        }
        .navbar-hidden {
            transform: translateY(-100%);
        }
        .navbar-brand {
            color: #dc3545 !important;
        }

    
        .site-footer {
            background-color: #212529;
            color: #adb5bd; 
            padding-top: 4rem;
            padding-bottom: 2rem;
        }
        .site-footer h5 {
            color: #ffffff; 
            font-weight: 600;
            margin-bottom: 1.5rem;
        }
        .site-footer a {
            color: #adb5bd;
            text-decoration: none;
            transition: color 0.2s ease-in-out;
        }
        .site-footer a:hover {
            color: #ffffff;
            text-decoration: underline;
        }
        .site-footer .list-unstyled li {
            margin-bottom: 0.75rem;
        }
        .site-footer .footer-social-icons a {
            font-size: 1.5rem;
            margin-right: 1rem;
        }
        .site-footer .footer-bottom {
            border-top: 1px solid #495057; 
            padding-top: 1.5rem;
            margin-top: 2rem;
        }

    </style>
</head>
<body>
    
    <header>
        <nav id="main-navbar" class="navbar navbar-expand-lg navbar-light bg-white py-3 fixed-top">
            <div class="container">
                <a class="navbar-brand fw-bold fs-4" href="/">
                    <i class="bi bi-x-diamond-fill"></i>
                    Peppa   
                </a>
                <form class="d-flex" role="search" action="comerciantes" method="post">
                        <input class="form-control me-2" type="search" placeholder="Buscar..." aria-label="Search"/>
                        <button class="btn btn-outline-success" type="submit">Buscar</button>
                </form>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                 <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                    <ul class="navbar-nav align-items-center">
                    <?php if (isset($_SESSION['user_name'])){ ?>
                    <i>Olá,&nbsp;</i> <?= htmlspecialchars($_SESSION['user_name']) ?>! &nbsp;
                    <?php }?>
                    <?php if (isset($_SESSION['user_id'])): ?>
                    <?php if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'comerciante'): ?>
                        <li class="nav-item">
                            <a class=" btn btn-outline-secondary" href="/dashboard-comerciante">Dashboard</a>
                        </li>
                    <?php elseif (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'cliente'): ?>
                        <li class="nav-item">
                            <a class="nav-link fw-semibold" href="/dashboard">Dashboard</a>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item ms-lg-3">
                        <a href="/logout" class="btn btn-outline-danger">Sair</a>
                    </li>
                    <?php else: ?>
                    <li class="nav-item dropdown">
                    <a class="nav-link fw-semibold dropdown-toggle" href="#" id="cadastroDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        CADASTRE-SE GRÁTIS
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="cadastroDropdown">
                        <li><a class="dropdown-item" href="/register?type=usuario">Sou Cliente</a></li>
                        <li><a class="dropdown-item" href="/register?type=comerciante">Sou Comerciante</a></li>
                    </ul>
                    </li>
                    <li class="nav-item ms-lg-3">
                        <a class="nav-link fw-semibold" href="/login">LOGIN</a>
                    </li>
                    <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main style="padding-top: 80px;">
        <?php echo $content; ?>
    </main>

    <footer class="site-footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                    <h5>Para você</h5>
                    <ul class="list-unstyled">
                        <li><a href="#">Supermercados</a></li>
                        <li><a href="#">Drogarias</a></li>
                        <li><a href="#">Investimentos</a></li>
                        <li><a href="#">Seguros</a></li>
                        <li><a href="#">Consórcios</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                    <h5>Para sua empresa</h5>
                    <ul class="list-unstyled">
                        <li><a href="#">Investimentos</a></li>
                        <li><a href="#">Meios de Pagamento</a></li>
                        <li><a href="#">Divulgações</a></li>
                        <li><a href="#">Outros</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                    <h5>A Peppa</h5>
                    <ul class="list-unstyled">
                        <li><a href="#">Institucional</a></li>
                        <li><a href="#">Central de Relacionamento</a></li>
                        <li><a href="#">Trabalhe Conosco</a></li>
                        <li><a href="#">Segurança</a></li>
                        <li><a href="#">Política de Privacidade</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h5>Contato</h5>
                    <p class="mb-1"><strong>Telefone:</strong> (XX) XXXX-XXXX</p>
                    <p><strong>Email:</strong> contato@peppa.com</p>
                    <div class="footer-social-icons mt-3">
                        <a href="#"><i class="bi bi-instagram"></i></a>
                        <a href="#"><i class="bi bi-facebook"></i></a>
                        <a href="#"><i class="bi bi-linkedin"></i></a>
                        <a href="#"><i class="bi bi-twitter-x"></i></a>
                    </div>
                </div>
            </div>

            <div class="footer-bottom text-center">
                <p class="small mb-0">&copy; <?= date('Y') ?> Peppa. Todos os direitos reservados.</p>
                <p class="small">CNPJ: XX.XXX.XXX/0001-XX | Rua Fictícia, 123 - Cidade, Estado</p>
            </div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script>
        const mainNavbar = document.getElementById('main-navbar');
        let lastScrollTop = 0;

        window.addEventListener('scroll', function() {
            let scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            if (scrollTop > lastScrollTop && scrollTop > mainNavbar.offsetHeight) {
                mainNavbar.classList.add('navbar-hidden');
            } else {
                mainNavbar.classList.remove('navbar-hidden');
            }
            lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
        });
    </script>
</body>
</html>