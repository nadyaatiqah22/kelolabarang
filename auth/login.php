<?php 
include "../config/config.php";

// Jika sudah login, langsung ke dashboard
if (isset($_SESSION['admin'])) {
    header("Location: /kelolabarang/pages/dashboard.php");
    exit();
}

// Jika tombol login ditekan
if (isset($_POST['login'])) {

    $username = esc($_POST['username']);
    $password = md5($_POST['password']);

    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $user = find($sql);

    if ($user) {
        // Simpan ke session
        $_SESSION['admin'] = [
            'id' => $user['id'],
            'username' => $user['username'],
            'nama' => $user['nama']
        ];

        header("Location: /kelolabarang/pages/dashboard.php");
        exit();
    } else {
        $error = "Username atau password salah!";
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Kelola Barang</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-screen flex items-center justify-center bg-cover bg-center relative" 
      style="background-image: url('../assets/bg3.jpg');">

<div class="absolute inset-0 bg-gradient-to-r from-blue-500/40 to-green-500/40"></div>

<div class="bg-white/90 backdrop-blur-lg rounded-2xl shadow-2xl p-10 w-full max-w-md border border-green-200">
    <h1 class="text-3xl font-bold text-center text-blue-900 mb-6">Login</h1>

    <?php if(!empty($error)): ?>
        <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4 shadow-inner">
            <?= $error; ?>
        </div>
    <?php endif; ?>

    <form method="POST" class="space-y-5">
        <div>
            <label class="block text-gray-700 mb-1 font-medium">Username</label>
            <input type="text" name="username" required
                   class="w-full border border-green-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-300 focus:outline-none transition">
        </div>

        <div>
            <label class="block text-gray-700 mb-1 font-medium">Password</label>
            <input type="password" name="password" required
                   class="w-full border border-green-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-300 focus:outline-none transition">
        </div>

        <button type="submit" name="login"
                class="w-full bg-gradient-to-r from-green-500 to-blue-500 text-white py-2 rounded-2xl shadow-lg hover:from-green-600 hover:to-blue-600 transition">
            Masuk
        </button>
    </form>

    <p class="text-gray-700 text-center mt-4 text-sm">
        &copy; <?= date("Y"); ?> Inventaris Barang
    </p>
</div>

</body>
</html>
