
    <!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex justify-center items-center h-screen bg-gray-100">

    <form id="signupForm" class="bg-white p-6 rounded-lg shadow-md w-96" action="../controllers/SignUpController.php" method="POST">
        <h2 class="text-2xl font-semibold mb-4 text-center">Créer un compte</h2>

        <div class="mb-4">
            <label class="block text-gray-700">Prénom</label>
            <input type="text" id="first_name" name="first_name" required class="w-full p-2 border rounded">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Nom</label>
            <input type="text" id="last_name" name="last_name" required class="w-full p-2 border rounded">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Email</label>
            <input type="email" id="email" name="email" required class="w-full p-2 border rounded">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Mot de passe</label>
            <input type="password" id="password" name="password" required class="w-full p-2 border rounded">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Confirmer le mot de passe</label>
            <input type="password" id="confirm_password" name="confirm_password" required class="w-full p-2 border rounded">
            <p id="passwordError" class="text-red-500 text-sm hidden">Les mots de passe ne correspondent pas.</p>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Téléphone</label>
            <input type="tel" id="phone" name="phone" required class="w-full p-2 border rounded">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Date de naissance</label>
            <input type="date" id="birthday" name="birthday" required class="w-full p-2 border rounded">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Rôle</label>
            <select id="role" name="role" required class="w-full p-2 border rounded">
                <option value="sender">Expéditeur</option>
                <option value="driver">Chauffeur</option>
            </select>
        </div>

      

        <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded">S'inscrire</button>
    </form>

   

</body>
</html>


</body>
</html>
