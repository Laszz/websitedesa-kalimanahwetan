document.addEventListener('DOMContentLoaded', function() {
    
    // ========== AUTO-DISMISS ALERTS ==========
    const alerts = document.querySelectorAll('.jb-alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            const closeBtn = alert.querySelector('.btn-close');
            if (closeBtn) closeBtn.click();
        }, 5000);
    });

    // ========== FORMAT RIBUAN ANGGARAN PER KK ==========
    const displayInput = document.getElementById('anggaran_display');
    const realInput    = document.getElementById('anggaran_real');

    if (displayInput && realInput) {
        
        // Fungsi format: 6000000 → 6.000.000
        function formatRibuan(value) {
            const angka = value.replace(/\D/g, '');
            return angka.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        }

        // Saat user mengetik
        displayInput.addEventListener('input', function(e) {
            const posisi = this.selectionStart;
            const panjangSebelum = this.value.length;
            
            const nilaiBersih = this.value.replace(/\D/g, '');
            const nilaiFormat = formatRibuan(this.value);
            
            this.value = nilaiFormat;
            realInput.value = nilaiBersih;
            
            // Jaga posisi kursor biar nggak lompat ke akhir
            const panjangSesudah = nilaiFormat.length;
            const selisih = panjangSesudah - panjangSebelum;
            this.setSelectionRange(posisi + selisih, posisi + selisih);
        });

        // Pastikan hidden input bersih sebelum submit
        displayInput.closest('form').addEventListener('submit', function() {
            realInput.value = displayInput.value.replace(/\D/g, '');
        });
    }

    console.log('Jenis Bantuan Create JS loaded');
});