// ============================================
// RUPIAH FORMATTER (inline, no external dependency)
// ============================================
const formatRupiahInput = (angka) => {
    const number = angka.replace(/\D/g, '');
    return number.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
};

const parseRupiah = (formatted) => {
    return parseInt(formatted.replace(/\./g, ''), 10) || 0;
};

const formatRupiahDisplay = (num) => 'Rp ' + new Intl.NumberFormat('id-ID').format(num);

const initRupiahInput = (input) => {
    if (!input) return;

    if (input.value) {
        input.value = formatRupiahInput(input.value);
    }

    input.addEventListener('input', function(e) {
        const caret = this.selectionStart;
        const oldLen = this.value.length;
        const oldDots = (this.value.match(/\./g) || []).length;

        this.value = formatRupiahInput(this.value);

        const newDots = (this.value.match(/\./g) || []).length;
        const newLen = this.value.length;
        const offset = newDots - oldDots;
        const newCaret = caret + (newLen - oldLen) + offset;

        this.setSelectionRange(newCaret, newCaret);
    });

    input.addEventListener('paste', function(e) {
        e.preventDefault();
        const paste = (e.clipboardData || window.clipboardData).getData('text');
        this.value = formatRupiahInput(paste);
    });

    input.addEventListener('keypress', function(e) {
        if (!/[0-9]/.test(e.key) && e.key !== 'Backspace' && e.key !== 'Delete' && e.key !== 'Tab' && e.key !== 'ArrowLeft' && e.key !== 'ArrowRight') {
            e.preventDefault();
        }
    });
};


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

    // Init rupiah input
    initRupiahInput(nominalInput);

    let currentSisa = 0;

    sumberSelect?.addEventListener('change', () => {
        const selected = sumberSelect.options[sumberSelect.selectedIndex];
        if (selected && selected.value) {
            currentSisa = parseFloat(selected.dataset.sisa) || 0;
            if (sisaValue) sisaValue.textContent = formatRupiahDisplay(currentSisa);
            if (sisaInfo) sisaInfo.style.display = 'flex';
            if (nominalHint) nominalHint.textContent = `Maksimal: ${formatRupiahDisplay(currentSisa)}`;
            
            validateNominal();
        } else {
            if (sisaInfo) sisaInfo.style.display = 'none';
            currentSisa = 0;
        }
    });

    function validateNominal() {
        if (!nominalInput || !nominalHint || !btnSubmit) return;
        
        const val = parseRupiah(nominalInput.value);

        if (val > currentSisa && currentSisa > 0) {
            nominalInput.classList.add('is-invalid');
            nominalHint.innerHTML = `❌ Melebihi sisa! Maksimal: ${formatRupiahDisplay(currentSisa)}`;
            nominalHint.style.color = '#dc2626';
            btnSubmit.disabled = true;
            btnSubmit.style.opacity = '0.5';
        } else if (val < 0) {
            nominalInput.classList.add('is-invalid');
            nominalHint.innerHTML = '❌ Nominal tidak boleh negatif';
            nominalHint.style.color = '#dc2626';
            btnSubmit.disabled = true;
            btnSubmit.style.opacity = '0.5';
        } else {
            nominalInput.classList.remove('is-invalid');
            nominalHint.innerHTML = currentSisa > 0 ? `Maksimal: ${formatRupiahDisplay(currentSisa)}` : 'Maksimal sesuai sisa sumber dana';
            nominalHint.style.color = '#6b7280';
            btnSubmit.disabled = false;
            btnSubmit.style.opacity = '1';
        }
    }

    nominalInput?.addEventListener('input', validateNominal);

    const form = createWrapper.querySelector('#formAlokasi');
    form?.addEventListener('submit', (e) => {
        const val = parseRupiah(nominalInput.value);
        if (val > currentSisa && currentSisa > 0) {
            e.preventDefault();
            alert(`Nominal melebihi sisa sumber dana (${formatRupiahDisplay(currentSisa)})`);
            nominalInput.focus();
        }
    });

    if (sumberSelect?.value) {
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
        const progressPercent = showWrapper.querySelector('.progress-percent');
        const percentText = progressPercent ? progressPercent.textContent : '0%';
        const targetWidth = parseFloat(percentText) || 0;
        
        progressBar.style.width = targetWidth + '%';
        
        if (targetWidth >= 90) {
            progressBar.style.background = 'linear-gradient(90deg, #ef4444, #f59e0b)';
        } else if (targetWidth >= 70) {
            progressBar.style.background = 'linear-gradient(90deg, #f59e0b, #eab308)';
        } else {
            progressBar.style.background = 'linear-gradient(90deg, #3b82f6, #10b981)';
        }
    }

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

    // Init rupiah input
    initRupiahInput(nominalInput);

    alasanInput?.addEventListener('input', () => {
        if (alasanInput.value.length < 10) {
            alasanInput.classList.add('is-invalid');
        } else {
            alasanInput.classList.remove('is-invalid');
        }
    });

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

    const form = editWrapper.querySelector('#formEditAlokasi');
    form?.addEventListener('submit', (e) => {
        const alasan = alasanInput.value.trim();
        if (alasan.length < 10) {
            e.preventDefault();
            alert('Alasan perubahan minimal 10 karakter');
            alasanInput.focus();
        }
    });

    console.log('Pengalokasian Edit loaded');
}