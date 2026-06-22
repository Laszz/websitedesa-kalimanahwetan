document.addEventListener('DOMContentLoaded', function() {
    var form = document.getElementById('editForm');
    var submitBtn = document.getElementById('submitBtn');
    var fileInput = document.getElementById('gambar');
    var filePreview = document.getElementById('filePreview');
    var previewImg = document.getElementById('previewImg');
    var fileRemove = document.getElementById('fileRemove');
    var fileLabel = document.getElementById('fileLabel');
    var statusSelect = document.getElementById('tampilkan');
    var statusIndicator = document.getElementById('statusIndicator');
    var originalSrc = previewImg ? previewImg.src : '';

    // =====================
    // STATUS COLOR INDICATOR
    // =====================
    function updateStatusIndicator() {
        if (!statusSelect || !statusIndicator) return;
        var value = statusSelect.value;
        statusIndicator.className = 'status-indicator ' + value;
    }

    if (statusSelect) {
        statusSelect.addEventListener('change', updateStatusIndicator);
        updateStatusIndicator();
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
        if (fileLabel) fileLabel.textContent = 'Gambar baru';
    }

    function resetFilePreview() {
        if (!filePreview || !previewImg) return;
        if (originalSrc) {
            previewImg.src = originalSrc;
            if (fileLabel) fileLabel.textContent = 'Gambar saat ini';
        } else {
            filePreview.style.display = 'none';
        }
        if (fileInput) fileInput.value = '';
    }

    if (fileInput) {
        fileInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                showFilePreview(this.files[0]);
            } else {
                resetFilePreview();
            }
        });
    }

    if (fileRemove) {
        fileRemove.addEventListener('click', resetFilePreview);
    }

    // =====================
    // DRAG & DROP
    // =====================
    var uploadArea = document.querySelector('.file-upload-area');
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
    var formChanged = false;

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
            var alert = this.closest('.galeri-alert');
            if (alert) {
                alert.style.opacity = '0';
                alert.style.transform = 'translateY(-10px)';
                setTimeout(function() { alert.remove(); }, 300);
            }
        });
    });

    // =====================
    // AUTO HIDE ALERT (5 detik)
    // =====================
    document.querySelectorAll('.galeri-alert').forEach(function(alert) {
        setTimeout(function() {
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-10px)';
            setTimeout(function() { alert.remove(); }, 300);
        }, 5000);
    });
});