<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['email']) && isset($_POST['mot_de_passe'])) {
        include 'entrer,php';

        $email = $_POST['email'];
        $mot_de_passe = $_POST['mot_de_passe'];

        $sql = "SELECT * FROM  new_users WHERE email='$email'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) === 1) {
            $user = mysqli_fetch_assoc($result);
            if (password_verify($mot_de_passe, $user['mot_de_passe'])) {
                session_start();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['nom'] = $user['nom'];
                $nom = $user['nom']; // Pour l'affichage

                // Page stylisée de bienvenue + redirection
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
                </html>";
                exit();
            } else {
                echo "Mot de passe incorrect.";
            }
        } else {
            echo "Email non trouvé.";
        }
    } else {
        echo "Veuillez remplir tous les champs.";
    }
} else {
    echo "Accès non autorisé.";
}
?>
