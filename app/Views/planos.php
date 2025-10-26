<?php
// app/Views/planos.php

$title = 'Escolha seu Plano';
ob_start();
?>

<div class="container py-3">
    <header>
        <div class="pricing-header p-3 pb-md-4 mx-auto text-center">
            <h1 class="display-4 fw-normal">Planos de Anúncio</h1>
            <p class="fs-5 text-muted">Escolha o plano que melhor se adapta às suas necessidades e comece a divulgar seu perfil hoje mesmo.</p>
        </div>
    </header>

    <main>
        <div class="row row-cols-1 row-cols-md-3 mb-3 text-center">
            <div class="col">
                <div class="card mb-4 rounded-3 shadow-sm">
                    <div class="card-header py-3">
                        <h4 class="my-0 fw-normal">Básico</h4>
                    </div>
                    <div class="card-body">
                        <h1 class="card-title pricing-card-title">R$750<small class="text-muted fw-light">/anual</small></h1>
                        <ul class="list-unstyled mt-3 mb-4">
                            <li>Até 6 fotos na galeria</li>
                            <li>1 video de apresentação</li>
                            <li>Perfil personalizado</li>
                            <li>Acesso a filtros de busca</li>
                            <li>Suporte especializado</li>
                        </ul>
                        <form action="/planos/assinar" method="POST">
                            <input type="hidden" name="plano" value="plano_1">
                            <button type="submit" class="w-100 btn btn-lg btn-outline-primary">Assinar Plano</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card mb-4 rounded-3 shadow-sm border-primary">
                     <div class="card-header py-3 text-white bg-primary border-primary">
                        <h4 class="my-0 fw-normal">Profissional</h4>
                    </div>
                    <div class="card-body">
                        <h1 class="card-title pricing-card-title">R$1289<small class="text-muted fw-light">/anual</small></h1>
                        <ul class="list-unstyled mt-3 mb-4">
                            <li>Até 9 fotos na galeria</li>
                            <li>Até 3 vídeos de apresentação</li>
                            <li>Perfil com prioridade média</li>
                            <li>Perfil personalizado</li>
                            <li>Destaque em buscas</li>
                            <li>Suporte especializado</li>
                        </ul>
                        <form action="/planos/assinar" method="POST">
                            <input type="hidden" name="plano" value="plano_2">
                            <button type="submit" class="w-100 btn btn-lg btn-primary">Assinar Plano</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card mb-4 rounded-3 shadow-sm">
                    <div class="card-header py-3">
                        <h4 class="my-0 fw-normal">Premium</h4>
                    </div>
                    <div class="card-body">
                        <h1 class="card-title pricing-card-title">R$1729<small class="text-muted fw-light">/anual</small></h1>
                        <ul class="list-unstyled mt-3 mb-4">
                            <li>Até 15 fotos na galeria</li>
                            <li>Até 6 vídeos de apresentação</li>
                            <li>Perfil com prioridade máxima</li>
                            <li>Perfil personalizado</li>
                            <li>Destaque em buscas</li>
                            <li>Gráficos de vendas e pontos de melhorias</li>
                            <li>Suporte prioritário</li>

                        </ul>
                        <form action="/planos/assinar" method="POST">
                            <input type="hidden" name="plano" value="plano_3">
                            <button type="submit" class="w-100 btn btn-lg btn-outline-primary">Assinar Plano</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/layouts/app.php';
?>
