document.addEventListener("DOMContentLoaded", function() {
    const modal = document.getElementById("previewModal");
    const closeBtn = document.querySelector(".close");
    
    // Buka modal
    window.openPreviewFromData = function(element) {
        const src = element.getAttribute('data-gambar');
        const title = element.getAttribute('data-judul');
        
        document.getElementById("previewImage").src = src;
        document.getElementById("previewTitle").textContent = title || '';
        modal.style.display = "block";
        document.body.style.overflow = "hidden";
    };
    
    // Tutup modal - klik tombol X
    closeBtn.addEventListener("click", function(e) {
        e.stopPropagation();
        modal.style.display = "none";
        document.body.style.overflow = "auto";
    });
    
    // Tutup modal - klik di luar gambar
    modal.addEventListener("click", function(event) {
        if (event.target === modal || event.target.classList.contains('preview-wrapper')) {
            modal.style.display = "none";
            document.body.style.overflow = "auto";
        }
    });
    
    // Tutup modal - tombol ESC
    document.addEventListener("keydown", function(event) {
        if (event.key === "Escape" && modal.style.display === "block") {
            modal.style.display = "none";
            document.body.style.overflow = "auto";
        }
    });
});