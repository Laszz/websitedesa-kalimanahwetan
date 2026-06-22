// ==================== CONFIG ====================
const MAX_FILE_SIZE = 5 * 1024 * 1024; // 5MB

// ==================== TOAST SYSTEM ====================
function showToast(message, type = 'success') {
    const container = document.getElementById('toastContainer');
    if (!container) return;
    
    const icons = { success: '✅', error: '❌', warning: '⚠️' };
    const titles = { success: 'Berhasil!', error: 'Gagal!', warning: 'Perhatian!' };

    const toast = document.createElement('div');
    toast.className = `toast-notif toast-${type}`;
    toast.innerHTML = `
        <div class="toast-icon">${icons[type]}</div>
        <div class="toast-content">
            <strong>${titles[type]}</strong>
            <p>${message}</p>
        </div>
        <button class="toast-close" onclick="dismissToast(this)">×</button>
    `;

    container.appendChild(toast);
    setTimeout(() => {
        if (toast.parentElement) dismissToast(toast.querySelector('.toast-close'));
    }, 5000);
}

function dismissToast(btn) {
    const toast = btn.closest('.toast-notif');
    toast.style.opacity = '0';
    toast.style.transform = 'translateY(-20px)';
    setTimeout(() => toast.remove(), 300);
}

// ==================== PHP SESSION TOASTS (AUTO REMOVE) ====================
document.addEventListener('DOMContentLoaded', () => {
    const successMsg = document.getElementById('phpSuccessMessage');
    const errorMsg = document.getElementById('phpErrorMessage');
    const validationErrors = document.querySelectorAll('.php-validation-error');

    if (successMsg?.value) {
        showToast(successMsg.value, 'success');
        successMsg.remove();
    }
    if (errorMsg?.value) {
        showToast(errorMsg.value, 'error');
        errorMsg.remove();
    }
    validationErrors.forEach(el => {
        if (el.value) {
            showToast(el.value, 'error');
            el.remove();
        }
    });
});

// ==================== FILE SIZE ====================
function formatSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
}

function validateFileSize(input, infoId) {
    const file = input.files[0];
    const infoEl = document.getElementById(infoId);
    
    if (!file) {
        if (infoEl) infoEl.textContent = '';
        input.classList.remove('error');
        return true;
    }

    if (file.size > MAX_FILE_SIZE) {
        input.classList.add('error');
        const msg = `❌ File terlalu besar! ${formatSize(file.size)} / Maksimal 5MB`;
        if (infoEl) {
            infoEl.className = 'file-size-info too-big';
            infoEl.textContent = msg;
        }
        input.value = '';
        showToast(msg, 'error');
        return false;
    } else {
        input.classList.remove('error');
        const msg = `✅ ${formatSize(file.size)} / 5MB`;
        if (infoEl) {
            infoEl.className = 'file-size-info ok';
            infoEl.textContent = msg;
        }
        return true;
    }
}

// ==================== ATTACH VALIDATION ====================
document.addEventListener('DOMContentLoaded', () => {
    const editFileInput = document.getElementById('editFileInput');
    const addFileInput = document.getElementById('addFileInput');

    if (editFileInput) {
        editFileInput.addEventListener('change', function() {
            validateFileSize(this, 'editFileSizeInfo');
        });
    }

    if (addFileInput) {
        addFileInput.addEventListener('change', function() {
            validateFileSize(this, 'addFileSizeInfo');
        });
    }
});

// ==================== FORM SUBMIT ====================
document.addEventListener('DOMContentLoaded', () => {
    const editForm = document.getElementById('editForm');
    const addForm = document.getElementById('addForm');

    if (editForm) {
        editForm.addEventListener('submit', function(e) {
            const fileInput = document.getElementById('editFileInput');
            const fileGroup = document.getElementById('editFileGroup');
            
            if (fileGroup.style.display !== 'none' && fileInput.files[0]) {
                if (!validateFileSize(fileInput, 'editFileSizeInfo')) {
                    e.preventDefault();
                    return false;
                }
            }
        });
    }

    if (addForm) {
        addForm.addEventListener('submit', function(e) {
            const select = document.getElementById('addRequirementSelect');
            const selectedOption = select.options[select.selectedIndex];
            const tipe = selectedOption.getAttribute('data-tipe');
            const fileInput = document.getElementById('addFileInput');
            
            if (tipe === 'file' && fileInput.files[0]) {
                if (!validateFileSize(fileInput, 'addFileSizeInfo')) {
                    e.preventDefault();
                    return false;
                }
            }
        });
    }
});

// ==================== MODAL FUNCTIONS ====================

// ✅ FUNGSI BARU: Ambil data dari data-* attribute dan buka modal
function initEditButtons() {
    document.querySelectorAll('.btn-edit[data-upload-id]').forEach(btn => {
        btn.addEventListener('click', function() {
            const uploadId = this.dataset.uploadId;
            const nama = this.dataset.nama;
            const tipe = this.dataset.tipe;
            const value = this.dataset.value;
            
            openEditModal(uploadId, nama, tipe, value);
        });
    });
}

function openEditModal(uploadId, requirementName, tipe, currentText) {
    const modal = document.getElementById('editModal');
    const form = document.getElementById('editForm');
    const nameEl = document.getElementById('editRequirementName');
    const fileGroup = document.getElementById('editFileGroup');
    const textGroup = document.getElementById('editTextGroup');
    const fileInput = document.getElementById('editFileInput');
    const textInput = document.getElementById('editTextInput');
    const sizeInfo = document.getElementById('editFileSizeInfo');

    // Set action dengan URL lengkap
    const baseUrl = window.location.origin;
    const actionUrl = `${baseUrl}/warga/pendudukrequest/upload/update/${uploadId}`;
    
    form.setAttribute('action', actionUrl);
    form.action = actionUrl;

    nameEl.textContent = requirementName;

    if (tipe === 'file') {
        fileGroup.style.display = 'block';
        textGroup.style.display = 'none';
        fileInput.required = true;
        textInput.required = false;
        fileInput.value = '';
        if (sizeInfo) {
            sizeInfo.textContent = '';
            sizeInfo.className = 'file-size-info';
        }
    } else {
        fileGroup.style.display = 'none';
        textGroup.style.display = 'block';
        fileInput.required = false;
        textInput.required = true;
        textInput.value = currentText || '';
    }

    modal.classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeEditModal() {
    const modal = document.getElementById('editModal');
    modal.classList.remove('active');
    document.body.style.overflow = '';
    
    const form = document.getElementById('editForm');
    form.reset();
    form.setAttribute('action', '#');
    form.action = '#';
    
    const sizeInfo = document.getElementById('editFileSizeInfo');
    if (sizeInfo) {
        sizeInfo.textContent = '';
        sizeInfo.className = 'file-size-info';
    }
}

function openAddModal() {
    const modal = document.getElementById('addModal');
    modal.classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeAddModal() {
    const modal = document.getElementById('addModal');
    modal.classList.remove('active');
    document.body.style.overflow = '';
    
    const form = document.getElementById('addForm');
    form.reset();
    
    document.getElementById('addFileGroup').style.display = 'block';
    document.getElementById('addTextGroup').style.display = 'none';
    document.getElementById('addFileInput').required = false;
    document.getElementById('addTextInput').required = false;
    
    const sizeInfo = document.getElementById('addFileSizeInfo');
    if (sizeInfo) {
        sizeInfo.textContent = '';
        sizeInfo.className = 'file-size-info';
    }
}

function toggleAddInputType() {
    const select = document.getElementById('addRequirementSelect');
    const fileGroup = document.getElementById('addFileGroup');
    const textGroup = document.getElementById('addTextGroup');
    const fileInput = document.getElementById('addFileInput');
    const textInput = document.getElementById('addTextInput');

    const selectedOption = select.options[select.selectedIndex];
    const tipe = selectedOption.getAttribute('data-tipe');

    if (tipe === 'file') {
        fileGroup.style.display = 'block';
        textGroup.style.display = 'none';
        fileInput.required = true;
        textInput.required = false;
    } else if (tipe === 'text') {
        fileGroup.style.display = 'none';
        textGroup.style.display = 'block';
        fileInput.required = false;
        textInput.required = true;
    } else {
        fileGroup.style.display = 'block';
        textGroup.style.display = 'none';
        fileInput.required = false;
        textInput.required = false;
    }
}

// ==================== KEYBOARD & OVERLAY ====================
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        closeEditModal();
        closeAddModal();
    }
});

document.querySelectorAll('.modal-overlay').forEach(overlay => {
    overlay.addEventListener('click', function(e) {
        if (e.target === this) {
            const modal = this.closest('.modal');
            if (modal.id === 'editModal') closeEditModal();
            else if (modal.id === 'addModal') closeAddModal();
        }
    });
});

// ==================== ANIMATIONS & INIT ====================
document.addEventListener('DOMContentLoaded', () => {
    const cards = document.querySelectorAll('.card-glass, .status-alert');
    cards.forEach((card, index) => {
        card.style.animationDelay = `${index * 0.1}s`;
    });

    const fileItems = document.querySelectorAll('.file-item');
    fileItems.forEach(item => {
        item.addEventListener('mouseenter', () => {
            item.style.borderColor = '#c7d2fe';
        });
        item.addEventListener('mouseleave', () => {
            item.style.borderColor = 'transparent';
        });
    });

    // ✅ INISIALISASI BUTTON EDIT BARU
    initEditButtons();

    console.log("✨ Detail Pengajuan loaded");
});