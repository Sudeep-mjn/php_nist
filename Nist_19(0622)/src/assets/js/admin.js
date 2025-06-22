// NIST19 Admin Panel JavaScript

document.addEventListener('DOMContentLoaded', function() {
    // Sidebar toggle functionality
    const toggleSidebar = document.getElementById('toggle-sidebar');
    const sidebar = document.querySelector('.sidebar');
    const mainContent = document.querySelector('.main-content');
    
    if (toggleSidebar) {
        toggleSidebar.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
            const icon = this.querySelector('i');
            
            if (sidebar.classList.contains('collapsed')) {
                icon.classList.remove('fa-chevron-left');
                icon.classList.add('fa-chevron-right');
            } else {
                icon.classList.remove('fa-chevron-right');
                icon.classList.add('fa-chevron-left');
            }
        });
    }
    
    // Notice management
    initNoticeManagement();
    
    // Activity management
    initActivityManagement();
    
    // User management
    initUserManagement();
    
    // Form validation
    initFormValidation();
});

function initNoticeManagement() {
    const addNoticeBtn = document.getElementById('add-notice-btn');
    const noticeModal = document.getElementById('notice-modal');
    const noticeForm = document.getElementById('notice-form');
    const cancelBtn = document.getElementById('cancel-btn');
    const deleteModal = document.getElementById('delete-modal');
    const deleteForm = document.getElementById('delete-form');
    const cancelDeleteBtn = document.getElementById('cancel-delete-btn');
    
    if (addNoticeBtn) {
        addNoticeBtn.addEventListener('click', function() {
            resetNoticeForm();
            document.getElementById('modal-title').textContent = 'Add New Notice';
            document.getElementById('form-action').value = 'create';
            showModal(noticeModal);
        });
    }
    
    // Edit notice buttons
    document.querySelectorAll('.edit-notice-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            const title = this.dataset.title;
            const description = this.dataset.description;
            const date = this.dataset.date;
            
            document.getElementById('modal-title').textContent = 'Edit Notice';
            document.getElementById('form-action').value = 'update';
            document.getElementById('notice-id').value = id;
            document.getElementById('title').value = title;
            document.getElementById('description').value = description;
            document.getElementById('date').value = date;
            
            showModal(noticeModal);
        });
    });
    
    // Delete notice buttons
    document.querySelectorAll('.delete-notice-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            const title = this.dataset.title;
            
            document.getElementById('delete-title').textContent = title;
            document.getElementById('delete-id').value = id;
            
            showModal(deleteModal);
        });
    });
    
    // Modal controls
    if (cancelBtn) {
        cancelBtn.addEventListener('click', () => hideModal(noticeModal));
    }
    
    if (cancelDeleteBtn) {
        cancelDeleteBtn.addEventListener('click', () => hideModal(deleteModal));
    }
    
    // Close modals when clicking outside
    if (noticeModal) {
        noticeModal.addEventListener('click', function(e) {
            if (e.target === this) hideModal(this);
        });
    }
    
    if (deleteModal) {
        deleteModal.addEventListener('click', function(e) {
            if (e.target === this) hideModal(this);
        });
    }
}

function initActivityManagement() {
    const addActivityBtn = document.getElementById('add-activity-btn');
    const activityModal = document.getElementById('activity-modal');
    const activityForm = document.getElementById('activity-form');
    const cancelBtn = document.getElementById('cancel-btn');
    const deleteModal = document.getElementById('delete-modal');
    const deleteForm = document.getElementById('delete-form');
    const cancelDeleteBtn = document.getElementById('cancel-delete-btn');
    
    if (addActivityBtn) {
        addActivityBtn.addEventListener('click', function() {
            resetActivityForm();
            document.getElementById('modal-title').textContent = 'Add New Activity';
            document.getElementById('form-action').value = 'create';
            showModal(activityModal);
        });
    }
    
    // Edit activity buttons
    document.querySelectorAll('.edit-activity-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            const title = this.dataset.title;
            const description = this.dataset.description;
            const link = this.dataset.link;
            const image = this.dataset.image;
            
            document.getElementById('modal-title').textContent = 'Edit Activity';
            document.getElementById('form-action').value = 'update';
            document.getElementById('activity-id').value = id;
            document.getElementById('title').value = title;
            document.getElementById('description').value = description;
            document.getElementById('link').value = link;
            document.getElementById('existing-image').value = image;
            
            showModal(activityModal);
        });
    });
    
    // Delete activity buttons
    document.querySelectorAll('.delete-activity-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            const title = this.dataset.title;
            
            document.getElementById('delete-title').textContent = title;
            document.getElementById('delete-id').value = id;
            
            showModal(deleteModal);
        });
    });
    
    // Modal controls
    if (cancelBtn) {
        cancelBtn.addEventListener('click', () => hideModal(activityModal));
    }
    
    if (cancelDeleteBtn) {
        cancelDeleteBtn.addEventListener('click', () => hideModal(deleteModal));
    }
    
    // Close modals when clicking outside
    if (activityModal) {
        activityModal.addEventListener('click', function(e) {
            if (e.target === this) hideModal(this);
        });
    }
    
    if (deleteModal) {
        deleteModal.addEventListener('click', function(e) {
            if (e.target === this) hideModal(this);
        });
    }
}

function initUserManagement() {
    const addUserBtn = document.getElementById('add-user-btn');
    const userModal = document.getElementById('user-modal');
    const userForm = document.getElementById('user-form');
    const cancelBtn = document.getElementById('cancel-btn');
    const deleteModal = document.getElementById('delete-modal');
    const deleteForm = document.getElementById('delete-form');
    const cancelDeleteBtn = document.getElementById('cancel-delete-btn');
    
    if (addUserBtn) {
        addUserBtn.addEventListener('click', function() {
            resetUserForm();
            document.getElementById('modal-title').textContent = 'Add New User';
            document.getElementById('form-action').value = 'create';
            document.getElementById('password').required = true;
            document.getElementById('password-help').textContent = 'Required for new users';
            showModal(userModal);
        });
    }
    
    // Edit user buttons
    document.querySelectorAll('.edit-user-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            const username = this.dataset.username;
            const role = this.dataset.role;
            
            document.getElementById('modal-title').textContent = 'Edit User';
            document.getElementById('form-action').value = 'update';
            document.getElementById('user-id').value = id;
            document.getElementById('username').value = username;
            document.getElementById('role').value = role;
            document.getElementById('password').required = false;
            document.getElementById('password-help').textContent = 'Leave blank to keep current password';
            
            showModal(userModal);
        });
    });
    
    // Delete user buttons
    document.querySelectorAll('.delete-user-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            const username = this.dataset.username;
            
            document.getElementById('delete-username').textContent = username;
            document.getElementById('delete-id').value = id;
            
            showModal(deleteModal);
        });
    });
    
    // Modal controls
    if (cancelBtn) {
        cancelBtn.addEventListener('click', () => hideModal(userModal));
    }
    
    if (cancelDeleteBtn) {
        cancelDeleteBtn.addEventListener('click', () => hideModal(deleteModal));
    }
    
    // Close modals when clicking outside
    if (userModal) {
        userModal.addEventListener('click', function(e) {
            if (e.target === this) hideModal(this);
        });
    }
    
    if (deleteModal) {
        deleteModal.addEventListener('click', function(e) {
            if (e.target === this) hideModal(this);
        });
    }
}

function initFormValidation() {
    // Real-time validation for forms
    const forms = document.querySelectorAll('form');
    
    forms.forEach(form => {
        const inputs = form.querySelectorAll('input[required], textarea[required]');
        
        inputs.forEach(input => {
            input.addEventListener('blur', function() {
                validateField(this);
            });
            
            input.addEventListener('input', function() {
                if (this.classList.contains('border-red-500')) {
                    validateField(this);
                }
            });
        });
    });
}

function validateField(field) {
    const value = field.value.trim();
    const isValid = value.length > 0;
    
    if (isValid) {
        field.classList.remove('border-red-500');
        field.classList.add('border-green-500');
    } else {
        field.classList.remove('border-green-500');
        field.classList.add('border-red-500');
    }
    
    return isValid;
}

function resetNoticeForm() {
    document.getElementById('notice-id').value = '';
    document.getElementById('title').value = '';
    document.getElementById('description').value = '';
    document.getElementById('date').value = '';
}

function resetActivityForm() {
    document.getElementById('activity-id').value = '';
    document.getElementById('title').value = '';
    document.getElementById('description').value = '';
    document.getElementById('link').value = '';
    document.getElementById('image').value = '';
    document.getElementById('existing-image').value = '';
}

function resetUserForm() {
    document.getElementById('user-id').value = '';
    document.getElementById('username').value = '';
    document.getElementById('password').value = '';
    document.getElementById('role').value = 'admin';
}

function showModal(modal) {
    if (modal) {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }
}

function hideModal(modal) {
    if (modal) {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = 'auto';
    }
}

// Utility functions
function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    });
}

function truncateText(text, maxLength) {
    if (text.length <= maxLength) return text;
    return text.substr(0, maxLength) + '...';
}

// Auto-hide alerts after 5 seconds
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.bg-green-100, .bg-red-100, .bg-yellow-100');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.transition = 'opacity 0.5s';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500);
        }, 5000);
    });
});
