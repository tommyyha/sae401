    document.addEventListener("DOMContentLoaded", function() {
    const usernameInput = document.querySelector('input[name="username"]');
    const passwordInput = document.querySelector('input[name="password"]');

    usernameInput.addEventListener("input", function() {
    if (this.value.trim() !== '') {
    this.removeAttribute("name");
} else {
    this.setAttribute("name", "username");
}
});

    passwordInput.addEventListener("input", function() {
    if (this.value.trim() !== '') {
    this.removeAttribute("name");
} else {
    this.setAttribute("name", "password");
}
});
});
