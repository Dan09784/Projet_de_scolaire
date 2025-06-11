<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "users";

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}

$nom = $_POST['nom'] ?? '';
$postnom = $_POST['postnom'] ?? '';
$prenom = $_POST['Prenom'] ?? '';
$email = $_POST['email'] ?? '';
$mot_de_passe = $_POST['mot_de_passe'] ?? '';
$etat = $_POST['etat'] ?? '';
$genre = $_POST['genre'] ?? '';
$ville = $_POST['ville'] ?? '';

// Tu peux ajouter un hashage du mot de passe pour la sécurité :
$mot_de_passe_hash = password_hash($mot_de_passe, PASSWORD_DEFAULT);

// Requête préparée
$sql = "INSERT INTO new_users(nom, postnom, Prenom, email, mot_de_passe, etat, genre, ville)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

// Vérifie que la préparation a réussi
if ($stmt === false) {
    die("Erreur de préparation : " . $conn->error);
}

// Lier les paramètres à la requête
$stmt->bind_param("ssssssss", $nom, $postnom, $prenom, $email, $mot_de_passe_hash, $etat, $genre, $ville);

// Exécution de la requête
if ($stmt->execute()) {
    echo "
    <!DOCTYPE html>
    <html lang='fr'>
    <head>
        <meta charset='UTF-8'>
        <title>Inscription réussie</title>
        <style>
            body {
                background: linear-gradient(135deg, #e0f7fa, #b2ebf2);
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
            <h1>✅ Inscription réussie !</h1>
            <p>Merci pour votre inscription sur notre plateforme.</p>
            <a href='index.html'>Retour à l’accueil</a>
        </div>
    </body>
    </html>
";
} else {
    echo "❌ Erreur d'insertion : " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
