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
    /* Gradient animasi background */
    body {
        background: linear-gradient(135deg, #0f111a, #0a0f0a, #0f111a);
        background-size: 600% 600%;
        animation: gradientBG 20s ease infinite;
    }

    @keyframes gradientBG {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    /* Input fokus neon */
    .input-focus:focus {
        outline: none;
        box-shadow: 0 0 12px rgba(5, 150, 105, 0.8);
        border-color: rgba(5, 150, 105, 0.8);
    }

    /* Tombol tekan */
    .btn-press:active {
        transform: scale(0.97);
    }

    /* Fade-in animasi */
    .fade-in {
        opacity: 0;
        transform: translateY(20px);
        animation: fadeInUp 0.8s forwards;
    }

    @keyframes fadeInUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Shake animasi untuk error */
    .shake {
        animation: shakeAnim 0.5s;
    }

    @keyframes shakeAnim {
        0% { transform: translateX(0); }
        25% { transform: translateX(-5px); }
        50% { transform: translateX(5px); }
        75% { transform: translateX(-5px); }
        100% { transform: translateX(0); }
    }

    /* Floating particle circles */
    .bg-particle {
        position: absolute;
        border-radius: 50%;
        background: rgba(5, 150, 105, 0.3);
        animation: float 8s infinite ease-in-out;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0) translateX(0); opacity: 0.5; }
        50% { transform: translateY(-50px) translateX(30px); opacity: 1; }
    }
</style>
</head>
<body class="h-screen flex items-center justify-center relative overflow-hidden">

    <!-- Floating particles -->
    <div class="bg-particle" style="top:15%; left:10%; width:15px; height:15px;"></div>
    <div class="bg-particle" style="top:70%; left:80%; width:20px; height:20px;"></div>
    <div class="bg-particle" style="top:50%; left:50%; width:25px; height:25px;"></div>

    <!-- Card login -->
    <div class="fade-in relative bg-black/70 backdrop-blur-xl rounded-3xl shadow-2xl p-10 w-full max-w-md border border-green-900">
        
        <h1 class="text-3xl font-extrabold text-center text-green-400 mb-8 tracking-wide">
            Inventaris Barang
        </h1>

        <?php if(!empty($error)): ?>
            <div class="shake bg-red-900 text-white px-4 py-2 rounded mb-5 shadow-inner text-center">
                <?= $error; ?>
            </div>
        <?php endif; ?>

        <form method="POST" class="space-y-6">

            <!-- Username -->
            <div>
                <label class="block text-white mb-2 font-medium">Username</label>
                <input type="text" name="username" required
                       class="input-focus w-full border border-green-800 rounded-lg px-4 py-2 bg-black/20 text-white placeholder-green-300 focus:ring-2 focus:ring-green-500 transition duration-300">
            </div>

            <!-- Password -->
            <div>
                <label class="block text-white mb-2 font-medium">Password</label>
                <input type="password" name="password" required
                       class="input-focus w-full border border-green-800 rounded-lg px-4 py-2 bg-black/20 text-white placeholder-green-300 focus:ring-2 focus:ring-green-500 transition duration-300">
            </div>

            <!-- Tombol Login -->
            <button type="submit" name="login"
                    class="btn-press w-full bg-gradient-to-r from-green-700 to-green-500 text-white py-2 rounded-2xl shadow-lg hover:from-green-600 hover:to-green-400 transition transform duration-150">
                Masuk
            </button>
        </form>

        <div class="mt-4 text-center">
    <a href="../assets/bukupanduan.pdf" target="_blank"
       class="inline-block bg-gradient-to-r from-green-500 to-green-500 text-black px-5 py-2 rounded-2xl shadow-lg hover:from-green-600 hover:to-green-400 transition transform duration-150">
       Lihat Panduan PDF
    </a>
</div>

        <p class="text-gray-400 text-center mt-6 text-sm">
            &copy; <?= date("Y"); ?> Inventaris Barang
        </p>
    </div>

</body>
</html>
