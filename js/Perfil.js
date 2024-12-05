document.addEventListener('DOMContentLoaded', () => {
    const editProfileForm = document.getElementById('edit-profile-form');
    const editProfileButton = document.querySelector('.edit-profile');
    const editModal = document.getElementById('editModal');
    const closeModalButton = document.querySelector('.close');
    const bioTextarea = document.getElementById('editBio');
    const charCounter = document.createElement('span');
    const usernameInput = document.getElementById('editUsername');
    const usernameError = document.createElement('span');
    let originalFormData = new FormData(editProfileForm);

    // Setup character counter
    charCounter.className = 'char-counter';
    bioTextarea.parentNode.insertBefore(charCounter, bioTextarea.nextSibling);
    updateCharCount();

    // Setup username error message
    usernameError.className = 'error-message';
    usernameError.style.color = '#ff3860';
    usernameError.style.display = 'none';
    usernameInput.parentNode.insertBefore(usernameError, usernameInput.nextSibling);

    function updateCharCount() {
        const length = bioTextarea.value.length;
        const maxLength = 150;
        charCounter.textContent = `${length}/${maxLength}`;
        
        if (length < 0) {
            charCounter.style.color = '#ff3860';
            bioTextarea.setCustomValidity('Bio deve ter pelo menos 0 caracteres');
        } else if (length > maxLength) {
            charCounter.style.color = '#ff3860';
            bioTextarea.setCustomValidity('Bio deve ter no máximo 150 caracteres');
        } else {
            charCounter.style.color = '';
            bioTextarea.setCustomValidity('');
        }
    }

    bioTextarea.addEventListener('input', updateCharCount);

    // Check for changes in form
    function hasFormChanged() {
        const currentFormData = new FormData(editProfileForm);
        let hasChanged = false;

        for (let [key, value] of currentFormData.entries()) {
            if (originalFormData.get(key) !== value) {
                hasChanged = true;
                break;
            }
        }

        // Check file inputs separately
        const profilePic = document.getElementById('profileImageUpload').files[0];
        const coverPic = document.getElementById('wallpaperImageUpload').files[0];
        if (profilePic || coverPic) {
            hasChanged = true;
        }

        return hasChanged;
    }

    editProfileButton.addEventListener('click', () => {
        editModal.style.display = 'block';
        // armazena os dados antigos quando o modal é aberto
        originalFormData = new FormData(editProfileForm);
    });

    closeModalButton.addEventListener('click', () => {
        editModal.style.display = 'none';
    });

    window.addEventListener('click', (event) => {
        if (event.target === editModal) {
            editModal.style.display = 'none';
        }
    });

    // validação do nome de usuário
    let usernameTimeout;
    usernameInput.addEventListener('input', () => {
        clearTimeout(usernameTimeout);
        usernameTimeout = setTimeout(async () => {
            const username = usernameInput.value;
            if (username === originalFormData.get('username')) {
                usernameError.style.display = 'none';
                return;
            }

            try {
                const response = await fetch('../php/validate_fields.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ field: 'username', value: username })
                });

                const data = await response.json();
                if (!data.isUnique) {
                    usernameError.textContent = 'Este username já está em uso.';
                    usernameError.style.display = 'block';
                    usernameInput.setCustomValidity('Username já em uso');
                } else {
                    usernameError.style.display = 'none';
                    usernameInput.setCustomValidity('');
                }
            } catch (error) {
                console.error('Error validating username:', error);
            }
        }, 500);
    });

    editProfileForm.addEventListener('submit', async (e) => {
        e.preventDefault();

        if (!hasFormChanged()) {
            alert('Nenhuma alteração foi feita.');
            return;
        }

        const formData = new FormData(editProfileForm);

        try {
            const response = await fetch('../php/edit_profile.php', {
                method: 'POST',
                body: formData
            });

            const result = await response.json();

            if (result.success) {
                alert(result.message);
                location.reload();
            } else {
                alert(result.message);
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Ocorreu um erro ao atualizar o perfil.');
        }
    });

    // preview da imagem
    const profileImageUpload = document.getElementById('profileImageUpload');
    const wallpaperImageUpload = document.getElementById('wallpaperImageUpload');
    const profileImg = document.getElementById('profileImg');
    const wallpaperImg = document.getElementById('wallpaperImg');

    profileImageUpload.addEventListener('change', (e) => {
        previewImage(e.target, profileImg);
    });

    wallpaperImageUpload.addEventListener('change', (e) => {
        previewImage(e.target, wallpaperImg);
    });

    function previewImage(input, imgElement) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = (e) => {
                imgElement.src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    const deactivateButton = document.querySelector('.deactivate-account');
const deactivateModal = document.getElementById('deactivateModal');
const confirmDeactivateButton = document.getElementById('confirmDeactivate');
const cancelDeactivateButton = document.getElementById('cancelDeactivate');
const deactivateModalClose = deactivateModal.querySelector('.close');

// mostra o modal para ativar a conta
deactivateButton.addEventListener('click', () => {
    deactivateModal.style.display = 'block';
});

// esconde o modal para desativar a conta
function hideDeactivateModal() {
    deactivateModal.style.display = 'none';
}

    deactivateModalClose.addEventListener('click', hideDeactivateModal);
    cancelDeactivateButton.addEventListener('click', hideDeactivateModal);

    window.addEventListener('click', (event) => {
        if (event.target === deactivateModal) {
            hideDeactivateModal();
        }
    });

    // lida com o desativamento da conta
    confirmDeactivateButton.addEventListener('click', async () => {
        try {
            const response = await fetch('../php/deactivate_account.php', {
                method: 'POST'
            });

            const result = await response.json();

            if (result.success) {
                alert(result.message);
                window.location.href = '../Login.php';
            } else {
                alert(result.message);
                hideDeactivateModal();
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Ocorreu um erro ao desativar a conta. Por favor, tente novamente.');
            hideDeactivateModal();
        }
    });

});

