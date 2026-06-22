document.addEventListener("DOMContentLoaded", () => {

    /* ==== Smooth Scroll for Internal Links ==== */
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener("click", e => {
            const targetId = anchor.getAttribute("href");
            const targetElement = document.querySelector(targetId);

            if (targetElement) {
                e.preventDefault();
                targetElement.scrollIntoView({ behavior: "smooth" });
            }
        });
    });

    /* ==== Video Thumbnail Click Action ==== */
    document.querySelectorAll(".video-thumbnail").forEach(video => {
        video.addEventListener("click", () => {
            alert("🎥 Video Desa diputar di sini");
        });
    });

});