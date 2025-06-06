 document.addEventListener("DOMContentLoaded", () => {
    // Sélectionner tous les boutons de consultation
    const buttons = document.querySelectorAll(".bouton");

    // Ajouter un effet de survol et un message interactif au clic
    buttons.forEach(button => {
        button.addEventListener("mouseenter", () => {
            button.style.transform = "scale(1.1)";
            button.style.boxShadow = "0px 10px 20px rgba(0, 234, 255, 0.5)";
        });

        button.addEventListener("mouseleave", () => {
            button.style.transform = "scale(1)";
            button.style.boxShadow = "none";
        });

        button.addEventListener("click", (event) => {
            event.preventDefault(); // Empêche le lien de s'ouvrir directement
            const doctorName = button.parentElement.querySelector("h3").textContent;
            alert(`🔹 Vous avez sélectionné : ${doctorName}\n📅 Veuillez choisir une date pour votre rendez-vous.`);
            setTimeout(() => {
                window.location.href = button.getAttribute("href"); // Redirection après 2 secondes
            }, 2000);
        });
    });
});
