function initMap() {
    
    // 1. Defina o centro do mapa (Ex: Centro de São Paulo)
    // Você deve alterar isso para a latitude/longitude da sua cidade/região
    const mapCenter = { lat: -23.550520, lng: -46.633308 };
    
    // 2. Crie o mapa dentro do <div id="map">
    const map = new google.maps.Map(document.getElementById("map"), {
        zoom: 14, // Nível de zoom (quanto maior, mais perto)
        center: mapCenter,
        mapId: 'SUA_MAP_ID_OPCIONAL' // Opcional: para customizar o estilo no Google Cloud
    });

    // 3. SEUS DADOS DE LOCALIZAÇÃO (EXEMPLO)
    // IMPORTANTE: Você deve buscar esses dados do seu banco de dados
    // e passá-los para o JavaScript (via AJAX ou json_encode do PHP).
    const locations = [
        { 
            position: { lat: -23.5615, lng: -46.6560 }, 
            title: 'Supermercado Exemplo 1', 
            type: 'Supermercado' 
        },
        { 
            position: { lat: -23.5555, lng: -46.6400 }, 
            title: 'Supermercado Perto Daqui', 
            type: 'Supermercado' 
        },
        { 
            position: { lat: -23.5630, lng: -46.6520 }, 
            title: 'Drogaria Saúde Total', 
            type: 'Drogarias' 
        },
        { 
            position: { lat: -23.5500, lng: -46.6390 }, 
            title: 'Consórcios & Cia', 
            type: 'Consórcios' 
        }
    ];

    // (Opcional) Ícones customizados para cada tipo
    // Você pode hospedar suas próprias imagens de ícones
    const icons = {
        Supermercado: 'http://maps.google.com/mapfiles/ms/icons/green-dot.png',
        Drogarias: 'http://maps.google.com/mapfiles/ms/icons/blue-dot.png',
        Consórcios: 'http://maps.google.com/mapfiles/ms/icons/yellow-dot.png'
    };

    // 4. Crie os marcadores (pins) no mapa
    locations.forEach(location => {
        const marker = new google.maps.Marker({
            position: location.position,
            map: map,
            title: location.title,
            icon: icons[location.type] || undefined // Define o ícone com base no tipo
        });

        // (Opcional) Adiciona uma janela de informação ao clicar no marcador
        const infoWindow = new google.maps.InfoWindow({
            content: `<h5 class="fw-bold">${location.title}</h5><p>${location.type}</p>`
        });

        marker.addListener('click', () => {
            infoWindow.open(map, marker);
        });
    });
}