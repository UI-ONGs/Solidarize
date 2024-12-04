document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM fully loaded. Starting fetch operation.');

    fetch('../Detalhes-Instituicao.php')
    fetch('../php/Obter-Localizacao.php')
        .then(response => {
            console.log('Received response:', response);
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.text();
        })
        .then(rawData => {
            console.log('Raw data received:', rawData);
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
            if (data.error) {
                throw new Error(data.error);
            }
            if (!data.localizacao) {
                throw new Error('Localização não encontrada');
            }

            const [lat, lon] = data.localizacao.split(',').map(coord => parseFloat(coord.trim()));
            console.log('Parsed coordinates:', { lat, lon });

            if (isNaN(lat) || isNaN(lon)) {
                throw new Error('Coordenadas inválidas');
            }

            return fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}&zoom=18&addressdetails=1`);
        })
        .then(response => {
            console.log('Received response from Nominatim:', response);
            if (!response.ok) {
                throw new Error('Erro na resposta do Nominatim');
            }
            return response.json();
        })
        .then(addressData => {
            console.log('Address data received:', addressData);
            const address = addressData.address;
            const street = address.road || '';
            const number = address.house_number || '';
            const neighborhood = address.suburb || address.neighbourhood || '';
            const city = address.city || address.town || '';
            const state = address.state || '';
            const postcode = address.postcode || '';

            const formattedAddress = `${street}${number ? ', ' + number : ''} - ${neighborhood}, ${city} - ${state}, ${postcode}`.replace(/^[\s,-]+|[\s,-]+$/g, '');
            console.log('Formatted address:', formattedAddress);

            const mapLink = `https://www.openstreetmap.org/?mlat=${addressData.lat}&mlon=${addressData.lon}&zoom=18`;
            console.log('Map link:', mapLink);
            document.getElementById('endereco').textContent = formattedAddress;
        })
        .catch(error => {
            console.error('Error:', error);
            
        });
});
