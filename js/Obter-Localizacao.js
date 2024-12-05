// Aguarda o carregamento completo do DOM antes de executar o código
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM fully loaded. Starting fetch operation.');

    // Envia uma requisição GET para o arquivo 
    fetch('../php/Obter-Localizacao.php')
    
        .then(response => {
            console.log('Received response:', response);
            // Verifica se a resposta foi bem-sucedida (status HTTP 2xx)
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            // Retorna o corpo da resposta como texto
            return response.text();
        })
        .then(rawData => {
            console.log('Raw data received:', rawData);
            // Tenta converter os dados recebidos em formato JSON
            try {
                return JSON.parse(rawData);
            } catch (e) {
                console.error('Error parsing JSON:', e);
                console.error('Raw data causing the error:', rawData);
                throw new Error('Invalid JSON response');
            }
        })
        .then(data => {
            console.log('Parsed data:', data);
            // Verifica se há um erro nos dados recebidos
            if (data.error) {
                throw new Error(data.error);
            }
            // Verifica se a localização foi encontrada nos dado
            if (!data.localizacao) {
                throw new Error('Localização não encontrada');
            }
            // Separa a string da localização em latitude e longitude e converte para números
            const [lat, lon] = data.localizacao.split(',').map(coord => parseFloat(coord.trim()));
            console.log('Cordenadas parseadas:', { lat, lon });

            if (isNaN(lat) || isNaN(lon)) {
                throw new Error('Coordenadas inválidas');
            }
            // Realiza uma requisição para o Nominatim (OpenStreetMap) para obter o endereço completo
            return fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}&zoom=18&addressdetails=1`);
        })
        .then(response => {
            console.log('Resposta recebida do Nominatim:', response);
            if (!response.ok) {
                throw new Error('Erro na resposta do Nominatim');
            }
            return response.json();
        })
        .then(addressData => {
            // Extrai os componentes do endereço (rua, número, bairro, cidade, estado, código postal)
            console.log('Dados do endereço recebidos:', addressData);
            const address = addressData.address;
            const street = address.road || '';
            const number = address.house_number || '';
            const neighborhood = address.suburb || address.neighbourhood || '';
            const city = address.city || address.town || '';
            const state = address.state || '';
            const postcode = address.postcode || '';

            const formattedAddress = `${street}${number ? ', ' + number : ''} - ${neighborhood}, ${city} - ${state}, ${postcode}`.replace(/^[\s,-]+|[\s,-]+$/g, '');
            console.log('ENdereço formatado:', formattedAddress);

            const mapLink = `https://www.openstreetmap.org/?mlat=${addressData.lat}&mlon=${addressData.lon}&zoom=18`;
            console.log('Link do Mapa:', mapLink);
        })
        .catch(error => {
            console.error('Error:', error);
            
        });
});
