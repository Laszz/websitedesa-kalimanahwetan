document.addEventListener("DOMContentLoaded", () => {
    window.confirmDelete = function(event) {
        return confirm('Yakin ingin menghapus syarat ini?');
    };

    console.log("Syarat Layanan loaded");
});