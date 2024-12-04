<?php
session_start();
require_once 'php/config.php';
require_once 'php/functions.php';
require_once 'php/check_auth.php';

// Check if the user should be here
requireGuest();

// Fetch categories and needs for the registration forms
$categorias = getCategorias();
$necessidades = getNecessidades();

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solidarize - Login e Cadastro</title>
    <link rel="stylesheet" href="css/Login.css">
    <script src="https://kit.fontawesome.com/0e6a916873.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <main>
            <section id="login-section" class="active">
                <div class="logo">
                    <i class="fas fa-hands-helping"></i>
                    <h1>Solidarize</h1>
                </div>
                <form id="login-form">
                    <div class="form-group">
                        <input type="email" id="login-email" placeholder="E-mail" required>
                        <span class="error-message" id="login-email-error"></span>
                    </div>
                    <div class="form-group">
                        <input type="password" id="login-password" placeholder="Senha" required>
                        <span class="error-message" id="login-password-error"></span>
                    </div>
                    <div class="form-group checkbox">
                        <input type="checkbox" id="stay-signed-in">
                        <label for="stay-signed-in">Permanecer conectado</label>
                    </div>
                    <button type="submit">ENTRAR</button>
                </form>
                <p class="switch-form">Não tem uma conta? <a href="#" id="show-register">Cadastre-se</a></p>
                <p class="forgot-password"><a href="#" id="show-forgot-password">Esqueceu sua senha?</a></p>
            </section>

            <section id="forgot-password-section">
                <div class="top-form">
                    <button class="back-button"><i class="fas fa-arrow-left"></i></button>
                    <h2>Recuperar Senha</h2>
                </div>
                <form id="forgot-password-form">
                    <div class="form-group">
                        <input type="email" id="forgot-password-email" placeholder="E-mail" required>
                        <span class="error-message" id="forgot-password-email-error"></span>
                    </div>
                    <button type="submit">Enviar link de recuperação</button>
                </form>
            </section>

            <section id="register-type-section">
                <h2>Cadastro</h2>
                <p>Você é um voluntário ou uma instituição?</p>
                <div class="register-type-buttons">
                    <button id="volunteer-button">Voluntário</button>
                    <button id="institution-button">Instituição</button>
                </div>
            </section>

            <section id="volunteer-register-section-1">
                <div class="top-form">
                    <button class="back-button"><i class="fas fa-arrow-left"></i></button>
                    <h2>Cadastro de Voluntário</h2>
                </div>
                
                <form id="volunteer-register-form-1">
                    <div class="form-row">
                        <div class="form-group">
                            <input type="text" id="volunteer-name" placeholder="Nome" required>
                            <span class="error-message" id="volunteer-name-error"></span>
                        </div>
                        <div class="form-group">
                            <input type="text" id="volunteer-surname" placeholder="Sobrenome" required>
                            <span class="error-message" id="volunteer-surname-error"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="text" id="volunteer-username" placeholder="Nome de usuário" required>
                        <span class="error-message" id="volunteer-username-error"></span>
                    </div>
                    <div class="form-group">
                        <input type="email" id="volunteer-email" placeholder="E-mail" required>
                        <span class="error-message" id="volunteer-email-error"></span>
                    </div>
                    <div class="form-group">
                        <input type="date" id="volunteer-dob" required>
                        <label for="volunteer-dob" class="date-label">Data de Nascimento</label>
                        <span class="error-message" id="volunteer-dob-error"></span>
                    </div>
                    <div class="form-group">
                        <input type="password" id="volunteer-password" placeholder="Senha" required>
                        <span class="error-message" id="volunteer-password-error"></span>
                    </div>
                    <div class="form-group">
                        <input type="password" id="volunteer-confirm-password" placeholder="Confirmar Senha" required>
                        <span class="error-message" id="volunteer-confirm-password-error"></span>
                    </div>
                    <button type="submit">Próximo</button>
                </form>
            </section>

            <section id="volunteer-register-section-2">
                <div class="top-form">
                    <button class="back-button"><i class="fas fa-arrow-left"></i></button>
                    <h2>Cadastro de Voluntário</h2>
                </div>
                <form id="volunteer-register-form-2">
                    <div class="form-row div-images-input">
                        <div class="form-group div-profile-image-input">
                            <label for="volunteer-profile-pic" class="pic-label">Foto de Perfil</label>
                            <input type="file" id="volunteer-profile-pic" accept="image/*">
                        </div>
                        <div class="form-group div-header-image-input">
                            <label for="volunteer-header" class="pic-label">Imagem de Capa</label>
                            <input type="file" id="volunteer-header" accept="image/*">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="textarea-container">
                            <textarea id="volunteer-description" rows="4" placeholder="Descrição"></textarea>
                            <div class="char-counter">
                                <span id="charCount1"></span>
                            </div>
                        </div>
                        
                    </div>
                    <button type="submit">Finalizar Cadastro</button>
                </form>
            </section>

            <section id="institution-register-section-1">
                <div class="top-form">
                    <button class="back-button"><i class="fas fa-arrow-left"></i></button>
                    <h2>Cadastro de Instituição</h2>
                </div>
                <form id="institution-register-form-1">
                    <div class="form-group">
                        <input type="text" id="institution-name" placeholder="Nome da Instituição" required>
                        <span class="error-message" id="institution-name-error"></span>
                    </div>
                    <div class="form-group">
                        <div class="multiselect" id="multiselect-category">
                            <div class="multiselect-toggle" >Selecione as categorias</div>
                            <div class="multiselect-dropdown">
                                <?php foreach ($categorias as $categoria): ?>
                                    <label class="multiselect-option">
                                        <input type="checkbox" value="<?php echo htmlspecialchars($categoria['id']); ?>">
                                        <?php echo htmlspecialchars($categoria['nome']); ?>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <span class="error-message" id="institution-category-error"></span>
                    </div>                    
                    <div class="form-row">
                        <div class="form-group">
                            <input type="text" id="institution-owner" placeholder="Nome do Proprietário" required>
                            <span class="error-message" id="institution-owner-error"></span>
                        </div>
                        <div class="form-group">
                            <input type="text" id="institution-cnpj" placeholder="CNPJ" required>
                            <span class="error-message" id="institution-cnpj-error"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="text" id="institution-location" placeholder="Localização" required>
                        <span class="error-message" id="institution-location-error"></span>
                    </div>
                    <div class="form-group">
                        <input type="email" id="institution-email" placeholder="E-mail" required>
                        <span class="error-message" id="institution-email-error"></span>
                    </div>
                    <div class="form-group">
                        <input type="password" id="institution-password" placeholder="Senha" required>
                        <span class="error-message" id="institution-password-error"></span>
                    </div>
                    <div class="form-group">
                        <input type="password" id="institution-confirm-password" placeholder="Confirmar Senha" required>
                        <span class="error-message" id="institution-confirm-password-error"></span>
                    </div>
                    <button type="submit">Próximo</button>
                </form>
            </section>

            <section id="institution-register-section-2">
                <div class="top-form">
                    <button class="back-button"><i class="fas fa-arrow-left"></i></button>
                    <h2>Cadastro de Instituição</h2>
                </div>
                <form id="institution-register-form-2">
                    <div class="form-group">
                        <div class="multiselect" id="multiselect-donation">
                            <div class="multiselect-toggle" >Selecione tipos de doação</div>
                            <div class="multiselect-dropdown">
                                <?php foreach ($necessidades as $necessidade): ?>
                                    <label class="multiselect-option">
                                        <input type="checkbox" value="<?php echo htmlspecialchars($necessidade['id']); ?>">
                                        <?php echo htmlspecialchars($necessidade['nome']); ?>
                                        <input type="number" class="need-quantity" min="1" placeholder="Quantidade">
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <span class="error-message" id="institution-donation-error"></span>
                    </div>

                    <div class="form-group">
                        <div class="textarea-container">
                            <textarea id="institution-mission" rows="4" placeholder="Missão da Instituição" required></textarea>
                            <div class="char-counter">
                                <span id="charCount2"></span>
                            </div>
                        </div>
                        
                        <span class="error-message" id="institution-mission-error"></span>
                    </div>
                    <div class="form-group">
                        <div class="textarea-container">
                            <textarea id="institution-needs" rows="4" placeholder="Principais Necessidades" required></textarea>
                            <div class="char-counter">
                                <span id="charCount3"></span>
                            </div>
                        </div>
                        
                        <span class="error-message" id="institution-needs-error"></span>
                    </div>
                    <div class="form-group">
                        <label>Áreas de Atuação</label>
                        <div class="checkbox-group">
                            <input type="checkbox" id="area-local" name="areas" value="local">
                            <label for="area-local">Local</label>
                            <input type="checkbox" id="area-regional" name="areas" value="regional">
                            <label for="area-regional">Regional</label>
                            <input type="checkbox" id="area-nacional" name="areas" value="nacional">
                            <label for="area-nacional">Nacional</label>
                            <input type="checkbox" id="area-internacional" name="areas" value="internacional">
                            <label for="area-internacional">Internacional</label>
                        </div>
                        <span class="error-message" id="institution-areas-error"></span>
                    </div>
                    <button type="submit">Próximo</button>
                </form>
            </section>

            <section id="institution-register-section-3">
                <div class="top-form">
                    <button class="back-button"><i class="fas fa-arrow-left"></i></button>
                    <h2>Cadastro de Instituição</h2>
                </div>
                <form id="institution-register-form-3">
                    <div class="form-row div-images-input">
                        <div class="form-group">
                            <label for="institution-profile-pic" class="pic-label">Foto de Perfil</label>
                            <input type="file" id="institution-profile-pic" accept="image/*">
                        </div>
                        <div class="form-group">
                            <label for="institution-header" class="pic-label">Imagem de Capa</label>
                            <input type="file" id="institution-header" accept="image/*">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="textarea-container">
                            <textarea id="institution-description" rows="4" placeholder="Descrição" required></textarea>
                            <div class="char-counter">
                                <span id="charCount4"></span>
                                
                            </div>
                        </div>
                        
                    </div>
                    <div class="form-group">
                        <input type="url" id="institution-website" placeholder="Website">
                    </div>
                    <div class="form-group">
                        <input type="text" id="institution-social-media" placeholder="Redes Sociais (Facebook, Instagram, Twitter, etc.)">
                    </div>
                    <button type="submit">Finalizar Cadastro</button>
                </form>
            </section>
        </main>
    </div>

    <script src="js/Login.js"></script>
</body>
</html>