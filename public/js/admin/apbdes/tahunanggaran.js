// ============================================
// TAHUN ANGGARAN - COMMON (SEMUA HALAMAN)
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
    // TAHUN ANGGARAN - INDEX
    // ============================================
    const indexWrapper = document.querySelector('.tahunanggaran-index');
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

        console.log('Tahun Anggaran Index loaded');
    }


    // ============================================
    // TAHUN ANGGARAN - CREATE
    // ============================================
    const createWrapper = document.querySelector('.tahunanggaran-create');
    if (createWrapper) {
        setupAlerts(createWrapper);

        const tahunInput = createWrapper.querySelector('#tahun');
        const statusSelect = createWrapper.querySelector('#status');
        const tahunHint = createWrapper.querySelector('#tahun').closest('.form-group').querySelector('.form-hint');
        const statusHint = createWrapper.querySelector('#status').closest('.form-group').querySelector('.form-hint');
        
        // Validate year input
        tahunInput.addEventListener('input', () => {
            const val = parseInt(tahunInput.value);
            if (val < 2000 || val > 2100) {
                tahunInput.classList.add('is-invalid');
            } else {
                tahunInput.classList.remove('is-invalid');
            }
        });

        // Warning when activating
        statusSelect.addEventListener('change', () => {
            if (statusSelect.value === 'aktif') {
                statusHint.style.color = '#dc2626';
                statusHint.style.fontWeight = '600';
                statusHint.textContent = '⚠️ PERHATIAN: Mengaktifkan tahun ini akan menutup tahun aktif lainnya!';
            } else {
                statusHint.style.color = '#6b7280';
                statusHint.style.fontWeight = '400';
                statusHint.textContent = 'Jika diaktifkan, tahun lain akan otomatis ditutup';
            }
        });

        // Form validation before submit
        const form = createWrapper.querySelector('form');
        form.addEventListener('submit', (e) => {
            const tahun = parseInt(tahunInput.value);
            if (tahun < 2000 || tahun > 2100) {
                e.preventDefault();
                alert('Tahun harus antara 2000 - 2100');
                tahunInput.focus();
            }
        });

        console.log('Tahun Anggaran Create loaded');
    }


    // ============================================
    // TAHUN ANGGARAN - SHOW
    // ============================================
    const showWrapper = document.querySelector('.tahunanggaran-show');
    if (showWrapper) {
        setupAlerts(showWrapper);

        // Animate progress bars (main progress)
        const progressSection = showWrapper.querySelector('.progress-section[data-progress]');
        if (progressSection) {
            animateProgressBar(progressSection, '.progress-bar-fill');
        }

        // Animate bidang progress bars
        const bidangProgressTracks = showWrapper.querySelectorAll('.bidang-progress-track[data-progress]');
        bidangProgressTracks.forEach(track => {
            animateProgressBar(track, '.bidang-progress-fill');
        });

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

        // Animate bidang cards
        const bidangCards = showWrapper.querySelectorAll('.bidang-card');
        bidangCards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'scale(0.95)';
            setTimeout(() => {
                card.style.transition = 'all 0.3s ease';
                card.style.opacity = '1';
                card.style.transform = 'scale(1)';
            }, 400 + index * 80);
        });

        console.log('Tahun Anggaran Show loaded');
    }


    // ============================================
    // TAHUN ANGGARAN - EDIT
    // ============================================
    const editWrapper = document.querySelector('.tahunanggaran-edit');
    if (editWrapper) {
        setupAlerts(editWrapper);

        const statusSelect = editWrapper.querySelector('#status');
        const tahunInput = editWrapper.querySelector('#tahun');
        
        // Warning when activating
        statusSelect.addEventListener('change', () => {
            if (statusSelect.value === 'aktif') {
                const hint = editWrapper.querySelector('.form-hint.warning');
                if (hint) {
                    hint.style.background = '#fef3c7';
                    hint.style.padding = '8px 12px';
                    hint.style.borderRadius = '6px';
                    hint.style.display = 'inline-block';
                }
            }
        });

        // Form validation before submit
        const form = editWrapper.querySelector('form');
        form.addEventListener('submit', (e) => {
            const tahun = parseInt(tahunInput.value);
            if (tahun < 2000 || tahun > 2100) {
                e.preventDefault();
                alert('Tahun harus antara 2000 - 2100');
                tahunInput.focus();
            }
        });

        // Highlight changed fields
        const inputs = editWrapper.querySelectorAll('.form-input, .form-select');
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

        console.log('Tahun Anggaran Edit loaded');
    }

})();