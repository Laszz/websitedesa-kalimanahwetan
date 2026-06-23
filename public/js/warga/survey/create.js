document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('surveyForm');
    const btnSubmit = document.getElementById('btnSubmit');

    // Handle star rating
    document.querySelectorAll('.star-rating').forEach(ratingGroup => {
        const stars = ratingGroup.querySelectorAll('.star-btn');
        const inputName = ratingGroup.dataset.name;
        const hiddenInput = document.getElementById(inputName);

        stars.forEach((star, index) => {
            star.addEventListener('click', () => {
                const value = parseInt(star.dataset.value);
                hiddenInput.value = value;

                stars.forEach((s, i) => {
                    if (i < value) {
                        s.classList.add('selected');
                        s.classList.add('active');
                    } else {
                        s.classList.remove('selected');
                        s.classList.remove('active');
                    }
                });
            });

            star.addEventListener('mouseenter', () => {
                stars.forEach((s, i) => {
                    if (i <= index) {
                        s.classList.add('active');
                    } else {
                        s.classList.remove('active');
                    }
                });
            });
        });

        ratingGroup.addEventListener('mouseleave', () => {
            const selectedValue = parseInt(hiddenInput.value) || 0;
            stars.forEach((s, i) => {
                if (i < selectedValue) {
                    s.classList.add('active');
                } else {
                    s.classList.remove('active');
                }
            });
        });
    });

    // Form validation + anti double submit
    form.addEventListener('submit', (e) => {
        // Cegah submit ganda
        if (btnSubmit.disabled) {
            e.preventDefault();
            return false;
        }

        const requiredFields = ['q1_speed', 'q2_friendly', 'q3_clarity', 'q4_ease', 'q5_overall'];
        let isValid = true;

        requiredFields.forEach(field => {
            const value = document.getElementById(field).value;
            if (!value) {
                isValid = false;
                const questionItem = document.querySelector(`[data-name="${field}"]`).closest('.question-item');
                questionItem.style.border = '2px solid #e53e3e';
                
                setTimeout(() => {
                    questionItem.style.border = 'none';
                }, 3000);
            }
        });

        if (!isValid) {
            e.preventDefault();
            alert('Mohon isi semua rating bintang terlebih dahulu!');
            return;
        }

        // Disable tombol + spinner
        btnSubmit.disabled = true;
        btnSubmit.querySelector('.btn-text').textContent = 'Mengirim...';
    });

    // Re-enable tombol saat halaman di-load ulang (error validasi/back button)
    window.addEventListener('pageshow', function() {
        if (btnSubmit) {
            btnSubmit.disabled = false;
            btnSubmit.querySelector('.btn-text').textContent = 'Kirim Survey';
        }
    });
});