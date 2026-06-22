import './bootstrap';
import Alpine from 'alpinejs';
import L from 'leaflet';
import 'leaflet/dist/leaflet.css';

window.Alpine = Alpine;
Alpine.start();

// Leaflet Map
const mapElement = document.getElementById('map');
if (mapElement) {
    const balaiDesa = [-7.41509, 109.3396];
    const map = L.map('map').setView(balaiDesa, 18);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    L.marker(balaiDesa).addTo(map)
        .bindPopup("<b>Balai Desa Kalimanah Wetan</b><br>Jl. Raya Mayjen Sungkono No.142, Dusun 2<br>📍 <a href='https://www.google.com/maps?q=-7.41509,109.3396' target='_blank' style='color:blue;text-decoration:underline'>Buka di Google Maps</a>")
        .openPopup();
}