<?php
session_start();

// Connexion à la base de données
$host = "localhost";
$user = "root";
$password = "";
$dbname = "users";

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}

// Récupération sécurisée des données du formulaire
$email = $_POST['email'] ?? '';
$mot_de_passe = $_POST['mot_de_passe'] ?? '';

// Rechercher l'utilisateur avec email
$sql = "SELECT * FROM new_users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($user = $result->fetch_assoc()) {
    // Vérification du mot de passe haché
    if (password_verify($mot_de_passe, $user['mot_de_passe'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['email'] = $user['email'];

        echo "
        <!DOCTYPE html>
        <html lang='fr'>
        <head>
            <meta charset='UTF-8'>
            <title>Connexion réussie</title>
            <style>
                body {
                    background: linear-gradient(135deg, #e8f5e9, #a5d6a7);
                    font-family: 'Segoe UI', sans-serif;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    height: 100vh;
                    margin: 0;
                }
                .success-box {
                    background: white;
                    padding: 40px;
                    border-radius: 12px;
                    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
                    text-align: center;
                    max-width: 400px;
                    animation: fadeIn 0.6s ease-in-out;
                }
                .success-box h1 {
                    color: #2e7d32;
                    margin-bottom: 20px;
                }
                .success-box p {
                    color: #555;
                    font-size: 16px;
                    margin-bottom: 30px;
                }
                .success-box a {
                    text-decoration: none;
                    background-color: #2e7d32;
                    color: white;
                    padding: 10px 20px;
                    border-radius: 8px;
                    transition: background 0.3s ease;
                }
                .success-box a:hover {
                    background-color: #1b5e20;
                }
                @keyframes fadeIn {
                    from { opacity: 0; transform: scale(0.95); }
                    to { opacity: 1; transform: scale(1); }
                }
            </style>
        </head>
        <body>
            <div class='success-box'>
                <h1>✅ Connexion réussie</h1>
                <p>Bienvenue, " . htmlspecialchars($user['Prenom']) . " !</p>
                <a href='dashboard.php'>Accéder à mon espace</a>
            </div>
        </body>
        </html>
        ";
    } else {
        echo "❌ Mot de passe incorrect.";
    }
} else {
    echo "❌ Aucun compte trouvé avec cet e-mail.";
}

$stmt->close();
$conn->close();
?>
