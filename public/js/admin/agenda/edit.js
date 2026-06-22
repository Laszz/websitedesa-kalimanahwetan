document.addEventListener('DOMContentLoaded', function() {
    const seharianCheckbox = document.getElementById('seharian');
    const groupSelesai = document.getElementById('groupSelesai');

    function toggleSelesai() {
        if (seharianCheckbox.checked) {
            groupSelesai.style.display = 'none';
        } else {
            groupSelesai.style.display = 'block';
        }
    }

    seharianCheckbox.addEventListener('change', toggleSelesai);
    toggleSelesai();
});