document.addEventListener("DOMContentLoaded", function () {
    const ctx = document.getElementById("pendudukChart");
    
    if (!ctx || !window.chartData) return;

    const data = window.chartData;

    new Chart(ctx, {
        type: "bar",
        data: {
            labels: ["Laki-laki", "Perempuan", "Jumlah KK", "Total Penduduk"],
            datasets: [{
                label: "Jumlah",
                data: [data.laki, data.perempuan, data.kk, data.total],
                backgroundColor: [
                    "rgba(99, 102, 241, 0.8)",   // Indigo - Laki
                    "rgba(236, 72, 153, 0.8)",   // Pink - Perempuan
                    "rgba(34, 197, 94, 0.8)",    // Green - KK
                    "rgba(59, 130, 246, 0.8)"    // Blue - Total
                ],
                borderColor: [
                    "rgb(99, 102, 241)",
                    "rgb(236, 72, 153)",
                    "rgb(34, 197, 94)",
                    "rgb(59, 130, 246)"
                ],
                borderWidth: 2,
                borderRadius: 8,
                borderSkipped: false
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: "rgba(17, 24, 39, 0.9)",
                    padding: 12,
                    cornerRadius: 8,
                    titleFont: { size: 13 },
                    bodyFont: { size: 14, weight: "bold" }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: "rgba(0,0,0,0.05)",
                        drawBorder: false
                    },
                    ticks: {
                        font: { size: 12 },
                        color: "#6b7280"
                    }
                },
                x: {
                    grid: { display: false },
                    ticks: {
                        font: { size: 12, weight: "500" },
                        color: "#374151"
                    }
                }
            },
            animation: {
                duration: 1500,
                easing: "easeOutQuart"
            }
        }
    });
});