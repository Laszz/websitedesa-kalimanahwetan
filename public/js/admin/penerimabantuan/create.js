document.addEventListener('DOMContentLoaded', function() {
    
    // Auto-isi desil dari data warga
    const wargaSelect = document.getElementById('warga-select');
    const desilSelect = document.getElementById('desil-select');
    
    if (wargaSelect && desilSelect) {
        wargaSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const desil = selectedOption.getAttribute('data-desil');
            
            if (desil) {
                desilSelect.value = desil;
                
                // Highlight effect
                desilSelect.classList.add('pb-desil-auto');
                setTimeout(() => {
                    desilSelect.classList.remove('pb-desil-auto');
                }, 800);
            }
        });
    }

    // Auto-dismiss alerts
    const alerts = document.querySelectorAll('.pb-alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            const closeBtn = alert.querySelector('.btn-close');
            if (closeBtn) closeBtn.click();
        }, 5000);
    });

    console.log('Penerima Bantuan Create JS loaded');
});