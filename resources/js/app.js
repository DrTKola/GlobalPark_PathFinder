import './bootstrap';

const emailInput = document.querySelector('#email');
const passwordInput = document.querySelector('#password');
const loginSubmit = document.querySelector('[data-login-submit]');
const passwordToggle = document.querySelector('[data-password-toggle]');

const updateLoginButton = () => {
    if (!emailInput || !passwordInput || !loginSubmit) {
        return;
    }

    loginSubmit.disabled = emailInput.value.trim() === '' || passwordInput.value === '';
};

emailInput?.addEventListener('input', updateLoginButton);
passwordInput?.addEventListener('input', updateLoginButton);

passwordToggle?.addEventListener('click', () => {
    if (!passwordInput) {
        return;
    }

    const isPasswordVisible = passwordInput.type === 'text';
    passwordInput.type = isPasswordVisible ? 'password' : 'text';
    passwordToggle.setAttribute('aria-pressed', String(!isPasswordVisible));
    passwordToggle.setAttribute('aria-label', isPasswordVisible ? 'Show password' : 'Hide password');
});

updateLoginButton();
