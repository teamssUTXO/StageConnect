// Logique d'authentification
document.addEventListener("DOMContentLoaded", function () {
    const users = [
        { email: "eleve@example.com", password: "eleve123", role: "etudiant", name: "Élève Dupont" },
        { email: "pilote@example.com", password: "pilote123", role: "pilote", name: "Pilote Martin" },
        { email: "admin@example.com", password: "admin123", role: "admin", name: "Admin Admin" },
    ];

    const loginForm = document.querySelector(".login-form");
    if (loginForm) {
        loginForm.addEventListener("submit", function (event) {
            event.preventDefault();
            const email = document.getElementById("email").value;
            const password = document.getElementById("password").value;

            const user = users.find((u) => u.email === email && u.password === password);
            if (user) {
                localStorage.setItem("loggedInUser", JSON.stringify(user));
                window.location.href = "home.html"; // Rediriger vers la page d'accueil
            } else {
                const errorMessage = document.createElement("div");
                errorMessage.textContent = "Adresse mail ou mot de passe incorrect.";
                errorMessage.style.color = "red";
                loginForm.appendChild(errorMessage);
            }
        });
    }
});

function updateUIForLoggedInUser(user) {
    const loginButton = document.querySelector(".btn-login");
    if (loginButton) {
        loginButton.innerHTML = `<i class="fa-solid fa-user"></i> ${user.name}`;
        loginButton.onclick = function () {
            window.location.href = "account.html";
        };
    }

    const burgerLoginButton = document.querySelector(".btn-burger-login");
    if (burgerLoginButton) {
        burgerLoginButton.innerHTML = `<i class="fa-solid fa-user"></i> ${user.name}`;
        burgerLoginButton.onclick = function () {
            window.location.href = "account.html";
        };
    }

    // Mettre à jour les autorisations en fonction du rôle
    updatePermissions(user.role);
}

function logout() {
    localStorage.removeItem("loggedInUser");
    window.location.href = "home.html";
}