document.addEventListener("DOMContentLoaded", () => {
  // ===== Custom Popup =====
  function showPopup(title, text, type = 'info') {
    const overlay = document.getElementById("popupOverlay");
    const icon = document.getElementById("popupIcon");
    const titleEl = document.getElementById("popupTitle");
    const textEl = document.getElementById("popupText");

    const iconMap = {
      info: 'fa-circle-info',
      error: 'fa-circle-xmark',
      success: 'fa-circle-check',
      warning: 'fa-triangle-exclamation'
    };

    icon.className = 'popup-icon ' + type;
    icon.innerHTML = '<i class="fa-solid ' + (iconMap[type] || 'fa-circle-info') + '"></i>';

    titleEl.textContent = title;
    textEl.textContent = text;

    overlay.classList.add("active");
  }

  window.closePopup = function() {
    document.getElementById("popupOverlay").classList.remove("active");
  };

  document.getElementById("popupOverlay").addEventListener("click", function(e) {
    if (e.target === this) window.closePopup();
  });

  // ===== Map Setup =====
  const defaultLat = -7.41509;
  const defaultLng = 109.3396;

  const map = L.map("map").setView([defaultLat, defaultLng], 17);

  L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
    maxZoom: 19,
    attribution: '&copy; OpenStreetMap'
  }).addTo(map);

  let marker = L.marker([defaultLat, defaultLng], { draggable: true }).addTo(map);

  const latInput = document.getElementById("latitude");
  const lngInput = document.getElementById("longitude");
  const alamatInput = document.getElementById("alamat");

  latInput.value = defaultLat;
  lngInput.value = defaultLng;

  function updateAddress(lat, lng) {
    fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}`)
      .then(res => res.json())
      .then(data => {
        alamatInput.value = data.display_name || "Alamat tidak ditemukan";
        latInput.value = lat;
        lngInput.value = lng;
      })
      .catch(err => console.error("Gagal ambil alamat:", err));
  }

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

  updateAddress(defaultLat, defaultLng);

  map.on("click", function(e) {
    const { lat, lng } = e.latlng;
    marker.setLatLng([lat, lng]);
    updateAddress(lat, lng);
  });

  // ===== GPS Button =====
  const locateBtn = document.createElement("button");
  locateBtn.type = "button";
  locateBtn.innerHTML = "📍 Lokasi Saya";
  locateBtn.className = "btn-locate";
  locateBtn.style.cssText = "margin-top:8px;padding:8px 16px;background:#2563eb;color:#fff;border:none;border-radius:6px;cursor:pointer;font-size:14px;";

  locateBtn.addEventListener("click", () => {
    const isSecure = window.isSecureContext ||
                     location.hostname === 'localhost' ||
                     location.hostname === '127.0.0.1' ||
                     location.protocol === 'https:';

    if (!isSecure) {
      showPopup("Pilih Lokasi di Peta", "Klik peta untuk menandai lokasi Anda.", "warning");
      return;
    }

    if (!navigator.geolocation) {
      showPopup("GPS Tidak Tersedia", "Klik peta untuk memilih lokasi.", "error");
      return;
    }

    locateBtn.innerHTML = "⏳ Mendeteksi...";
    locateBtn.disabled = true;

    navigator.geolocation.getCurrentPosition(
      (position) => {
        const lat = position.coords.latitude;
        const lng = position.coords.longitude;
        marker.setLatLng([lat, lng]);
        map.setView([lat, lng], 17);
        updateAddress(lat, lng);
        locateBtn.innerHTML = "📍 Lokasi Saya";
        locateBtn.disabled = false;
        showPopup("Lokasi Dipilih", "Lokasi berhasil disimpan.", "success");
      },
      (error) => {
        locateBtn.innerHTML = "📍 Lokasi Saya";
        locateBtn.disabled = false;
        showPopup("GPS Tidak Tersedia", "Klik peta untuk memilih lokasi.", "error");
      },
      { enableHighAccuracy: true, timeout: 10000 }
    );
  });

  document.getElementById("map").after(locateBtn);

  // ===== Reset Button =====
  const resetBtn = document.createElement("button");
  resetBtn.type = "button";
  resetBtn.innerHTML = "🏠 Reset ke Balai Desa";
  resetBtn.className = "btn-reset";
  resetBtn.style.cssText = "margin-top:8px;margin-left:8px;padding:8px 16px;background:#6b7280;color:#fff;border:none;border-radius:6px;cursor:pointer;font-size:14px;";

  resetBtn.addEventListener("click", () => {
    marker.setLatLng([defaultLat, defaultLng]);
    map.setView([defaultLat, defaultLng], 17);
    updateAddress(defaultLat, defaultLng);
  });

  locateBtn.after(resetBtn);

  marker.on("dragend", function() {
    const { lat, lng } = marker.getLatLng();
    updateAddress(lat, lng);
  });

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