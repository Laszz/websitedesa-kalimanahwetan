// ============================================
// SUMBER DANA - COMMON (SEMUA HALAMAN)
// ============================================

(function() {
    'use strict';

    // Helper: Animate number counter
    function animateCounter(element, targetValue, prefix, suffix, duration) {
        let current = 0;
        const steps = 30;
        const increment = targetValue / steps;
        const interval = duration / steps;
        
        const timer = setInterval(() => {
            current += increment;
            if (current >= targetValue) {
                current = targetValue;
                clearInterval(timer);
            }
            element.textContent = prefix + new Intl.NumberFormat('id-ID').format(Math.floor(current)) + suffix;
        }, interval);
    }

    // Helper: Parse Rupiah string to number
    function parseRupiah(text) {
        const isNegative = text.includes('-');
        const cleanText = text.replace('-', '').replace('Rp ', '').replace(/\./g, '');
        const value = parseInt(cleanText, 10);
        return { value: isNegative ? -value : value, isNegative, prefix: isNegative ? '-Rp ' : 'Rp ' };
    }

    // Helper: Dismiss alert with animation
    function dismissAlert(alert) {
        alert.style.opacity = '0';
        alert.style.transform = 'translateY(-10px)';
        alert.style.transition = 'all 0.3s ease';
        setTimeout(() => alert.remove(), 300);
    }

    // Helper: Animate progress bar
    function animateProgressBar(container, fillSelector) {
        const progressValue = container.dataset.progress;
        if (!progressValue) return;
        
        const fill = container.querySelector(fillSelector);
        if (!fill) return;
        
        requestAnimationFrame(() => {
            fill.style.width = progressValue + '%';
        });
    }

    // Setup alerts (common untuk semua halaman)
    function setupAlerts(wrapper) {
        const alerts = wrapper.querySelectorAll('.alert');
        
        alerts.forEach(alert => {
            const closeBtn = alert.querySelector('.alert-close');
            
            // Manual close
            if (closeBtn) {
                closeBtn.addEventListener('click', () => dismissAlert(alert));
            }
            
            // Auto dismiss after 5 seconds
            setTimeout(() => dismissAlert(alert), 5000);
        });
    }


    // ============================================
    // SUMBER DANA - INDEX
    // ============================================
    const indexWrapper = document.querySelector('.sumberdana-index');
    if (indexWrapper) {
        setupAlerts(indexWrapper);

        // Animate table rows
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

        // Color code sisa column (negative values)
        const sisaCells = indexWrapper.querySelectorAll('td.text-right[data-counter]');
        sisaCells.forEach(cell => {
            const parsed = parseRupiah(cell.textContent);
            if (parsed.value <= 0) {
                cell.style.color = '#dc2626';
            }
        });

        // Animate counter values
        const counterCells = indexWrapper.querySelectorAll('td[data-counter]');
        counterCells.forEach(cell => {
            const text = cell.textContent.trim();
            if (!text.includes('Rp')) return;
            
            const parsed = parseRupiah(text);
            if (isNaN(parsed.value)) return;
            
            animateCounter(cell, Math.abs(parsed.value), parsed.prefix, '', 800);
        });

        console.log('Sumber Dana Index loaded');
    }


    // ============================================
    // SUMBER DANA - CREATE
    // ============================================
    const createWrapper = document.querySelector('.sumberdana-create');
    if (createWrapper) {
        setupAlerts(createWrapper);

        const nominalInput = createWrapper.querySelector('#nominal_awal');
        const jenisSelect = createWrapper.querySelector('#jenis');
        const tahunSelect = createWrapper.querySelector('#tahun_anggaran_id');
        
        // Format number input validation
        nominalInput.addEventListener('input', () => {
            const val = parseFloat(nominalInput.value);
            if (val < 0 || isNaN(val)) {
                nominalInput.classList.add('is-invalid');
            } else {
                nominalInput.classList.remove('is-invalid');
            }
        });

        // Auto-generate nama sumber based on jenis + tahun
        function generateNamaSumber() {
            const namaInput = createWrapper.querySelector('#nama_sumber');
            const jenis = jenisSelect.value;
            const tahunOption = tahunSelect.options[tahunSelect.selectedIndex];
            const tahun = tahunOption ? tahunOption.text.split(' ')[0] : '';
            
            if (jenis && tahun && !namaInput.value) {
                const jenisMap = {
                    'apbn': 'APBN',
                    'apbd_provinsi': 'APBD Provinsi',
                    'bkk': 'BKK',
                    'pad': 'PAD',
                    'add': 'ADD',
                    'dd': 'Dana Desa',
                    'silpa': 'SILPA',
                    'lainnya': 'Lainnya'
                };
                namaInput.value = `${jenisMap[jenis]} ${tahun}`;
            }
        }

        jenisSelect.addEventListener('change', generateNamaSumber);
        tahunSelect.addEventListener('change', generateNamaSumber);

        // Form validation
        const form = createWrapper.querySelector('form');
        form.addEventListener('submit', (e) => {
            const nominal = parseFloat(nominalInput.value);
            if (nominal < 0 || isNaN(nominal)) {
                e.preventDefault();
                alert('Nominal tidak boleh negatif');
                nominalInput.focus();
            }
        });

        console.log('Sumber Dana Create loaded');
    }


    // ============================================
    // SUMBER DANA - SHOW
    // ============================================
    const showWrapper = document.querySelector('.sumberdana-show');
    if (showWrapper) {
        setupAlerts(showWrapper);

        // Animate progress bar
        const progressSection = showWrapper.querySelector('.progress-section[data-progress]');
        if (progressSection) {
            animateProgressBar(progressSection, '.progress-bar-fill');
            
            // Color progress bar based on percentage
            const progressValue = parseFloat(progressSection.dataset.progress);
            const fill = progressSection.querySelector('.progress-bar-fill');
            if (fill && !isNaN(progressValue)) {
                if (progressValue >= 90) {
                    fill.style.background = 'linear-gradient(90deg, #ef4444, #f59e0b)';
                } else if (progressValue >= 70) {
                    fill.style.background = 'linear-gradient(90deg, #f59e0b, #eab308)';
                }
            }
        }

        // Animate stat counters
        const statValues = showWrapper.querySelectorAll('.stat-value[data-counter]');
        statValues.forEach(stat => {
            const text = stat.textContent.trim();
            if (!text.includes('Rp')) return;
            
            const parsed = parseRupiah(text);
            if (isNaN(parsed.value)) return;
            
            const suffix = text.includes('%') ? '%' : '';
            animateCounter(stat, Math.abs(parsed.value), parsed.prefix, suffix, 1000);
        });

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

        console.log('Sumber Dana Show loaded');
    }


    // ============================================
    // SUMBER DANA - EDIT
    // ============================================
    const editWrapper = document.querySelector('.sumberdana-edit');
    if (editWrapper) {
        setupAlerts(editWrapper);

        const nominalInput = editWrapper.querySelector('#nominal_awal');
        const alasanInput = editWrapper.querySelector('#alasan_perubahan');
        
        // Validate minimum value
        const minVal = parseFloat(nominalInput.min) || 0;
        
        nominalInput.addEventListener('input', () => {
            const val = parseFloat(nominalInput.value);
            const hint = nominalInput.closest('.form-group').querySelector('.form-hint.warning');
            
            if (val < minVal || isNaN(val)) {
                nominalInput.classList.add('is-invalid');
                if (hint) {
                    hint.style.color = '#dc2626';
                    hint.style.fontWeight = '600';
                }
            } else {
                nominalInput.classList.remove('is-invalid');
                if (hint) {
                    hint.style.color = '#d97706';
                    hint.style.fontWeight = '400';
                }
            }
        });

        // Validate alasan length
        alasanInput.addEventListener('input', () => {
            if (alasanInput.value.length < 10) {
                alasanInput.classList.add('is-invalid');
            } else {
                alasanInput.classList.remove('is-invalid');
            }
        });

        // Form validation
        const form = editWrapper.querySelector('form');
        form.addEventListener('submit', (e) => {
            const nominal = parseFloat(nominalInput.value);
            const alasan = alasanInput.value.trim();
            
            if (nominal < minVal || isNaN(nominal)) {
                e.preventDefault();
                alert(`Nominal minimal Rp ${new Intl.NumberFormat('id-ID').format(minVal)}`);
                nominalInput.focus();
                return;
            }
            
            if (alasan.length < 10) {
                e.preventDefault();
                alert('Alasan perubahan minimal 10 karakter');
                alasanInput.focus();
            }
        });

        // Highlight changed fields
        const inputs = editWrapper.querySelectorAll('.form-input, .form-textarea');
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

        console.log('Sumber Dana Edit loaded');
    }

})();