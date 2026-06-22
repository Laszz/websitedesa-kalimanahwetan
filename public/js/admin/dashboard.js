document.addEventListener('DOMContentLoaded', () => {
    // ===== AMBIL DATA DARI DATA ATTRIBUTE =====
    const dataEl = document.getElementById('dashboard-data');
    const data = dataEl ? {
        triwulanLabels: JSON.parse(dataEl.dataset.triwulanLabels || '[]'),
        triwulanData: JSON.parse(dataEl.dataset.triwulanData || '[]'),
        desilLabels: JSON.parse(dataEl.dataset.desilLabels || '[]'),
        desilData: JSON.parse(dataEl.dataset.desilData || '[]')
    } : {};

    // ===== CHART APBDes (Bar) =====
    const chartApbdesEl = document.getElementById('chartApbdes');
    if (chartApbdesEl && data.triwulanLabels.length > 0) {
        new Chart(chartApbdesEl, {
            type: 'bar',
            data: {
                labels: data.triwulanLabels,
                datasets: [{
                    label: 'Realisasi (Rp)',
                    data: data.triwulanData,
                    backgroundColor: ['#3b82f6', '#10b981', '#f59e0b', '#ef4444'],
                    borderRadius: 8,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'Rp ' + new Intl.NumberFormat('id-ID').format(context.raw);
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                if (value >= 1000000000) return 'Rp ' + (value/1000000000).toFixed(1) + 'M';
                                if (value >= 1000000) return 'Rp ' + (value/1000000).toFixed(1) + 'jt';
                                return 'Rp ' + value;
                            }
                        }
                    }
                }
            }
        });
    }

    // ===== CHART DESIL (Doughnut) =====
    const chartDesilEl = document.getElementById('chartDesil');
    if (chartDesilEl && data.desilLabels.length > 0) {
        new Chart(chartDesilEl, {
            type: 'doughnut',
            data: {
                labels: data.desilLabels,
                datasets: [{
                    data: data.desilData,
                    backgroundColor: [
                        '#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6',
                        '#ec4899', '#06b6d4', '#84cc16', '#f97316', '#6366f1'
                    ],
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right',
                        labels: { boxWidth: 12, font: { size: 11 } }
                    }
                }
            }
        });
    }

    // ===== COUNTER ANIMATION =====
    document.querySelectorAll('[data-counter]').forEach(el => {
        const text = el.textContent.trim();
        if (text.includes('%')) return;

        const match = text.match(/[\d.,]+/);
        if (!match) return;

        const isRupiah = text.includes('Rp');
        let raw = match[0].replace(/\./g, '').replace(/,/g, '.');
        const target = parseFloat(raw);
        if (isNaN(target)) return;

        const prefix = text.substring(0, text.indexOf(match[0]));
        const suffix = text.substring(text.indexOf(match[0]) + match[0].length);
        const duration = 1000;
        const startTime = performance.now();

        const step = (now) => {
            const elapsed = now - startTime;
            const progress = Math.min(elapsed / duration, 1);
            const eased = 1 - Math.pow(1 - progress, 3);
            const current = target * eased;

            let formatted;
            if (isRupiah || Number.isInteger(target)) {
                formatted = new Intl.NumberFormat('id-ID').format(Math.floor(current));
            } else {
                formatted = current.toFixed(2);
            }

            el.textContent = prefix + formatted + suffix;
            if (progress < 1) requestAnimationFrame(step);
        };
        requestAnimationFrame(step);
    });

    // ===== PROGRESS BAR ANIMATION =====
    document.querySelectorAll('[data-width]').forEach(bar => {
        const target = parseFloat(bar.dataset.width) || 0;
        setTimeout(() => {
            bar.style.width = target + '%';
        }, 300);
    });
});