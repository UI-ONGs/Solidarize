// Espera o DOM carregar completamente antes de executar o script
document.addEventListener('DOMContentLoaded', () => {
    // Objeto com referências para todas as seções do formulário
    const sections = {
        login: document.getElementById('login-section'),
        registerType: document.getElementById('register-type-section'),
        volunteerRegister1: document.getElementById('volunteer-register-section-1'),
        volunteerRegister2: document.getElementById('volunteer-register-section-2'),
        institutionRegister1: document.getElementById('institution-register-section-1'),
        institutionRegister2: document.getElementById('institution-register-section-2'),
        institutionRegister3: document.getElementById('institution-register-section-3'),
        forgotPassword: document.getElementById('forgot-password-section')
    };
    
    let users = []; // Array para armazenar os usuários
    let tempFormData = {}; // Objeto para armazenar dados temporários do formulário
    let isSubmitting = false; // Flag para evitar submissões múltiplas

    // Inicialização
    init();

    // Função de inicialização
    function init() {
        checkLoggedInUser();
        loadUsers();
        setupTextareas();
        setupEventListeners();
        loadCategorias();
        loadNecessidades();
    }

    // Verifica se há um usuário logado
    function checkLoggedInUser() {
        const loggedInUser = localStorage.getItem('loggedInUser') || sessionStorage.getItem('loggedInUser');
        if (loggedInUser) {
            window.location.href = 'profile.html';
        }
    }

    // Carrega usuários do localStorage
    function loadUsers() {
        try {
            const storedUsers = localStorage.getItem('users');
            if (storedUsers) {
                users = JSON.parse(storedUsers);
            }
        } catch (error) {
            console.error('Erro ao carregar usuários do localStorage:', error);
        }
    }

    // Configura as áreas de texto com contagem de caracteres
    function setupTextareas() {
        const textareas = [
            { id: 'volunteer-description', min: 0, max: 150 },
            { id: 'institution-mission', min: 200, max: 1000 },
            { id: 'institution-needs', min: 150, max: 800 },
            { id: 'institution-description', min: 300, max: 2000 }
        ];

        textareas.forEach(({ id, min, max }) => {
            setupTextarea(id, min, max);
        });
    }

    // Configura os eventos de clique e submissão
    function setupEventListeners() {
        document.getElementById('show-register').addEventListener('click', () => showSection('registerType'));
        document.getElementById('volunteer-button').addEventListener('click', () => showSection('volunteerRegister1'));
        document.getElementById('institution-button').addEventListener('click', () => showSection('institutionRegister1'));
        document.getElementById('show-forgot-password').addEventListener('click', () => showSection('forgotPassword'));

        document.querySelectorAll('.back-button').forEach(button => {
            button.addEventListener('click', handleBackButton);
        });

        const forms = [
            'login-form', 'volunteer-register-form-1', 'volunteer-register-form-2', 
            'institution-register-form-1', 'institution-register-form-2', 'institution-register-form-3',
            'forgot-password-form'
        ];

        forms.forEach(formId => {
            document.getElementById(formId).addEventListener('submit', handleFormSubmit);
        });

        ['multiselect-category', 'multiselect-donation'].forEach(id => setupMultiselect(id));

        document.querySelectorAll('input[type="file"]').forEach(input => {
            input.addEventListener('change', handleFileInput);
        });
    }

    // Função para mostrar uma seção específica
    function showSection(sectionName) {
        Object.values(sections).forEach(section => section.classList.remove('active'));
        sections[sectionName].classList.add('active');
    }

    // Função para lidar com o botão de voltar
    function handleBackButton() {
        const currentSection = document.querySelector('section.active');
        if (currentSection.id.includes('volunteer')) {
            showSection(currentSection.id === 'volunteer-register-section-1' ? 'registerType' : 'volunteerRegister1');
        } else if (currentSection.id.includes('institution')) {
            const sectionNumber = currentSection.id.slice(-1);
            showSection(sectionNumber === '1' ? 'registerType' : `institutionRegister${parseInt(sectionNumber) - 1}`);
        } else if (currentSection.id === 'forgot-password-section') {
            showSection('login');
        }
    }

    // Função para mostrar mensagens de erro ou sucesso
    function showMessage(elementId, message, isError) {
        const errorElement = document.getElementById(`${elementId}-error`);
        if (errorElement) {
            errorElement.textContent = message;
            errorElement.style.color = isError ? '#ff3860' : '#4CAF50';
            errorElement.style.display = message ? 'block' : 'none';
        }
    }

    // Funções de validação
    const validators = {
        email: email => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email),
        password: password => password.length >= 8,
        username: username => username.length >= 3,
        cnpj: cnpj => /^\d{14}$/.test(cnpj),
        age: dob => {
            const today = new Date();
            const birthDate = new Date(dob);
            let age = today.getFullYear() - birthDate.getFullYear();
            const monthDiff = today.getMonth() - birthDate.getMonth();
            if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                age--;
            }
            return age >= 18;
        }
    };

    // Função para configurar áreas de texto com contagem de caracteres
    function setupTextarea(textareaId, minChars, maxChars) {
        const textarea = document.getElementById(textareaId);
        if (!textarea) return;

        const charCountId = `charCount${textareaId.slice(-1)}`;
        let charCount = document.getElementById(charCountId);

        if (!charCount) {
            charCount = document.createElement('span');
            charCount.id = charCountId;
            charCount.className = 'char-counter';
            textarea.parentNode.insertBefore(charCount, textarea.nextSibling);
        }

        textarea.setAttribute('minlength', minChars);
        textarea.setAttribute('maxlength', maxChars);

        function updateCharCount() {
            const length = textarea.value.length;
            charCount.textContent = `${length}/${maxChars}`;
        }

        textarea.addEventListener('input', updateCharCount);
        updateCharCount();
    }

    // Função para validar o comprimento de uma área de texto
    function validateTextareaLength(textareaId, minChars, maxChars) {
        const textarea = document.getElementById(textareaId);
        if (!textarea) return false;
        const length = textarea.value.length;
        return length >= minChars && length <= maxChars;
    }

    // Function to validate username, email, and CNPJ with the server
    async function validateUniqueField(field, value) {
        try {
            const response = await fetch('../php/validate_fields.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ field, value })
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.json();
            console.log('Validation response:', data); // For debugging
            return data.isUnique;
        } catch (error) {
            console.error('Error validating field:', error);
            return true; // Assume it's unique if there's an error to prevent blocking registration
        }
    }

    // Função para configurar campos de seleção múltipla
    function setupMultiselect(multiselectId) {
        const multiselect = document.querySelector(`#${multiselectId}`);
        const toggle = multiselect.querySelector('.multiselect-toggle');

        toggle.addEventListener('click', () => multiselect.classList.toggle('open'));

        document.addEventListener('click', event => {
            if (!multiselect.contains(event.target)) {
                multiselect.classList.remove('open');
            }
        });
    }

    // Função para obter opções selecionadas em campos de seleção múltipla
    function getSelectedOptions(multiselectId) {
        const multiselect = document.querySelector(`#${multiselectId}`);
        return Array.from(multiselect.querySelectorAll('input[type="checkbox"]:checked'))
            .map(option => option.parentNode.textContent.trim());
    }

    // Função para salvar usuários no localStorage
    function saveUsers() {
        try {
            localStorage.setItem('users', JSON.stringify(users));
        } catch (error) {
            console.error('Erro ao salvar usuários no localStorage:', error);
            if (error instanceof DOMException && error.name === 'QuotaExceededError') {
                users.shift(); // Remove o usuário mais antigo se o armazenamento estiver cheio
                saveUsers();
            }
        }
    }

    // Função para converter arquivo em Base64
    async function convertToBase64(file) {
        return new Promise((resolve, reject) => {
            const reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = () => resolve(reader.result);
            reader.onerror = error => reject(error);
        });
    }

    // Função para gerar token de autenticação
    function generateToken() {
        return Array.from(crypto.getRandomValues(new Uint8Array(16)), b => b.toString(16).padStart(2, '0')).join('');
    }

    // Função para limpar campos do formulário
    function clearFormFields(formId) {
        const form = document.getElementById(formId);
        if (form) {
            form.reset();
            form.querySelectorAll('input[type="text"], input[type="email"], input[type="password"], textarea').forEach(input => {
                input.value = '';
            });
            form.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
                checkbox.checked = false;
            });
            form.querySelectorAll('.image-preview').forEach(preview => {
                preview.remove();
            });
        }
    }

    // Função principal para lidar com submissões de formulário
    async function handleFormSubmit(event) {
        event.preventDefault();
        if (isSubmitting) return;
        isSubmitting = true;

        const formId = event.target.id;
        let isValid = true;
        const submitButton = event.target.querySelector('button[type="submit"]');
        submitButton.disabled = true;

        try {
            switch (formId) {
                case 'login-form':
                    isValid = await handleLogin();
                    break
                case 'volunteer-register-form-1':
                    isValid = await handleVolunteerRegister1();
                    break;
                case 'volunteer-register-form-2':
                    await handleVolunteerRegister2();
                    break;
                case 'institution-register-form-1':
                    isValid = await handleInstitutionRegister1();
                    break;
                case 'institution-register-form-2':
                    isValid = handleInstitutionRegister2();
                    break;
                case 'institution-register-form-3':
                    await handleInstitutionRegister3();
                    break;
                case 'forgot-password-form':
                    await handleForgotPassword();
                    break;
            }

            if (isValid) {
                if (formId.includes('register') && !formId.endsWith('2')) {
                    // Se for um formulário de registro e não for o último passo, não limpe os campos
                    submitButton.disabled = false;
                } else {
                    clearFormFields(formId);
                }
            } else {
                submitButton.disabled = false;
            }
        } catch (error) {
            console.error('Erro ao processar o formulário:', error);
            showMessage(formId, 'Ocorreu um erro ao processar o formulário. Por favor, tente novamente.', true);
            submitButton.disabled = false;
        } finally {
            isSubmitting = false;
        }
    }

    // Função para lidar com o login
    async function handleLogin() {
        const email = document.getElementById('login-email').value;
        const password = document.getElementById('login-password').value;
        const stayConnected = document.getElementById('stay-signed-in').checked;
    
        const loginData = {
            email: email,
            password: password,
            stayConnected: stayConnected
        };
    
        try {
            const response = await fetch('../php/login.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(loginData)
            });
    
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
    
            const data = await response.json();
    
            if (data.success) {
                showMessage('login-password', data.message, false);
                // Redirect after a short delay to show the success message
                setTimeout(() => {
                    window.location.href = '../Perfil.php';
                }, 1500);
            } else {
                showMessage('login-password', data.message, true);
            }
        } catch (error) {
            console.error('Erro ao fazer login:', error);
            showMessage('login-password', 'Ocorreu um erro ao fazer login. Por favor, tente novamente.', true);
        }
    }

    async function loadCategorias() {
        try {
            const response = await fetch('../php/functions.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ action: 'getCategorias' })
            });
            
            const data = await response.json();
            if (data.success) {
                const dropdown = document.querySelector('#multiselect-category .multiselect-dropdown');
                dropdown.innerHTML = data.data.map(category => `
                    <label class="multiselect-option">
                        <input type="checkbox" value="${category.id}"> ${category.nome}
                    </label>
                `).join('');
            }
        } catch (error) {
            console.error('Error loading categories:', error);
        }
    }
    
    async function loadNecessidades() {
        try {
            const response = await fetch('../php/functions.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ action: 'getNecessidades' })
            });
            
            const data = await response.json();
            if (data.success) {
                const dropdown = document.querySelector('#multiselect-donation .multiselect-dropdown');
                dropdown.innerHTML = data.data.map(need => `
                    <label class="multiselect-option">
                        <input type="checkbox" value="${need.id}"> ${need.nome}
                        <input type="number" class="need-quantity" min="1" placeholder="Quantidade">
                    </label>
                `).join('');
            }
        } catch (error) {
            console.error('Error loading needs:', error);
        }
    }

    // Função para lidar com o primeiro passo do registro de voluntário
    // Update handleVolunteerRegister1 function
    async function handleVolunteerRegister1() {
        const fields = ['name', 'surname', 'username', 'email', 'dob', 'password', 'confirm-password'].map(field => ({
            id: `volunteer-${field}`,
            value: document.getElementById(`volunteer-${field}`).value
        }));
    
        let isValid = true;
    
        // Validation of fields
        if (!validators.email(fields.find(f => f.id === 'volunteer-email').value)) {
            showMessage('volunteer-email', 'E-mail inválido.', true);
            isValid = false;
        }
    
        const password = fields.find(f => f.id === 'volunteer-password').value;
        const confirmPassword = fields.find(f => f.id === 'volunteer-confirm-password').value;
    
        if (!validators.password(password)) {
            showMessage('volunteer-password', 'A senha deve ter pelo menos 8 caracteres.', true);
            isValid = false;
        } else if (password !== confirmPassword) {
            showMessage('volunteer-password', 'As senhas não coincidem.', true);
            isValid = false;
        }
    
        if (!validators.username(fields.find(f => f.id === 'volunteer-username').value)) {
            showMessage('volunteer-username', 'O nome de usuário deve ter no mínimo 3 caracteres.', true);
            isValid = false;
        }
    
        if (!validators.age(fields.find(f => f.id === 'volunteer-dob').value)) {
            showMessage('volunteer-dob', 'Você deve ter pelo menos 18 anos para se cadastrar.', true);
            isValid = false;
        }
    
        if (!isValid) return false;
    
        // Check for unique username and email
        const isUsernameUnique = await validateUniqueField('username', fields.find(f => f.id === 'volunteer-username').value);
        const isEmailUnique = await validateUniqueField('email', fields.find(f => f.id === 'volunteer-email').value);

        if (!isUsernameUnique) {
            showMessage('volunteer-username', 'Este nome de usuário já está em uso.', true);
            return false;
        }

        if (!isEmailUnique) {
            showMessage('volunteer-email', 'Este e-mail já está cadastrado.', true);
            return false;
        }

        tempFormData = {
            type: 'volunteer',
            name: fields.find(f => f.id === 'volunteer-name').value,
            surname: fields.find(f => f.id === 'volunteer-surname').value,
            username: fields.find(f => f.id === 'volunteer-username').value,
            email: fields.find(f => f.id === 'volunteer-email').value,
            dob: fields.find(f => f.id === 'volunteer-dob').value,
            password: password
        };
    
        showSection('volunteerRegister2');
        return true;
    }


    // Função para lidar com o segundo passo do registro de voluntário
    async function handleVolunteerRegister2() {
        const profilePicFile = document.getElementById('volunteer-profile-pic').files[0];
        const headerImageFile = document.getElementById('volunteer-header').files[0];
    
        tempFormData.description = document.getElementById('volunteer-description').value;
    
        if (!validateTextareaLength('volunteer-description', 0, 150)) {
            showMessage('volunteer-description', 'A descrição deve ter no máximo 150 caracteres.', true);
            return;
        }
    
        const formData = new FormData();
        formData.append('action', 'registerVolunteer');
    
        // Adiciona todos os dados do tempFormData ao formData
        for (let key in tempFormData) {
            formData.append(key, tempFormData[key]);
        }
    
        // Adiciona os arquivos de imagem, se existirem
        if (profilePicFile) {
            formData.append('profilePic', profilePicFile);
        }
        if (headerImageFile) {
            formData.append('headerImage', headerImageFile);
        }
    
        try {
            const response = await fetch('../php/functions.php', {
                method: 'POST',
                body: formData
            });
    
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
    
            const text = await response.text();
            let data;
            try {
                data = JSON.parse(text);
            } catch (e) {
                console.error('Server response is not valid JSON:', text);
                throw new Error('Invalid server response');
            }
    
            if (data.success) {
                showMessage('volunteer-description', 'Cadastro de voluntário concluído!', false);
                setTimeout(() => {
                    showSection('login');
                    document.querySelector('#login-section button[type="submit"]').disabled = false;
                }, 1500);
            } else {
                showMessage('volunteer-description', data.message || 'Erro ao registrar voluntário.', true);
            }
        } catch (error) {
            console.error('Erro ao registrar voluntário:', error);
            showMessage('volunteer-description', 'Ocorreu um erro ao registrar. Por favor, tente novamente.', true);
        }
    }
    // Função para lidar com o primeiro passo do registro de instituição
    async function handleInstitutionRegister1() {
        const fields = ['name', 'owner', 'cnpj', 'location', 'email', 'password', 'confirm-password'].map(field => ({
            id: `institution-${field}`,
            value: document.getElementById(`institution-${field}`).value
        }));
    
        let isValid = true;
    
        // Validation of fields
        if (!validators.email(fields.find(f => f.id === 'institution-email').value)) {
            showMessage('institution-email', 'E-mail inválido.', true);
            isValid = false;
        }
    
        const password = fields.find(f => f.id === 'institution-password').value;
        const confirmPassword = fields.find(f => f.id === 'institution-confirm-password').value;
    
        if (!validators.password(password)) {
            showMessage('institution-password', 'A senha deve ter pelo menos 8 caracteres.', true);
            isValid = false;
        } else if (password !== confirmPassword) {
            showMessage('institution-password', 'As senhas não coincidem.', true);
            isValid = false;
        }
    
        if (!validators.cnpj(fields.find(f => f.id === 'institution-cnpj').value)) {
            showMessage('institution-cnpj', 'CNPJ inválido.', true);
            isValid = false;
        }
    
        const selectedCategories = getSelectedOptions('multiselect-category');
        if (selectedCategories.length === 0) {
            showMessage('institution-category', 'Selecione pelo menos uma categoria.', true);
            isValid = false;
        }
    
        if (!isValid) return false;
    
        // Check for unique email and CNPJ
        const isEmailUnique = await validateUniqueField('email', fields.find(f => f.id === 'institution-email').value);
        const isCnpjUnique = await validateUniqueField('cnpj', fields.find(f => f.id === 'institution-cnpj').value);
    
        if (!isEmailUnique) {
            showMessage('institution-email', 'Este e-mail já está cadastrado.', true);
            return false;
        }
    
        if (!isCnpjUnique) {
            showMessage('institution-cnpj', 'Este CNPJ já está cadastrado.', true);
            return false;
        }
    
        tempFormData = {
            type: 'institution',
            name: fields.find(f => f.id === 'institution-name').value,
            categories: selectedCategories,
            owner: fields.find(f => f.id === 'institution-owner').value,
            cnpj: fields.find(f => f.id === 'institution-cnpj').value,
            location: fields.find(f => f.id === 'institution-location').value,
            email: fields.find(f => f.id === 'institution-email').value,
            password: password
        };
    
        showSection('institutionRegister2');
        return true;
    }

    // Função para lidar com o segundo passo do registro de instituição
    function handleInstitutionRegister2() {
        tempFormData.donationTypes = getSelectedOptions('multiselect-donation');
        tempFormData.mission = document.getElementById('institution-mission').value;
        tempFormData.needs = document.getElementById('institution-needs').value;
        tempFormData.areas = Array.from(document.querySelectorAll('input[name="areas"]:checked')).map(checkbox => checkbox.value);

        if (!validateTextareaLength('institution-mission', 200, 1000)) {
            showMessage('institution-mission', 'A missão deve ter entre 200 e 1000 caracteres.', true);
            return false;
        }

        if (!validateTextareaLength('institution-needs', 150, 800)) {
            showMessage('institution-needs', 'As necessidades devem ter entre 150 e 800 caracteres.', true);
            return false;
        }

        showSection('institutionRegister3');
        return true;
    }

    // Função para lidar com o terceiro passo do registro de instituição
    async function handleInstitutionRegister3() {
        const profilePicFile = document.getElementById('institution-profile-pic').files[0];
        const headerImageFile = document.getElementById('institution-header').files[0];

        tempFormData.description = document.getElementById('institution-description').value;
        tempFormData.website = document.getElementById('institution-website').value;
        tempFormData.socialMedia = document.getElementById('institution-social-media').value;

        if (!validateTextareaLength('institution-description', 300, 2000)) {
            showMessage('institution-description', 'A descrição deve ter entre 300 e 2000 caracteres.', true);
            return;
        }

        const formData = new FormData();
        formData.append('action', 'registerInstitution');

        // Adiciona todos os dados do tempFormData ao formData
        for (let key in tempFormData) {
            formData.append(key, tempFormData[key]);
        }

        // Adiciona os arquivos de imagem, se existirem
        if (profilePicFile) {
            formData.append('profilePic', profilePicFile);
        }
        if (headerImageFile) {
            formData.append('headerImage', headerImageFile);
        }

        try {
            const response = await fetch('../php/functions.php', {
                method: 'POST',
                body: formData
            });

            const data = await response.json();

            if (data.success) {
                showMessage('institution-social-media', 'Cadastro de instituição concluído!', false);
                setTimeout(() => {
                    showSection('login');
                    document.querySelector('#login-section button[type="submit"]').disabled = false;
                }, 1500);
            } else {
                showMessage('institution-social-media', data.message || 'Erro ao registrar instituição.', true);
            }
        } catch (error) {
            console.error('Erro ao registrar instituição:', error);
            showMessage('institution-social-media', 'Ocorreu um erro ao registrar. Por favor, tente novamente.', true);
        }
    }

    // Função para lidar com a recuperação de senha
    function handleForgotPassword() {
        const email = document.getElementById('forgot-password-email').value;
        const user = users.find(u => u.email === email);

        if (user) {
            const resetToken = generateToken();
            const expirationTime = Date.now() + 3600000; // Token válido por uma hora

            user.resetToken = resetToken;
            user.resetTokenExpiration = expirationTime;
            saveUsers();

            // Mandar por email posteriormente
            console.log(`Senha restaurada: https://ilhe8l.github.io/Login-Testes/reset-password?token=${resetToken}`);

            showMessage('forgot-password-email', 'Um link de recuperação foi enviado para o seu e-mail.', false);
            setTimeout(() => {
                showSection('login');
            }, 3000);
        } else {
            showMessage('forgot-password-email', 'E-mail não encontrado.', true);
        }
    }

    // Função para lidar com a entrada de arquivos
    function handleFileInput(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = e => {
                const imgElement = document.createElement('img');
                imgElement.src = e.target.result;
                imgElement.className = 'image-preview';
                const existingPreview = event.target.parentElement.querySelector('.image-preview');
                if (existingPreview) {
                    existingPreview.remove();
                }
                event.target.parentElement.appendChild(imgElement);
            };
            reader.readAsDataURL(file);
        }
    }
});