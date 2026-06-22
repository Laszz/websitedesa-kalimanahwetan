document.addEventListener("DOMContentLoaded", function () {
    console.log("Halaman detail aduan sudah dimuat.");

    // klik gambar untuk fullscreen
    const img = document.querySelector(".aduan-image img");
    if (img) {
        img.addEventListener("click", () => {
            img.classList.toggle("fullscreen");
        });
    }
});
