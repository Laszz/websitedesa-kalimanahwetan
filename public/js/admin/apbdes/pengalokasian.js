// ============================================
// INDEX
// ============================================
const indexWrapper = document.querySelector('.pengalokasian-index');
if (indexWrapper) {
    
    const alerts = indexWrapper.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-10px)';
            alert.style.transition = 'all 0.3s ease';
            setTimeout(() => alert.remove(), 300);
        }, 5000);
    });

    const rows = indexWrapper.querySelectorAll('.data-table tbody tr');
    rows.forEach((row, index) => {
        row.style.opacity = '0';
        row.style.transform = 'translateX(-20px)';
        setTimeout(() => {
            row.style.transition = 'all 0.3s ease';
            row.style.opacity = '1';
            row.style.transform = 'translateX(0)';
        }, index * 50);
    });

    console.log('Pengalokasian Index loaded');
}

// ============================================
// CREATE
// ============================================
const createWrapper = document.querySelector('.pengalokasian-create');
if (createWrapper) {
    
    const sumberSelect = createWrapper.querySelector('#sumber_dana_id');
    const nominalInput = createWrapper.querySelector('#nominal');
    const sisaInfo = createWrapper.querySelector('#sisaInfo');
    const sisaValue = createWrapper.querySelector('#sisaValue');
    const nominalHint = createWrapper.querySelector('#nominalHint');
    const btnSubmit = createWrapper.querySelector('#btnSubmit');

    let currentSisa = 0;

    // Update sisa display when sumber dana changes
    sumberSelect.addEventListener('change', () => {
        const selected = sumberSelect.options[sumberSelect.selectedIndex];
        if (selected && selected.value) {
            currentSisa = parseFloat(selected.dataset.sisa) || 0;
            sisaValue.textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(currentSisa);
            sisaInfo.style.display = 'flex';
            nominalHint.textContent = `Maksimal: Rp ${new Intl.NumberFormat('id-ID').format(currentSisa)}`;
            
            // Validate current nominal
            validateNominal();
        } else {
            sisaInfo.style.display = 'none';
            currentSisa = 0;
        }
    });

    // Validate nominal against sisa
    function validateNominal() {
        const val = parseFloat(nominalInput.value) || 0;
        if (val > currentSisa) {
            nominalInput.classList.add('is-invalid');
            nominalHint.textContent = `❌ Melebihi sisa! Maksimal: Rp ${new Intl.NumberFormat('id-ID').format(currentSisa)}`;
            nominalHint.style.color = '#dc2626';
            btnSubmit.disabled = true;
            btnSubmit.style.opacity = '0.5';
        } else if (val < 0) {
            nominalInput.classList.add('is-invalid');
            nominalHint.textContent = '❌ Nominal tidak boleh negatif';
            nominalHint.style.color = '#dc2626';
            btnSubmit.disabled = true;
            btnSubmit.style.opacity = '0.5';
        } else {
            nominalInput.classList.remove('is-invalid');
            nominalHint.textContent = `Maksimal: Rp ${new Intl.NumberFormat('id-ID').format(currentSisa)}`;
            nominalHint.style.color = '#6b7280';
            btnSubmit.disabled = false;
            btnSubmit.style.opacity = '1';
        }
    }

    nominalInput.addEventListener('input', validateNominal);

    // Form validation
    const form = createWrapper.querySelector('#formAlokasi');
    form.addEventListener('submit', (e) => {
        const val = parseFloat(nominalInput.value) || 0;
        if (val > currentSisa) {
            e.preventDefault();
            alert(`Nominal melebihi sisa sumber dana (Rp ${new Intl.NumberFormat('id-ID').format(currentSisa)})`);
            nominalInput.focus();
        }
    });

    // Trigger change if old value exists
    if (sumberSelect.value) {
        sumberSelect.dispatchEvent(new Event('change'));
    }

    console.log('Pengalokasian Create loaded');
}

// ============================================
// SHOW
// ============================================
const showWrapper = document.querySelector('.pengalokasian-show');
if (showWrapper) {
    
    const progressBar = showWrapper.querySelector('.progress-bar-fill');
    
    if (progressBar) {
        // Ambil persen dari blade variable yang sudah di-render
        const progressPercent = showWrapper.querySelector('.progress-percent');
        const percentText = progressPercent ? progressPercent.textContent : '0%';
        const targetWidth = parseFloat(percentText) || 0;
        
        // Set width langsung tanpa requestAnimationFrame yang bermasalah
        progressBar.style.width = targetWidth + '%';
        
        // Color based on percentage
        if (targetWidth >= 90) {
            progressBar.style.background = 'linear-gradient(90deg, #ef4444, #f59e0b)';
        } else if (targetWidth >= 70) {
            progressBar.style.background = 'linear-gradient(90deg, #f59e0b, #eab308)';
        } else {
            progressBar.style.background = 'linear-gradient(90deg, #3b82f6, #10b981)';
        }
    }

    // Animate stat cards
    const statCards = showWrapper.querySelectorAll('.stat-card');
    statCards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        setTimeout(() => {
            card.style.transition = 'all 0.4s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });

    console.log('Pengalokasian Show loaded');
}

// ============================================
// EDIT
// ============================================
const editWrapper = document.querySelector('.pengalokasian-edit');
if (editWrapper) {
    
    const nominalInput = editWrapper.querySelector('#nominal');
    const alasanInput = editWrapper.querySelector('#alasan_perubahan');
    const statusSelect = editWrapper.querySelector('#status');

    // Validate alasan length
    alasanInput.addEventListener('input', () => {
        if (alasanInput.value.length < 10) {
            alasanInput.classList.add('is-invalid');
        } else {
            alasanInput.classList.remove('is-invalid');
        }
    });

    // Highlight changed fields
    const inputs = editWrapper.querySelectorAll('.form-input, .form-select, .form-textarea');
    inputs.forEach(input => {
        const originalValue = input.value;
        input.addEventListener('change', () => {
            if (input.value !== originalValue) {
                input.style.borderColor = '#3b82f6';
                input.style.background = '#eff6ff';
            } else {
                input.style.borderColor = '#d1d5db';
                input.style.background = '#fff';
            }
        });
    });

    // Form validation
    const form = editWrapper.querySelector('#formEditAlokasi');
    form.addEventListener('submit', (e) => {
        const alasan = alasanInput.value.trim();
        if (alasan.length < 10) {
            e.preventDefault();
            alert('Alasan perubahan minimal 10 karakter');
            alasanInput.focus();
        }
    });

    console.log('Pengalokasian Edit loaded');
}