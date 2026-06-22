document.addEventListener("DOMContentLoaded", () => {
    const alertCloses = document.querySelectorAll('.alert-close');
    const modal = document.getElementById("detailModal");
    const modalClose = document.getElementById("modalClose");
    const showButtons = document.querySelectorAll(".btn-show");

    // Close alert
    alertCloses.forEach(btn => {
        btn.addEventListener('click', function() {
            this.closest('.aduan-alert').style.display = 'none';
        });
    });

    // Auto-hide alert after 5 seconds
    setTimeout(() => {
        document.querySelectorAll('.aduan-alert').forEach(alert => {
            alert.style.opacity = '0';
            alert.style.transition = 'opacity 0.5s ease';
            setTimeout(() => alert.remove(), 500);
        });
    }, 5000);

    // === Modal Detail ===
    const openModal = (data) => {
        document.getElementById("modalJudul").textContent = data.judul;
        document.getElementById("modalNama").textContent = data.nama;
        document.getElementById("modalWa").textContent = data.nomor_wa;
        document.getElementById("modalAlamat").textContent = data.alamat;
        document.getElementById("modalKategori").textContent = data.kategori || '-';
        document.getElementById("modalPrioritas").textContent = data.prioritas;
        document.getElementById("modalStatus").textContent = data.status;
        document.getElementById("modalDetail").textContent = data.detail;
        document.getElementById("modalTanggal").textContent = data.tanggal;

        const imgContainer = document.getElementById("modalGambar");
        if (data.gambar) {
            imgContainer.innerHTML = `<img src="${data.gambar}" alt="Gambar Aduan">`;
        } else {
            imgContainer.innerHTML = '<span class="text-gray"><i class="fa-solid fa-image"></i> Tidak ada gambar</span>';
        }

        modal.classList.add("active");
        document.body.style.overflow = "hidden";
    };

    const closeModal = () => {
        modal.classList.remove("active");
        document.body.style.overflow = "";
    };

    showButtons.forEach((btn) => {
        btn.addEventListener("click", (e) => {
            e.stopPropagation();
            const data = JSON.parse(btn.dataset.aduan);
            openModal(data);
        });
    });

    modalClose.addEventListener("click", closeModal);
    modal.addEventListener("click", (e) => {
        if (e.target === modal) closeModal();
    });
    document.addEventListener("keydown", (e) => {
        if (e.key === "Escape" && modal.classList.contains("active")) closeModal();
    });

    // === Confirm Delete ===
    window.confirmDelete = function(event) {
        const judul = event.target.closest('.aduan-row')?.querySelector('.judul-text')?.textContent || 'aduan ini';
        
        if (typeof Swal !== "undefined") {
            Swal.fire({
                title: "Yakin hapus aduan?",
                text: `"${judul}" akan dihapus permanen!`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#ef4444",
                cancelButtonColor: "#6b7280",
                confirmButtonText: "Ya, hapus",
                cancelButtonText: "Batal",
            }).then((result) => {
                if (!result.isConfirmed) event.preventDefault();
            });
            return false; // Prevent default, Swal will handle it
        } else {
            return confirm(`Yakin ingin menghapus aduan "${judul}"?`);
        }
    };

    // === Highlight Row ===
    const rows = document.querySelectorAll(".aduan-table tbody tr");
    rows.forEach((row) => {
        row.addEventListener("click", (e) => {
            if (e.target.closest('.btn-action, .delete-form')) return;
            rows.forEach((r) => r.classList.remove("highlight"));
            row.classList.add("highlight");
        });
    });

    console.log("✨ Admin Kelola Aduan loaded");
});