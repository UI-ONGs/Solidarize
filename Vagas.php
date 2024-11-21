<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta class="viewport" content="width=device-width, initial-scale=1.0">
        <title>Voluntariados</title>
        <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
        <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
        <link rel="stylesheet" href="css/NavBar.css">
        <!--link para utilizar os icones-->
        <script src="https://kit.fontawesome.com/0e6a916873.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="css/Vagas.css">
        <script src="js/Vagas.js"></script>
        <script src="js/NavBar.js" defer></script>
        <script src="js/teste.js" defer></script>
        
        <!-- Link para o FavIcon -->
        <link rel="icon" href="imagens/logo.png">
    </head>
    <body>
        <!-- Include navbar -->
    <?php include 'navbar.php'; ?>
        <main>
            <header class="blurElem">
                <form class="form">
                  <button class="segurar">
                      <svg width="17" height="16" fill="none" xmlns="http://www.w3.org/2000/svg" role="img" aria-labelledby="search">
                          <path d="M7.667 12.667A5.333 5.333 0 107.667 2a5.333 5.333 0 000 10.667zM14.334 14l-2.9-2.9" stroke="currentColor" stroke-width="1.333" stroke-linecap="round" stroke-linejoin="round"></path>
                      </svg>
                  </button>
                  <input class="input" placeholder="Pesquisar..." required="" type="text">
                  <button class="reset segurar" type="reset">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                      </svg>
                  </button>
               </form>
                   <a href="index.html">
                       <button class="shadow__btn">
                           SOLIDARIZE
                       </button>
                   </a>
            </header>
            
            <!-- Criação do slide de conteúdo -->
            <div class="slide-container swiper">
                    <!-- Carrossel -->
                    <div class="wrapper swiper-wrapper">
                        <!-- card -->
                        <div class="card swiper-slide">
                            <!-- Cocal onde fica a imagem -->
                            <div class="conteudoImg">
                                <!-- Divisória do card para separação da imagem dos demais -->
                                <span class="overlay"></span>
                                <!-- Card da imagem -->
                                <div class="cardImage">
                                    <!-- Imagem -->
                                    <img src="imagens/floresta.jpg" alt="floresta" class="cardImg">
                                </div>
                            </div>
                            <!-- Conteúdo do Card em texto -->
                            <div class="conteudoCard">
                                <h2 class="nome">Ong das arvores</h2>
                                <p class="descricao">The lorem text the section that contains header with having open funcionality Lorem dolor sit amet consectetur adipiscing elit</p>
                                <!-- botão ver mais -->
                                <a href="https://ui-ongs.github.io/UI-PwbAval/Detalhe-Vagas.html"><button class="botao">Ver Mais</button></a>
                            </div>
                        </div>
                        <div class="card swiper-slide">
                            <div class="conteudoImg">
                                <span class="overlay"></span>
                                <div class="cardImage">
                                    <img src="imagens/floresta.jpg" alt="floresta" class="cardImg">
                                </div>
                            </div>
                            <div class="conteudoCard">
                                <h2 class="nome">Ong das arvores</h2>
                                <p class="descricao">The lorem text the section that contains header with having open funcionality Lorem dolor sit amet consectetur adipiscing elit</p>

                                <a href="https://ui-ongs.github.io/UI-PwbAval/Detalhe-Vagas.html"><button class="botao">Ver Mais</button></a>
                            </div>
                        </div>
                        <div class="card swiper-slide">
                            <div class="conteudoImg">
                                <span class="overlay"></span>
                                <div class="cardImage">
                                    <img src="imagens/floresta.jpg" alt="floresta" class="cardImg">
                                </div>
                            </div>
                            <div class="conteudoCard">
                                <h2 class="nome">Ong das arvores</h2>
                                <p class="descricao">The lorem text the section that contains header with having open funcionality Lorem dolor sit amet consectetur adipiscing elit</p>

                                <a href="https://ui-ongs.github.io/UI-PwbAval/Detalhe-Vagas.html"><button class="botao">Ver Mais</button></a>
                            </div>
                        </div>
                        <div class="card swiper-slide">
                            <div class="conteudoImg">
                                <span class="overlay"></span>
                                <div class="cardImage">
                                    <img src="imagens/floresta.jpg" alt="floresta" class="cardImg">
                                </div>
                            </div>
                            <div class="conteudoCard">
                                <h2 class="nome">Ong das arvores</h2>
                                <p class="descricao">The lorem text the section that contains header with having open funcionality Lorem dolor sit amet consectetur adipiscing elit</p>

                                <a href="https://ui-ongs.github.io/UI-PwbAval/Detalhe-Vagas.html"><button class="botao">Ver Mais</button></a>
                            </div>
                        </div>
                        <div class="card swiper-slide">
                            <div class="conteudoImg">
                                <span class="overlay"></span>
                                <div class="cardImage">
                                    <img src="imagens/floresta.jpg" alt="floresta" class="cardImg">
                                </div>
                            </div>
                            <div class="conteudoCard">
                                <h2 class="nome">Ong das arvores</h2>
                                <p class="descricao">The lorem text the section that contains header with having open funcionality Lorem dolor sit amet consectetur adipiscing elit</p>

                                <a href="https://ui-ongs.github.io/UI-PwbAval/Detalhe-Vagas.html"><button class="botao">Ver Mais</button></a>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-pagination"></div>
                    
                </div>
                <div class="swiper-button-next swiper-navBtn blurElem"></div>
                <div class="swiper-button-prev swiper-navBtn blurElem"></div>
                
                <div class="footer blurElem">
                    <div class="btn_cadastrar">
                        <a href="https://ui-ongs.github.io/UI-PwbAval/Cadastro-Vagas.html">
                            <button class="cadastrar botao">Cadastrar Vaga</button>
                        </a>
                    </div>
                </div>
        </main>
    </body>
</html>
