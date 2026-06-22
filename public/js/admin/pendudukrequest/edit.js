document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('editForm');
    const submitBtn = document.getElementById('submitBtn');
    const fileInput = document.getElementById('file_output');
    const filePreview = document.getElementById('filePreview');
    const fileName = document.getElementById('fileName');
    const fileRemove = document.getElementById('fileRemove');
    const statusSelect = document.getElementById('status');
    const statusIndicator = document.getElementById('statusIndicator');

    // =====================
    // STATUS COLOR INDICATOR
    // =====================
    function updateStatusIndicator() {
        if (!statusSelect || !statusIndicator) return;
        const value = statusSelect.value;
        statusIndicator.className = 'status-indicator ' + value;
    }

    if (statusSelect) {
        statusSelect.addEventListener('change', updateStatusIndicator);
        updateStatusIndicator(); // init
    }

    // =====================
    // LOADING STATE ON SUBMIT
    // =====================
    if (form && submitBtn) {
        form.addEventListener('submit', function() {
            submitBtn.classList.add('btn-loading');
            submitBtn.disabled = true;
        });
    }

    // =====================
    // FILE PREVIEW
    // =====================
    function showFilePreview(name) {
        if (!fileName || !filePreview) return;
        fileName.textContent = name;
        filePreview.style.display = 'flex';
    }

    function hideFilePreview() {
        if (!filePreview) return;
        filePreview.style.display = 'none';
        if (fileInput) fileInput.value = '';
    }

    if (fileInput) {
        fileInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                showFilePreview(this.files[0].name);
            } else {
                hideFilePreview();
            }
        });
    }

    if (fileRemove) {
        fileRemove.addEventListener('click', hideFilePreview);
    }

    // =====================
    // UNSAVED CHANGES WARNING
    // =====================
    let formChanged = false;

    if (form) {
        const inputs = form.querySelectorAll('input, select, textarea');
        inputs.forEach(function(input) {
            input.addEventListener('change', function() { formChanged = true; });
            input.addEventListener('input', function() { formChanged = true; });
        });

        form.addEventListener('submit', function() {
            formChanged = false;
        });
    }

    window.addEventListener('beforeunload', function(e) {
        if (formChanged) {
            e.preventDefault();
            e.returnValue = '';
        }
    });

    // =====================
    // ALERT CLOSE
    // =====================
    document.querySelectorAll('.alert-close').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const alert = this.closest('.request-alert');
            if (alert) {
                alert.style.opacity = '0';
                alert.style.transform = 'translateY(-10px)';
                setTimeout(function() { alert.remove(); }, 300);
            }
        });
    });
});