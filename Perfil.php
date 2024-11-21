<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <link rel="stylesheet" href="css/NavBar.css">
    <link rel="stylesheet" href="css/Perfil.css">
    <link rel="icon" href="imagens/logo.png">
    <script src="https://kit.fontawesome.com/0e6a916873.js" crossorigin="anonymous"></script>
    <script src="js/NavBar.js" defer></script>
    <script src="js/Perfil.js" defer></script>
    
</head>
<body>
    <!--Adicionando a navbar da página em pc-->
    <!-- Include navbar -->
    <?php include 'navbar.php'; ?>
    <div class="container">
        <div class="profile">
            <!--Header-->
            <div class="wallpaper">
                <img src="imagens/header.webp" alt="Wallpaper" id="wallpaperImg">
            </div>
            <!--Foto de Perfil-->
            <div class="profile-info">
                <div class="profile-photo-container">
                    <img src="imagens/gui_perfil.png" alt="Foto de perfil" class="profile-photo" id="profileImg">
                </div>
                <!--Username e nickname-->
                <div class="name-username">
                    <h1 class="name">Guilherme do Carmo Souza</h1>
                    <p class="username">@guilerme</p>
                </div>
                <!--Redes Sociais-->
                <div class="social-icons">
                    <a href="" id="instagramLink" target="_blank"><i class="fab fa-instagram"></i></a>
                    <a href="" id="facebookLink" target="_blank"><i class="fab fa-facebook"></i></a>
                    <a href="" id="whatsappLink" target="_blank"><i class="fab fa-whatsapp"></i></a>
                </div>
                <!--Edição de Perfil-->
                <button class="edit-profile">Editar Perfil</button>
                <!--Biografia-->
                <div class="bio">
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Aliquid aspernatur quae impedit architecto enim dolores. Eos nobis pariatur consequuntur beatae voluptatem magnam possimus doloremque labore quis. Doloribus corrupti dolorem ipsum.</p>
                </div>
            </div>
        </div>

        <!--Adicionando colaboradores -->
        <div class="collaborator">
            <h2>Colaborador nas Instituições:</h2>
            <div class="collaborator-slider">
                <div class="collaborator-item"><img src="imagens/gui_perfil.png" alt="Colaborador 1"></div>
                <div class="collaborator-item"><img src="imagens/dani_perfil.png" alt="Colaborador 2"></div>
                <div class="collaborator-item"><img src="imagens/isa_perfil2.png" alt="Colaborador 3"></div>
                <div class="collaborator-item"><img src="imagens/malu_perfil.png" alt="Colaborador 4"></div>
            </div>
        </div>
    </div>


    <!--Aba de Edição-->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Editar Perfil</h2>
            <div class="image-upload">
                <label for="profileImageUpload">Alterar foto de perfil</label>
                <input type="file" id="profileImageUpload" accept="image/*">
                <label for="wallpaperImageUpload">Alterar wallpaper</label>
                <input type="file" id="wallpaperImageUpload" accept="image/*">
            </div>
            <input type="text" id="editName" placeholder="Nome Completo">
            <input type="text" id="editUsername" placeholder="Username">
            <textarea id="editBio" placeholder="Bio" rows="4"></textarea>
            <input type="url" id="editInstagram" placeholder="Link do Instagram">
            <input type="url" id="editFacebook" placeholder="Link do Facebook">
            <input type="url" id="editWhatsapp" placeholder="Link do WhatsApp">
            <button id="saveProfile">Salvar</button>
        </div>
    </div>    
</body>
</html>
