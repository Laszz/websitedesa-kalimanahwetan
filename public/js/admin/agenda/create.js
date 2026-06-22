document.addEventListener('DOMContentLoaded', function() {
    const seharianCheckbox = document.getElementById('seharian');
    const groupSelesai = document.getElementById('groupSelesai');
    const inputSelesai = document.getElementById('selesai');
    const inputMulai = document.getElementById('mulai');

    // Helper: Konversi Date ke format datetime-local (YYYY-MM-DDTHH:mm) dalam local time
    function toDateTimeLocal(date) {
        const pad = (n) => n.toString().padStart(2, '0');
        return date.getFullYear() + '-' +
               pad(date.getMonth() + 1) + '-' +
               pad(date.getDate()) + 'T' +
               pad(date.getHours()) + ':' +
               pad(date.getMinutes());
    }

    function toggleSelesai() {
        if (seharianCheckbox.checked) {
            groupSelesai.style.display = 'none';
            inputSelesai.value = '';
        } else {
            groupSelesai.style.display = 'block';
        }
    }

    seharianCheckbox.addEventListener('change', toggleSelesai);
    toggleSelesai(); // Run on load

    // Set min datetime untuk mulai (local time, bukan UTC)
    const now = new Date();
    inputMulai.min = toDateTimeLocal(now);

    // Auto-set selesai 1 jam setelah mulai (local time)
    inputMulai.addEventListener('change', function() {
        if (!seharianCheckbox.checked && this.value && !inputSelesai.value) {
            const mulai = new Date(this.value);
            mulai.setHours(mulai.getHours() + 1);
            inputSelesai.value = toDateTimeLocal(mulai);
        }
    });
});