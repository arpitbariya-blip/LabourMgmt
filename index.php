<?php
session_start();
if (!isset($_SESSION['mht_id'])) {
  header("Location: login.php");
  exit();
}
?>
<!DOCTYPE html>
<html class="dark" lang="en">

<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <title>Sevarthi Event Availability</title>
  <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght@100..700,0..1&amp;display=swap"
    rel="stylesheet" />
  <link href="https://fonts.googleapis.com" rel="preconnect" />
  <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
  <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&amp;display=swap" rel="stylesheet" />
  <link
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
    rel="stylesheet" />
  <style>
    .material-symbols-outlined {
      font-variation-settings:
        'FILL' 0,
        'wght' 400,
        'GRAD' 0,
        'opsz' 24
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

<body class="bg-background-light dark:bg-background-dark font-display"
  data-alt="Abstract dark teal gradient background">

  <!-- Logout Button -->
  <div class="fixed top-4 right-4 z-50">
    <a href="logout.php" class="flex items-center gap-2 rounded-lg bg-red-500/10 border border-red-500/20 px-4 py-2 text-sm font-bold text-red-400 backdrop-blur-md hover:bg-red-500/20 transition-all">
      <span class="material-symbols-outlined text-sm">logout</span>
      Logout
    </a>
  </div>

  <div class="relative flex min-h-screen w-full flex-col items-center justify-center p-4"
    style="--radio-dot-svg: url('data:image/svg+xml,%3csvg viewBox=%270 0 16 16%27 fill=%27rgb(0,225,255)%27 xmlns=%27http://www.w3.org/2000/svg%27%3e%3ccircle cx=%278%27 cy=%278%27 r=%273%27/%3e%3c/svg%3e'); --checkbox-tick-svg: url('data:image/svg+xml,%3csvg viewBox=%270 0 16 16%27 fill=%27rgb(0,225,255)%27 xmlns=%27http://www.w3.org/2000/svg%27%3e%3cpath d=%27M12.207 4.793a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0l-2-2a1 1 0 011.414-1.414L6.5 9.086l4.293-4.293a1 1 0 011.414 0z%27/%3e%3c/svg%3e')">
    <div
      class="w-full max-w-2xl rounded-xl border border-primary/20 bg-background-dark/50 p-6 shadow-2xl backdrop-blur-xl md:p-8">
      <div class="mb-6">
        <div class="flex flex-col gap-2">
          <p class="text-3xl font-black leading-tight tracking-[-0.033em] text-white">YMHT Session Response</p>
          <p class="text-base font-normal leading-normal text-primary/70">Welcome, <span class="text-white font-bold"><?php echo htmlspecialchars($_SESSION['user_name']); ?></span> (ID: <?php echo htmlspecialchars($_SESSION['mht_id']); ?>)</p>
        </div>
      </div>
      <form class="flex flex-col gap-6" id="ResponseForm" method="POST" action="submit_response.php">
        <input type="hidden" name="mht_id" value="<?php echo htmlspecialchars($_SESSION['mht_id']); ?>">

        <div>
          <h2 class="pb-2 text-lg font-bold leading-tight tracking-[-0.015em] text-white">Availability</h2>
          <div class="flex flex-col gap-3">
            <label
              class="flex cursor-pointer items-center gap-4 rounded-lg border border-solid border-primary/20 p-[15px] transition-colors hover:bg-primary/10">
              <input
                class="form-checkbox h-5 w-5 rounded-md border-2 border-primary/30 bg-transparent text-primary checked:border-primary checked:bg-[image:--checkbox-tick-svg] focus:outline-none focus:ring-0 focus:ring-offset-0 checked:focus:border-primary"
                name="day1" type="checkbox" value="yes" />
              <div class="flex grow flex-col">
                <p class="text-sm font-medium leading-normal text-white">Ymht 1</p>
              </div>
            </label>
            <label
              class="flex cursor-pointer items-center gap-4 rounded-lg border border-solid border-primary/20 p-[15px] transition-colors hover:bg-primary/10">
              <input
                class="form-checkbox h-5 w-5 rounded-md border-2 border-primary/30 bg-transparent text-primary checked:border-primary checked:bg-[image:--checkbox-tick-svg] focus:outline-none focus:ring-0 focus:ring-offset-0 checked:focus:border-primary"
                name="day2" type="checkbox" value="yes" />
              <div class="flex grow flex-col">
                <p class="text-sm font-medium leading-normal text-white">ymht 2</p>
              </div>
            </label>
            <label
              class="flex cursor-pointer items-center gap-4 rounded-lg border border-solid border-primary/20 p-[15px] transition-colors hover:bg-primary/10">
              <input
                class="form-checkbox h-5 w-5 rounded-md border-2 border-primary/30 bg-transparent text-primary checked:border-primary checked:bg-[image:--checkbox-tick-svg] focus:outline-none focus:ring-0 focus:ring-offset-0 checked:focus:border-primary"
                name="day3" type="checkbox" value="yes" />
              <div class="flex grow flex-col">
                <p class="text-sm font-medium leading-normal text-white">ymht 3</p>
              </div>
            </label>
          </div>
        </div>
        <div>
          <label class="flex flex-col">
            <p class="pb-2 text-base font-medium leading-normal text-white">Remarks</p>
            <textarea name="remarks"
              class="form-input flex h-24 w-full min-w-0 flex-1 resize-none overflow-hidden rounded-lg border border-primary/20 bg-[#173236] p-[15px] text-base font-normal leading-normal text-white placeholder:text-primary/50 focus:border-primary focus:outline-0 focus:ring-0"
              placeholder="Enter your remarks"></textarea>
          </label>
        </div>
        <button
          class="flex h-14 w-full items-center justify-center gap-2.5 rounded-lg bg-primary px-5 py-3.5 text-base font-bold leading-normal text-background-dark shadow-lg transition-transform hover:scale-[1.02] active:scale-[0.98]"
          type="submit">
          <span class="material-symbols-outlined">send</span>
          Submit Response
        </button>
      </form>
    </div>
  </div>
</body>

</html>