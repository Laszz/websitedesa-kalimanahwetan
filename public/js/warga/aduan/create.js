document.addEventListener("DOMContentLoaded", () => {
  console.log("Warga - Create Aduan loaded");

  // ====== TAMPILKAN ERROR VALIDASI LARAVEL ======
  if (window.laravelErrors && window.laravelErrors.length > 0) {
    let message = window.laravelErrors.join("\n");
    alert("⚠️ Ada error:\n\n" + message);
  }

  // ====== MAP SETUP ======
  const defaultLat = -7.41509;
  const defaultLng = 109.3396;

  const map = L.map("map").setView([defaultLat, defaultLng], 17);

  L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
    maxZoom: 19,
    attribution: '&copy; OpenStreetMap contributors'
  }).addTo(map);

  let marker = L.marker([defaultLat, defaultLng], { draggable: true }).addTo(map);

  const latInput = document.getElementById("latitude");
  const lngInput = document.getElementById("longitude");
  const alamatInput = document.getElementById("alamat");

  // Set default input koordinat
  latInput.value = defaultLat;
  lngInput.value = defaultLng;

  // ===== Reverse Geocoding: Koordinat -> Alamat =====
  function updateAddress(lat, lng) {
    fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}`)
      .then(res => res.json())
      .then(data => {
        alamatInput.value = data.display_name || "Alamat tidak ditemukan";
        latInput.value = lat;
        lngInput.value = lng;
      })
      .catch(err => {
        console.error("Gagal ambil alamat:", err);
      });
  }

  // ===== Forward Geocoding: Alamat -> Koordinat =====
  function searchAddress(query) {
    fetch(`https://nominatim.openstreetmap.org/search?format=jsonv2&q=${encodeURIComponent(query)}`)
      .then(res => res.json())
      .then(results => {
        if (results && results.length > 0) {
          const place = results[0];
          const lat = parseFloat(place.lat);
          const lng = parseFloat(place.lon);

          marker.setLatLng([lat, lng]);
          map.setView([lat, lng], 17);
          latInput.value = lat;
          lngInput.value = lng;
        }
      })
      .catch(err => console.error("Gagal mencari alamat:", err));
  }

  // Set default alamat di balai desa
  updateAddress(defaultLat, defaultLng);

  // ===== KLIK PETA → PINDAH MARKER =====
  map.on("click", function(e) {
    const { lat, lng } = e.latlng;
    marker.setLatLng([lat, lng]);
    updateAddress(lat, lng);
  });

  // ===== GPS: TOMBOL "LOKASI SAYA" =====
  const locateBtn = document.createElement("button");
  locateBtn.type = "button";
  locateBtn.innerHTML = "Lokasi Saya";
  locateBtn.className = "btn-locate";
  locateBtn.style.cssText = "margin-top:8px;padding:8px 16px;background:#2563eb;color:#fff;border:none;border-radius:6px;cursor:pointer;font-size:14px;";
  
  locateBtn.addEventListener("click", () => {
    if (!navigator.geolocation) {
      alert("Browser tidak mendukung GPS");
      return;
    }
    
    locateBtn.innerHTML = "Mendeteksi...";
    locateBtn.disabled = true;

    navigator.geolocation.getCurrentPosition(
      (position) => {
        const lat = position.coords.latitude;
        const lng = position.coords.longitude;
        
        marker.setLatLng([lat, lng]);
        map.setView([lat, lng], 17);
        updateAddress(lat, lng);
        
        locateBtn.innerHTML = "Lokasi Saya";
        locateBtn.disabled = false;
      },
      (error) => {
        alert("Gagal mendeteksi lokasi: " + error.message);
        locateBtn.innerHTML = "Lokasi Saya";
        locateBtn.disabled = false;
      },
      { enableHighAccuracy: true, timeout: 10000 }
    );
  });

  // Insert tombol setelah peta
  document.getElementById("map").after(locateBtn);

  // ===== TOMBOL RESET KE BALAI DESA =====
  const resetBtn = document.createElement("button");
  resetBtn.type = "button";
  resetBtn.innerHTML = "Reset ke Balai Desa";
  resetBtn.className = "btn-reset";
  resetBtn.style.cssText = "margin-top:8px;margin-left:8px;padding:8px 16px;background:#6b7280;color:#fff;border:none;border-radius:6px;cursor:pointer;font-size:14px;";
  
  resetBtn.addEventListener("click", () => {
    marker.setLatLng([defaultLat, defaultLng]);
    map.setView([defaultLat, defaultLng], 17);
    updateAddress(defaultLat, defaultLng);
  });

  locateBtn.after(resetBtn);

  // ===== MARKER DRAGGABLE → UPDATE ALAMAT =====
  marker.on("dragend", function() {
    const { lat, lng } = marker.getLatLng();
    updateAddress(lat, lng);
  });

  // ===== USER KETIK ALAMAT → UPDATE MARKER (delay 1 detik) =====
  let typingTimeout;
  alamatInput.addEventListener("input", () => {
    clearTimeout(typingTimeout);
    if (alamatInput.value.trim().length > 3) {
      typingTimeout = setTimeout(() => {
        searchAddress(alamatInput.value.trim());
      }, 1000);
    }
  });
});