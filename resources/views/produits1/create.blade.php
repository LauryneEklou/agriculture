<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Produit</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fa;
            margin: 0;
            padding: 0;
            color: #333;
        }

        h1 {
            text-align: center;
            color: #4CAF50;
            margin-top: 50px;
        }

        form {
            width: 60%;
            margin: 20px auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            font-weight: bold;
            margin: 10px 0 5px;
        }

        input[type="text"],
        input[type="number"],
        input[type="date"],
        select {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 15px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }
        
        /* Add responsive design */
        @media (max-width: 768px) {
            form {
                width: 90%;
                padding: 15px;
            }

            button {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <h1>Ajouter un Produit Récolté</h1>
    <form action="{{ route('produits.store') }}" method="POST">
        @csrf
        <label>Nom :</label>
        <input type="text" name="nom" required><br>

        <label>Type :</label>
        <select name="type">
            <option value="Fruits">Fruits</option>
            <option value="Légumes">Légumes</option>
            <option value="Céréales">Céréales</option>
        </select><br>

        <label>Quantité en Stock :</label>
        <input type="number" step="0.01" name="quantite" required><br>

        <label>Lieu de stockage :</label>
        <input type="text" name="lieu_stockage" required><br>

        <label>Date de Récolte :</label>
        <input type="date" name="date_recolte" required><br>

        <label>Statut :</label>
        <select name="statut">
            <option value="Stocké">Stocké</option>
            <option value="Vendu">Vendu</option>
            <option value="Distribué">Distribué</option>
        </select><br>

        <button type="submit">Ajouter</button>
    </form>
</body>
</html>
