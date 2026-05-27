<?php
session_start();
if (isset($_SESSION['mht_id'])) {
  header("Location: index.html");
  exit();
}
?>
<!DOCTYPE html>
<html class="dark" lang="en">

<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <title>Sevarthi Login | MHT ID</title>
  <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght@100..700,0..1&amp;display=swap"
    rel="stylesheet" />
  <link href="https://fonts.googleapis.com" rel="preconnect" />
  <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
  <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&amp;display=swap" rel="stylesheet" />
  <style>
    .material-symbols-outlined {
      font-variation-settings:
        'FILL' 0,
        'wght' 400,
        'GRAD' 0,
        'opsz' 24
    }

    @keyframes blob {
      0% {
        transform: translate(0px, 0px) scale(1);
      }

      33% {
        transform: translate(30px, -50px) scale(1.1);
      }

      66% {
        transform: translate(-20px, 20px) scale(0.9);
      }

      100% {
        transform: translate(0px, 0px) scale(1);
      }
    }

    .animate-blob {
      animation: blob 7s infinite;
    }

    .animation-delay-2000 {
      animation-delay: 2s;
    }

    .animation-delay-4000 {
      animation-delay: 4s;
    }
  </style>
  <script>
    tailwind.config = {
      darkMode: "class",
      theme: {
        extend: {
          colors: {
            "primary": "#00e1ff",
            "background-light": "#f5f8f8",
            "background-dark": "#0f2123",
          },
          fontFamily: {
            "display": ["Manrope", "sans-serif"]
          },
          borderRadius: {
            "DEFAULT": "0.5rem",
            "lg": "1rem",
            "xl": "1.5rem",
            "full": "9999px"
          },
        },
      },
    }
  </script>
</head>

<body class="bg-background-dark font-display overflow-hidden" data-alt="Abstract dark teal gradient background">
  <!-- Background Decorations -->
  <div class="fixed inset-0 overflow-hidden pointer-events-none">
    <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] rounded-full bg-primary/10 blur-[120px] animate-blob"></div>
    <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] rounded-full bg-primary/5 blur-[120px] animate-blob animation-delay-2000"></div>
    <div class="absolute top-[20%] right-[10%] w-[30%] h-[30%] rounded-full bg-blue-500/5 blur-[100px] animate-blob animation-delay-4000"></div>
  </div>

  <div class="relative flex min-h-screen w-full flex-col items-center justify-center p-4">
    <div class="w-full max-w-md rounded-2xl border border-primary/20 bg-background-dark/40 p-8 shadow-2xl backdrop-blur-2xl transition-all duration-500 hover:border-primary/40">
      <div class="mb-8 text-center">
        <div class="inline-flex h-16 w-16 items-center justify-center rounded-xl bg-primary/10 mb-4 border border-primary/20">
          <span class="material-symbols-outlined text-4xl text-primary">fingerprint</span>
        </div>
        <h1 class="text-3xl font-black leading-tight tracking-tight text-white mb-2">Welcome Back</h1>
        <p class="text-base font-normal leading-normal text-primary/70">Enter your MHT ID to continue</p>
      </div>

      <?php if (isset($_GET['error'])): ?>
        <div class="mb-6 flex items-center gap-3 rounded-lg border border-red-500/30 bg-red-500/10 p-4 text-red-400">
          <span class="material-symbols-outlined">error</span>
          <p class="text-sm font-medium"><?php echo htmlspecialchars($_GET['error']); ?></p>
        </div>
      <?php endif; ?>

      <form class="flex flex-col gap-6" id="LoginForm" method="POST" action="api/auth.php">
        <div class="flex flex-col gap-2">
          <label for="mht_id" class="text-sm font-bold text-white/80 ml-1">MHT ID</label>
          <div class="relative">
            <!-- <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-primary/50">person</span> -->
            <input
              id="mht_id"
              name="mht_id"
              type="text"
              required
              class="form-input flex h-14 w-full rounded-xl border border-primary/20 bg-background-dark/60 pl-12 pr-4 text-base font-medium text-white placeholder:text-primary/30 focus:border-primary focus:outline-0 focus:ring-2 focus:ring-primary/20 transition-all"
              placeholder="e.g. 123456" />
          </div>
        </div>

        <button
          class="flex h-14 w-full items-center justify-center gap-2.5 rounded-xl bg-primary px-5 py-3.5 text-base font-bold leading-normal text-background-dark shadow-[0_0_20px_rgba(0,225,255,0.3)] transition-all duration-300 hover:scale-[1.02] hover:shadow-[0_0_30px_rgba(0,225,255,0.5)] active:scale-[0.98]"
          type="submit">
          Login
          <!-- <span class="material-symbols-outlined text-xl">login</span> -->
        </button>
      </form>

      <div class="mt-8 text-center">
        <p class="text-xs text-primary/40 uppercase tracking-widest font-bold">Sevarthi Portal</p>
      </div>
    </div>
  </div>
</body>

</html>