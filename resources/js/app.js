import './bootstrap';
import 'bootstrap';

import './bootstrap';

window.togglePassword = function() {
    const password = document.getElementById('password');
    const icon = document.getElementById('toggleIcon');
    
    if (!password || !icon) {
        console.warn('Element password atau toggleIcon tidak ditemukan');
        return;
    }
    
    if (password.type === 'password') {
        password.type = 'text';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    } else {
        password.type = 'password';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    }
};

window.togglePasswordWithId = function(inputId, iconId) {
    const password = document.getElementById(inputId);
    const icon = document.getElementById(iconId);
    
    if (!password || !icon) {
        console.warn('Element tidak ditemukan:', { inputId, iconId });
        return;
    }
    
    if (password.type === 'password') {
        password.type = 'text';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    } else {
        password.type = 'password';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    }
};