<?php
// app/Views/infoComerciante.php

$title = 'Informações para Anunciantes';

ob_start();
?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <h1 class="display-5 fw-bold text-center mb-5">Como Anunciar no Nosso Site</h1>

            <div class="accordion" id="infoAccordion">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            VANTAGENS & BENEFÍCIOS
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#infoAccordion">
                        <div class="accordion-body">
                            Todos os visitantes do site possuem 100% de acesso ao nosso conteúdo não lhe sendo exigido absolutamente nada.
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            DIVULGAÇÃO & PUBLICIDADE
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#infoAccordion">
                        <div class="accordion-body">
                            O (nosso site) mantém uma ampla e bem planejada estratégia de divulgação que valoriza o seu anúncio, respeitando a tão importante e valorizada discrição de sua imagem, maximizando o retorno esperado pelo seu anúncio. Estamos também nos principais sites de busca da internet, como o GOOGLE por exemplo, sempre nas primeiras posições através das principais e mais importantes palavras chaves procuradas pelos nossos usuáriose também com ações importantes de marketing como a publicação de anúncios em mídia impressa nos principais jornais da cidade, nas traseiras dos ônibus com circulação constante pelas principais avenidas e corredores de Belo Horizonte e região metropolitana (Back Bus), nas principais mídias sociais como o TWITTER e INSTAGRAM e também diversas parcerias com os sites de maior destaque pelas capitais brasileiras.
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingThree">
                        <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            REGRAS PARA PUBLICAÇÃO DO ANÚNCIO
                        </button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#infoAccordion">
                        <div class="accordion-body">
                           <p>Para anunciar em nosso site os Comerciantes  deverão ser maior de 18 anos e possuir CNPJ registrado, apresentar todos os documentos que comprovem a sua maioridade, gravar vídeo de identificação e autorização, assinar (virtualmente) o contrato que autoriza a publicação do seu anúncio e do uso de sua imagem e de acordo consensual entre as partes (anunciante e anunciador), e efetuar o pagamento referente a categoria e plano escolhido.</p>
                           <p>As informações publicadas no anúncio serão de inteira responsabilidade dos comerciantes, assim como os trâmites e acertos dos seus serviços para com seus clientes, tais como valores, locais, dias e horários.</p>
                           <p>O (NOSSO SITE) não é agência, portanto não se responsabiliza por tais ações. Para a composição final de seu anúncio, os comerciantes ainda terão as seguinte opções:</p>
                           <ol>
                               <li>gravar um video de publicisade e anuncio com a sua apresentação comercial;</li>
                           </ol>
                           <p class="mt-3"><strong>ATENÇÃO:</strong> Todo material fotográfico, áudios e vídeos expostos nas páginas de nossas anunciante deverá ser fornecido pelas mesmas, material já deverá estar todo pronto para publicação (editados e também desfocados, se for o caso) respeitando todos os requisitos de qualidade exigidos, com autorização formal para a publicação no (NOSSO SITE) e registro de DIREITOS AUTORAIS dos seus respectivos produtores e fotógrafos. É também de inteira responsabilidade da anunciante comunicar ao site a sua saída (ou desinteresse na continuidade na publicação do seu anúncio), assim como denunciar eventual uso de seu material fotográfico por terceiros sob quaisquer circunstâncias. O (NOSSO SITE) respeita integralmente todos os direitos de suas anunciantes e dos profissionais da fotografia mas não se responsabiliza pelo uso indevido de sua imagem por terceiros.</p>
                        </div>
                    </div>
                </div>
                
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingFour">
                        <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                            DIREITOS AUTORAIS, DE PROPRIEDADE E DE IMAGEM
                        </button>
                    </h2>
                    <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#infoAccordion">
                        <div class="accordion-body">
                            <p>Importante observar as diferenças entre os referidos direitos.</p>
                            <h6>DIREITOS AUTORAIS DO COMERCIANTE (A)</h6>
                            <p>Direitos autorais surgem com a criação de algo, uma pintura, imagem, música, etc. Qualquer que seja a criação artística e intelectual pode se enquadrar nos princípios de direitos autorais garantidos pela Constituição Nacional. Na Lei 9610/98 são garantidos e expostos todos os direitos do autor, ou seja, a pessoa que criou efetivamente qualquer objeto de arte. No artigo 7 e inciso IV desta mesma Lei, a fotografia é garantida como obra intelectual e, por isso, defendida pelos aspectos de direitos autorais.</p>
                            <h6>DIREITOS PATRIMONIAIS OU DE PROPRIEDADE</h6>
                            <p>Os direitos transferidos aos compradores, ou qualquer outro trabalho como fotógrafo profissional, são conhecidos também como direitos patrimoniais. Garantidos no artigo 29 da Lei 9610/98 sobre direitos autorais, permite a concessão de liberdade para reproduzir, editar, distribuir ou comercializar por qualquer método conhecido até hoje, ou que venha a ser inventado.</p>           
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-5">
                <a href="/register?type=comerciante" class="btn btn-danger btn-lg px-5">Crie o seu acesso como comerciante</a>
                <p class="text-muted mt-2"><small>*cadastro sujeito a análise*</small></p>
            </div>

        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/layouts/app.php';
?>
