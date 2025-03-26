document.addEventListener("DOMContentLoaded", function () {
    // Registrace
    const registerForm = document.getElementById("register-form");
    if (registerForm) {
      registerForm.addEventListener("submit", function (e) {
        e.preventDefault();
  
        const username = document.getElementById("username").value.trim();
        const email = document.getElementById("email").value.trim();
        const password = document.getElementById("password").value.trim();
  
        if (!username || !email || !password) {
          alert("Vyplňte všechny údaje.");
          return;
        }
  
        let users = JSON.parse(localStorage.getItem("users")) || [];
        if (users.find(u => u.email === email)) {
          alert("Email je již registrovaný.");
          return;
        }
  
        users.push({ username, email, password });
        localStorage.setItem("users", JSON.stringify(users));
        alert("Registrace proběhla úspěšně!");
        registerForm.reset();
      });
    }
  
    // Přihlášení
    const loginForm = document.getElementById("auth-form");
    if (loginForm) {
      loginForm.addEventListener("submit", function (e) {
        e.preventDefault();
  
        const username = document.getElementById("username").value.trim();
        const password = document.getElementById("password").value.trim();
  
        if (!username || !password) {
          alert("Vyplňte všechny údaje.");
          return;
        }
  
        const users = JSON.parse(localStorage.getItem("users")) || [];
        const user = users.find(u => u.username === username && u.password === password);
  
        if (user) {
          alert("Úspěšné přihlášení!");
          window.location.href = "/html/ticket.html"; // přesměrování
        } else {
          alert("Neplatné přihlašovací údaje.");
        }
      });
    }
  });
  