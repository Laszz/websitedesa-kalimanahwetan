document.addEventListener("DOMContentLoaded", () => {
  console.log("Warga - Index Aduan loaded");

  // ===== 1. Efek click card =====
  document.querySelectorAll(".aduan-card").forEach(card => {
    card.addEventListener("click", (e) => {
      // Jangan trigger kalau click gambar (gambar punya handler sendiri)
      if (e.target.classList.contains("img-preview")) return;
      
      card.classList.add("active");
      setTimeout(() => card.classList.remove("active"), 200);
    });
  });

  // ===== 2. Lightbox gambar =====
  const images = document.querySelectorAll(".img-preview");
  
  images.forEach(img => {
    img.addEventListener("click", (e) => {
      e.stopPropagation(); // Biar gak trigger click card
      
      // Buat overlay lightbox
      const overlay = document.createElement("div");
      overlay.className = "img-lightbox-overlay";
      overlay.innerHTML = `
        <div class="img-lightbox-backdrop"></div>
        <img src="${img.src}" alt="${img.alt}" class="img-lightbox-img">
        <button class="img-lightbox-close">&times;</button>
      `;
      
      document.body.appendChild(overlay);
      document.body.style.overflow = "hidden"; // Lock scroll
      
      // Animasi masuk
      requestAnimationFrame(() => {
        overlay.classList.add("show");
      });
      
      // Close handler
      const close = () => {
        overlay.classList.remove("show");
        setTimeout(() => {
          overlay.remove();
          document.body.style.overflow = "";
        }, 300);
      };
      
      overlay.querySelector(".img-lightbox-backdrop").addEventListener("click", close);
      overlay.querySelector(".img-lightbox-close").addEventListener("click", close);
      document.addEventListener("keydown", (e) => {
        if (e.key === "Escape") close();
      }, { once: true });
    });
  });
});