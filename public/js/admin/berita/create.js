document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('createForm');
    const submitBtn = document.getElementById('submitBtn');
    const fileInput = document.getElementById('gambar');
    const filePreview = document.getElementById('filePreview');
    const previewImg = document.getElementById('previewImg');
    const fileRemove = document.getElementById('fileRemove');
    const statusSelect = document.getElementById('tampilkan');
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
    function showFilePreview(file) {
        if (!previewImg || !filePreview) return;
        previewImg.src = URL.createObjectURL(file);
        filePreview.style.display = 'inline-block';
    }

    function hideFilePreview() {
        if (!filePreview) return;
        filePreview.style.display = 'none';
        if (previewImg) {
            previewImg.src = '';
        }
        if (fileInput) fileInput.value = '';
    }

    if (fileInput) {
        fileInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                showFilePreview(this.files[0]);
            } else {
                hideFilePreview();
            }
        });
    }

    if (fileRemove) {
        fileRemove.addEventListener('click', hideFilePreview);
    }

    // =====================
    // DRAG & DROP
    // =====================
    const uploadArea = document.querySelector('.file-upload-area');
    if (uploadArea && fileInput) {
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(function(eventName) {
            uploadArea.addEventListener(eventName, function(e) {
                e.preventDefault();
                e.stopPropagation();
            });
        });

        ['dragenter', 'dragover'].forEach(function(eventName) {
            uploadArea.addEventListener(eventName, function() {
                uploadArea.style.borderColor = '#4f46e5';
                uploadArea.style.background = '#eef2ff';
            });
        });

        ['dragleave', 'drop'].forEach(function(eventName) {
            uploadArea.addEventListener(eventName, function() {
                uploadArea.style.borderColor = '';
                uploadArea.style.background = '';
            });
        });

        uploadArea.addEventListener('drop', function(e) {
            var files = e.dataTransfer.files;
            if (files.length) {
                fileInput.files = files;
                showFilePreview(files[0]);
            }
        });
    }

    // =====================
    // UNSAVED CHANGES WARNING
    // =====================
    let formChanged = false;

    if (form) {
        var inputs = form.querySelectorAll('input, select, textarea');
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
            var alert = this.closest('.berita-alert');
            if (alert) {
                alert.style.opacity = '0';
                alert.style.transform = 'translateY(-10px)';
                setTimeout(function() { alert.remove(); }, 300);
            }
        });
    });
});