document.addEventListener('DOMContentLoaded', () => {
    // Inject keyframes once
    if (!document.getElementById('realisasi-animations')) {
        const style = document.createElement('style');
        style.id = 'realisasi-animations';
        style.textContent = `
            @keyframes pulse { 0%, 100% { opacity: 1; } 50% { opacity: 0.7; } }
            @keyframes slideDown { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }
            @keyframes slideInRight { from { opacity: 0; transform: translateX(-20px); } to { opacity: 1; transform: translateX(0); } }
            @keyframes slideUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        `;
        document.head.appendChild(style);
    }

    // === UTILITIES ===
    const formatRupiah = (num) => 'Rp ' + new Intl.NumberFormat('id-ID').format(num);

    const initAlertClose = (container = document) => {
        container.querySelectorAll('.alert-close').forEach(btn => {
            btn.addEventListener('click', () => {
                const alert = btn.closest('.alert');
                if (!alert) return;
                alert.style.transition = 'all 0.3s ease';
                alert.style.opacity = '0';
                alert.style.transform = 'translateY(-10px)';
                setTimeout(() => alert.remove(), 300);
            });
        });
    };

    const autoDismissAlerts = (container = document, delay = 5000) => {
        container.querySelectorAll('.alert').forEach(alert => {
            setTimeout(() => {
                if (!alert.isConnected) return;
                alert.style.transition = 'all 0.3s ease';
                alert.style.opacity = '0';
                alert.style.transform = 'translateY(-10px)';
                setTimeout(() => { if (alert.isConnected) alert.remove(); }, 300);
            }, delay);
        });
    };

    const initFilePreview = (wrapper) => {
        const fileInput = wrapper.querySelector('#bukti_transaksi');
        const filePreview = wrapper.querySelector('#filePreview');
        if (!fileInput || !filePreview) return;

        fileInput.addEventListener('change', () => {
            const file = fileInput.files[0];
            if (file) {
                const sizeKB = (file.size / 1024).toFixed(1);
                filePreview.innerHTML = `<span class="file-preview-name"><i class="fas fa-file"></i> ${file.name}</span><span class="file-preview-size">${sizeKB} KB</span>`;
                filePreview.classList.add('active');
            } else {
                filePreview.classList.remove('active');
                filePreview.innerHTML = '';
            }
        });
    };

    const autoTriwulan = (bulanSelect, triwulanSelect) => {
        if (!bulanSelect || !triwulanSelect) return;
        bulanSelect.addEventListener('change', () => {
            const bulan = parseInt(bulanSelect.value);
            if (bulan >= 1 && bulan <= 3) triwulanSelect.value = 'I';
            else if (bulan >= 4 && bulan <= 6) triwulanSelect.value = 'II';
            else if (bulan >= 7 && bulan <= 9) triwulanSelect.value = 'III';
            else if (bulan >= 10 && bulan <= 12) triwulanSelect.value = 'IV';
        });
    };

    // === DATA COUNTER ANIMATION ===
    const animateCounter = (el, duration = 1500) => {
        const text = el.textContent;
        const match = text.match(/[\d.,]+/);
        if (!match) return;
        const raw = match[0].replace(/\./g, '').replace(/,/g, '.');
        const target = parseFloat(raw);
        if (isNaN(target)) return;

        const prefix = text.substring(0, text.indexOf(match[0]));
        const suffix = text.substring(text.indexOf(match[0]) + match[0].length);
        const startTime = performance.now();

        const step = (now) => {
            const elapsed = now - startTime;
            const progress = Math.min(elapsed / duration, 1);
            const eased = 1 - Math.pow(1 - progress, 3);
            const current = target * eased;
            el.textContent = prefix + new Intl.NumberFormat('id-ID').format(Math.floor(current)) + suffix;
            if (progress < 1) requestAnimationFrame(step);
        };
        requestAnimationFrame(step);
    };

    // ============================================
    // INDEX
    // ============================================
    const indexWrapper = document.querySelector('.realisasi-index');
    if (indexWrapper) {
        initAlertClose(indexWrapper);
        autoDismissAlerts(indexWrapper);

        const rows = indexWrapper.querySelectorAll('.data-table tbody tr');
        rows.forEach((row, i) => {
            row.style.opacity = '0';
            row.style.animation = `slideInRight 0.3s ease ${i * 0.05}s forwards`;
        });

        indexWrapper.querySelectorAll('.row-status-pending').forEach(row => {
            row.style.animation = 'pulse 2s infinite';
        });
    }

    // ============================================
    // CREATE
    // ============================================
    const createWrapper = document.querySelector('.realisasi-create');
    if (createWrapper) {
        initAlertClose(createWrapper);
        autoDismissAlerts(createWrapper);

        const alokasiSelect = createWrapper.querySelector('#pengalokasian_dana_id');
        const nominalInput = createWrapper.querySelector('#nominal_digunakan');
        const sisaInfo = createWrapper.querySelector('#sisaInfo');
        const sisaValue = createWrapper.querySelector('#sisaValue');
        const nominalHint = createWrapper.querySelector('#nominalHint');
        const btnSubmit = createWrapper.querySelector('#btnSubmit');
        const form = createWrapper.querySelector('#formRealisasi');

        let currentSisa = 0;

        const validateNominal = () => {
            const val = parseFloat(nominalInput?.value) || 0;
            if (!nominalHint || !btnSubmit) return;

            if (val > currentSisa && currentSisa > 0) {
                nominalInput?.classList.add('is-invalid');
                nominalHint.innerHTML = `<i class="fas fa-circle-xmark"></i> Melebihi sisa! Maksimal: ${formatRupiah(currentSisa)}`;
                nominalHint.classList.add('warning');
                btnSubmit.disabled = true;
            } else if (val < 0) {
                nominalInput?.classList.add('is-invalid');
                nominalHint.innerHTML = `<i class="fas fa-circle-xmark"></i> Nominal tidak boleh negatif`;
                nominalHint.classList.add('warning');
                btnSubmit.disabled = true;
            } else {
                nominalInput?.classList.remove('is-invalid');
                nominalHint.innerHTML = currentSisa > 0 ? `<i class="fas fa-info-circle"></i> Maksimal: ${formatRupiah(currentSisa)}` : '<i class="fas fa-info-circle"></i> Maksimal sesuai sisa alokasi';
                nominalHint.classList.remove('warning');
                btnSubmit.disabled = false;
            }
        };

        if (alokasiSelect) {
            alokasiSelect.addEventListener('change', () => {
                const selected = alokasiSelect.options[alokasiSelect.selectedIndex];
                if (selected?.value) {
                    currentSisa = parseFloat(selected.dataset.sisa) || 0;
                    if (sisaValue) sisaValue.textContent = formatRupiah(currentSisa);
                    if (sisaInfo) sisaInfo.style.display = 'flex';
                    validateNominal();
                } else {
                    if (sisaInfo) sisaInfo.style.display = 'none';
                    currentSisa = 0;
                }
            });
            if (alokasiSelect.value) alokasiSelect.dispatchEvent(new Event('change'));
        }

        nominalInput?.addEventListener('input', validateNominal);

        autoTriwulan(
            createWrapper.querySelector('#bulan'),
            createWrapper.querySelector('#triwulan')
        );

        initFilePreview(createWrapper);

        form?.addEventListener('submit', (e) => {
            const val = parseFloat(nominalInput?.value) || 0;
            if (val > currentSisa && currentSisa > 0) {
                e.preventDefault();
                alert(`Nominal melebihi sisa alokasi (${formatRupiah(currentSisa)})`);
                nominalInput?.focus();
            }
        });
    }

    // ============================================
    // SHOW
    // ============================================
    const showWrapper = document.querySelector('.realisasi-show');
    if (showWrapper) {
        initAlertClose(showWrapper);
        autoDismissAlerts(showWrapper);

        showWrapper.querySelectorAll('.stat-card').forEach((card, i) => {
            card.style.opacity = '0';
            card.style.animation = `slideUp 0.4s ease ${i * 0.1}s forwards`;
        });

        showWrapper.querySelectorAll('[data-counter]').forEach(el => {
            setTimeout(() => animateCounter(el), 400);
        });
    }

    // ============================================
    // EDIT
    // ============================================
    const editWrapper = document.querySelector('.realisasi-edit');
    if (editWrapper) {
        initAlertClose(editWrapper);
        autoDismissAlerts(editWrapper);

        initFilePreview(editWrapper);

        autoTriwulan(
            editWrapper.querySelector('#bulan'),
            editWrapper.querySelector('#triwulan')
        );

        editWrapper.querySelectorAll('.form-input, .form-select, .form-textarea').forEach(input => {
            input.dataset.originalValue = input.value;
            input.addEventListener('change', () => {
                if (input.value !== input.dataset.originalValue) {
                    input.style.borderColor = '#3b82f6';
                    input.style.background = '#eff6ff';
                } else {
                    input.style.borderColor = '';
                    input.style.background = '';
                }
            });
        });
    }

    // ============================================
    // VERIFY
    // ============================================
    const verifyWrapper = document.querySelector('.realisasi-verify');
    if (verifyWrapper) {
        initAlertClose(verifyWrapper);
        autoDismissAlerts(verifyWrapper);

        const radioCards = verifyWrapper.querySelectorAll('.radio-card');
        const alasanGroup = verifyWrapper.querySelector('#alasanGroup');
        const alasanInput = verifyWrapper.querySelector('#alasan_penolakan');
        const btnVerify = verifyWrapper.querySelector('#btnVerify');
        const form = verifyWrapper.querySelector('#formVerifikasi');

        radioCards.forEach(card => {
            card.addEventListener('click', () => {
                const input = card.querySelector('input[type="radio"]');
                if (!input) return;
                input.checked = true;

                radioCards.forEach(c => {
                    const radio = c.querySelector('input[type="radio"]');
                    if (radio && c !== card) radio.checked = false;
                });

                if (input.value === 'terverifikasi') {
                    if (alasanGroup) alasanGroup.style.display = 'none';
                    if (alasanInput) alasanInput.required = false;
                    if (btnVerify) {
                        btnVerify.innerHTML = '<i class="fas fa-check-circle"></i> Setujui Realisasi';
                        btnVerify.className = 'btn btn-success';
                    }
                } else {
                    if (alasanGroup) alasanGroup.style.display = 'block';
                    if (alasanInput) alasanInput.required = true;
                    if (btnVerify) {
                        btnVerify.innerHTML = '<i class="fas fa-circle-xmark"></i> Tolak Realisasi';
                        btnVerify.className = 'btn btn-danger';
                    }
                }
            });
        });

        const checked = verifyWrapper.querySelector('input[name="status"]:checked');
        if (checked) checked.closest('.radio-card')?.click();

        form?.addEventListener('submit', (e) => {
            const status = form.querySelector('input[name="status"]:checked');
            if (!status) {
                e.preventDefault();
                alert('Pilih status verifikasi');
                return;
            }
            if (status.value === 'ditolak' && alasanInput?.value.trim().length < 5) {
                e.preventDefault();
                alert('Alasan penolakan minimal 5 karakter');
                alasanInput?.focus();
            }
        });
    }
});