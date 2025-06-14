<?php
include 'unite.php';

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
$sql = "INSERT INTO new_users (nom, postnom, Prenom, email, mot_de_passe, etat, genre, ville)
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
                    <title>Bienvenue</title>
                    <meta http-equiv='refresh' content='3;url=index.html'>
                    <style>
                        body {
                            margin: 0;
                            padding: 0;
                            font-family: 'Segoe UI', sans-serif;
                            background: linear-gradient(135deg, #00b894, #0984e3);
                            display: flex;
                            flex-direction: column;
                            justify-content: center;
                            align-items: center;
                            height: 100vh;
                            color: white;
                            text-align: center;
                        }

                        h1 {
                            font-size: 3em;
                            margin-bottom: 10px;
                            animation: fadeIn 1s ease-in-out;
                        }

                        p {
                            font-size: 1.3em;
                            animation: fadeIn 2s ease-in-out;
                        }

                        .loader {
                            margin-top: 30px;
                            border: 6px solid rgba(255, 255, 255, 0.3);
                            border-top: 6px solid white;
                            border-radius: 50%;
                            width: 50px;
                            height: 50px;
                            animation: spin 1s linear infinite;
                        }

                        @keyframes spin {
                            0% { transform: rotate(0deg); }
                            100% { transform: rotate(360deg); }
                        }

                        @keyframes fadeIn {
                            from { opacity: 0; transform: translateY(-20px); }
                            to { opacity: 1; transform: translateY(0); }
                        }
                    </style>
                </head>
                <body>
                    <h1>Bienvenue, $nom !</h1>
                    <p>Connexion réussie. Redirection vers la page d'accueil...</p>
                    <div class='loader'></div>
                </body>
                </html>
";
} else {
    echo "❌ Erreur d'insertion : " . $stmt->error;
}

$stmt->close();
$conn->close();
?>