document.addEventListener("DOMContentLoaded", () => {

    const card = document.querySelector(".profile-card");
    if (card) {
        card.style.opacity = "0";
        card.style.transform = "translateY(20px)";
        card.style.transition = "opacity 0.6s ease, transform 0.6s ease";

        requestAnimationFrame(() => {
            card.style.opacity = "1";
            card.style.transform = "translateY(0)";
        });
    }

    const photo = document.getElementById("profilePhoto");
    if (photo) {
        photo.style.opacity = "0";
        photo.style.transition = "opacity 0.5s ease 0.3s";

        const showPhoto = () => {
            photo.style.opacity = "1";
        };

        if (photo.tagName === "IMG") {
            photo.onload = showPhoto;
            if (photo.complete) showPhoto();
        } else {
            setTimeout(showPhoto, 300);
        }
    }

    const rows = document.querySelectorAll(".profile-table tr");
    rows.forEach(row => {
        row.style.transition = "background-color 0.2s ease";
    });
});