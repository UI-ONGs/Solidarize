// Estamos pegando todos os elementos que podem ser alterados
const modal = document.getElementById("editModal");
const btn = document.querySelector(".edit-profile");
const span = document.getElementsByClassName("close")[0];
const saveBtn = document.getElementById("saveProfile");
const profileImageUpload = document.getElementById("profileImageUpload");
const wallpaperImageUpload = document.getElementById("wallpaperImageUpload");

// Tela de alteração abre e é possível modificar os dados
btn.onclick = function() {
    console.log("a");
    modal.style.display = "block";
    document.getElementById("editName").value = document.querySelector(".name").textContent;
    document.getElementById("editUsername").value = document.querySelector(".username").textContent.slice(1);
    document.getElementById("editBio").value = document.querySelector(".bio p").textContent;
    document.getElementById("editInstagram").value = removeDomain(document.getElementById("instagramLink").href);
    document.getElementById("editFacebook").value = removeDomain(document.getElementById("facebookLink").href);
    document.getElementById("editWhatsapp").value = removeDomain(document.getElementById("whatsappLink").href);
}
// Verificação do dominio da pagina
function removeDomain(url) {
    const domain = 'https://ui-ongs.github.io/UI-PwbAval/Perfil.html';
    return url.startsWith(domain) ? url.replace(domain, '') : url;
}

// Ao abertar o botão  de sair da tela altereação, ela fechará
span.onclick = function() {
    modal.style.display = "none";
}

// Caso o usuário clique fora da janela de alteração, ela é fechada
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

// Salvando as alterações e as exibindo 
saveBtn.onclick = function() {
    const name = document.getElementById("editName").value;
    const username = document.getElementById("editUsername").value;
    const bio = document.getElementById("editBio").value;
    // verifica se já tem "https", caso não, adiciona
    const instagramLink = document.getElementById("editInstagram").value.startsWith('http') ? document.getElementById("editInstagram").value : 'https://' + document.getElementById("editInstagram").value;
    const facebookLink = document.getElementById("editFacebook").value.startsWith('http') ? document.getElementById("editFacebook").value : 'https://' + document.getElementById("editFacebook").value;
    const whatsappLink = document.getElementById("editWhatsapp").value.startsWith('http') ? document.getElementById("editWhatsapp").value : 'https://' + document.getElementById("editWhatsapp").value;

    document.querySelector(".name").textContent = name;
    document.querySelector(".username").textContent = "@" + username;
    document.querySelector(".bio p").textContent = bio;
    document.getElementById("instagramLink").href = instagramLink;
    document.getElementById("facebookLink").href = facebookLink;
    document.getElementById("whatsappLink").href = whatsappLink;

    modal.style.display = "none";
}

// Função pronta para alteração da imagem de perfil
profileImageUpload.onchange = function(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById("profileImg").src = e.target.result;
        }
        reader.readAsDataURL(file);
        
    }
}

// Função pronta para alteração da imagem de fundo
wallpaperImageUpload.onchange = function(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById("wallpaperImg").src = e.target.result;
        }
        reader.readAsDataURL(file);
    }
}
