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
    <style>
        /* Animasi tombol saat ditekan */
        .btn-press:active {
            transform: scale(0.97);
        }
        /* Animasi input focus */
        .input-focus:focus {
            outline: none;
            box-shadow: 0 0 10px rgba(59, 130, 246, 0.6);
            border-color: rgba(59, 130, 246, 0.8);
        }
    </style>
</head>
<body class="h-screen flex items-center justify-center bg-cover bg-center relative" 
      style="background-image: url('../assets/bgloginbz.jpg');">

    <!-- Overlay gradient -->
    <div class="absolute inset-0 bg-gradient-to-r from-blue-500/40 to-green-500/40"></div>

    <!-- Card login -->
    <div class="relative bg-white/70 backdrop-blur-xl rounded-3xl shadow-2xl p-10 w-full max-w-md border border-green-200 animate-fadeIn">
        <h1 class="text-3xl font-extrabold text-center text-blue-900 mb-8 tracking-wide">Selamat Datang</h1>

        <?php if(!empty($error)): ?>
            <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-5 shadow-inner text-center animate-shake">
                <?= $error; ?>
            </div>
        <?php endif; ?>

        <form method="POST" class="space-y-6">

            <!-- Username -->
            <div>
                <label class="block text-gray-700 mb-2 font-medium">Username</label>
                <input type="text" name="username" required
                       class="input-focus w-full border border-green-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-300 transition duration-300">
            </div>

            <!-- Password -->
            <div>
                <label class="block text-gray-700 mb-2 font-medium">Password</label>
                <input type="password" name="password" required
                       class="input-focus w-full border border-green-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-300 transition duration-300">
            </div>

            <!-- Tombol Login -->
            <button type="submit" name="login"
                    class="btn-press w-full bg-gradient-to-r from-green-500 to-blue-500 text-white py-2 rounded-2xl shadow-lg hover:from-green-600 hover:to-blue-600 transition transform duration-150">
                Masuk
            </button>
        </form>

        <p class="text-gray-700 text-center mt-6 text-sm">
            &copy; <?= date("Y"); ?> Inventaris Barang
        </p>
    </div>

    <!-- Animasi sederhana -->
    <script>
        // Simple fade-in animation
        document.querySelector('.animate-fadeIn').style.opacity = 0;
        window.addEventListener('load', () => {
            document.querySelector('.animate-fadeIn').style.transition = "opacity 0.8s ease";
            document.querySelector('.animate-fadeIn').style.opacity = 1;
        });

        // Shake animation for error
        if(document.querySelector('.animate-shake')){
            const el = document.querySelector('.animate-shake');
            el.style.animation = "shake 0.5s";
        }
    </script>

    <style>
        @keyframes shake {
            0% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            50% { transform: translateX(5px); }
            75% { transform: translateX(-5px); }
            100% { transform: translateX(0); }
        }
    </style>
</body>
</html>
