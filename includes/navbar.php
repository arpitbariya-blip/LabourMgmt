<html class="Dark" lang="en">

<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <title>Admin Panel - Labourmgmt</title>
  <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
  <link
    href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&amp;family=Inter:wght@400;500;600&amp;display=swap"
    rel="stylesheet" />
  <link
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
    rel="stylesheet" />
  <link
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
    rel="stylesheet" />
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <link
    href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&amp;family=Inter:wght@400;500;600&amp;display=swap"
    rel="stylesheet" />
  <!-- Material Symbols -->
  <link
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
    rel="stylesheet" />
  <link
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
    rel="stylesheet" />
  <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
  <script id="tailwind-config">
    tailwind.config = {
      darkMode: "class",
      theme: {
        extend: {
          colors: {
            "on-tertiary-fixed-variant": "#564427",
            "inverse-on-surface": "#eaf1ff",
            "on-primary-fixed": "#111c2d",
            "secondary": "#0058be",
            "on-primary-fixed-variant": "#3c475a",
            "surface-container": "#e5eeff",
            "surface-dim": "#cbdbf5",
            "surface-container-highest": "#d3e4fe",
            "on-tertiary-container": "#a38c6a",
            "error": "#ba1a1a",
            "tertiary-container": "#35260c",
            "secondary-fixed": "#d8e2ff",
            "surface-tint": "#545f73",
            "on-surface-variant": "#45474c",
            "primary": "#091426",
            "on-background": "#0b1c30",
            "surface-bright": "#f8f9ff",
            "on-secondary": "#ffffff",
            "surface-variant": "#d3e4fe",
            "on-secondary-fixed": "#001a42",
            "on-error-container": "#93000a",
            "on-surface": "#0b1c30",
            "tertiary-fixed-dim": "#ddc39d",
            "outline": "#75777d",
            "primary-container": "#1e293b",
            "on-secondary-container": "#fefcff",
            "inverse-surface": "#213145",
            "error-container": "#ffdad6",
            "secondary-fixed-dim": "#adc6ff",
            "surface-container-high": "#dce9ff",
            "primary-fixed-dim": "#bcc7de",
            "on-secondary-fixed-variant": "#004395",
            "on-primary": "#ffffff",
            "surface-container-low": "#eff4ff",
            "secondary-container": "#2170e4",
            "background": "#f8f9ff",
            "outline-variant": "#c5c6cd",
            "surface": "#f8f9ff",
            "on-error": "#ffffff",
            "primary-fixed": "#d8e3fb",
            "on-tertiary-fixed": "#271902",
            "inverse-primary": "#bcc7de",
            "tertiary": "#1e1200",
            "surface-container-lowest": "#ffffff",
            "tertiary-fixed": "#fadfb8",
            "on-tertiary": "#ffffff",
            "on-primary-container": "#8590a6"
          },
          fontFamily: {
            "headline": ["Manrope"],
            "body": ["Inter"],
            "label": ["Inter"]
          },
          borderRadius: {
            "DEFAULT": "0.25rem",
            "lg": "0.5rem",
            "xl": "0.75rem",
            "full": "9999px"
          },
        },
      },
    }
  </script>
  <style src="css/style: .css;"></style>
</head>

<body class="bg-surface text-on-surface min-h-screen flex overflow-hidden">
  <!-- SideNavBar Component -->
  <aside id="sidebar"
    class="fixed left-0 top-0 h-screen flex flex-col p-4 z-50 w-64 bg-slate-50 dark:bg-slate-950 font-manrope text-sm font-medium transition-transform duration-300 -translate-x-full lg:translate-x-0">
    <div class="flex items-center gap-3 px-2 mb-10">
      <div
        class="w-10 h-10 rounded-lg bg-primary-container flex items-center justify-center text-on-primary-container shadow-sm">
        <span class="material-symbols-outlined text-2xl" data-icon="architecture">architecture</span>
      </div>
      <div>
        <h1 class="text-lg font-black text-slate-900 dark:text-slate-50 leading-none">Architect Admin</h1>
        <p class="text-[10px] text-on-surface-variant font-bold uppercase tracking-widest mt-1">Management Suite</p>
      </div>
    </div>
    <nav class="flex-1 space-y-1 custom-scrollbar overflow-y-auto">
      <a class="flex items-center gap-3 px-4 py-3 cursor-pointer tap-highlight-none transition-transform duration-200 hover:translate-x-1 text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-900"
        href="dashboard">
        <span class="material-symbols-outlined" data-icon="dashboard">dashboard</span>
        <span>Dashboard</span>
      </a>
      <a class="flex items-center gap-3 px-4 py-3 cursor-pointer tap-highlight-none transition-transform duration-200 hover:translate-x-1 text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-900"
        href="labour_atds">
        <span class="material-symbols-outlined" data-icon="receipt_long">receipt_long</span>
        <span>Labour</span>
      </a>
      <a class="flex items-center gap-3 px-4 py-3 cursor-pointer tap-highlight-none transition-transform duration-200 hover:translate-x-1 text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-900"
        href="material">
        <span class="material-symbols-outlined" data-icon="inventory_2">inventory_2</span>
        <span>Materials</span>
      </a>
      <a class="flex items-center gap-3 px-4 py-3 cursor-pointer tap-highlight-none transition-transform duration-200 hover:translate-x-1 text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-900"
        href="invoice">
        <span class="material-symbols-outlined" data-icon="receipt_long">receipt_long</span>
        <span>Invoices</span>
      </a>

    </nav>
    <div class="mt-auto space-y-4 pt-4 border-t border-outline-variant/20">
      <a class="flex items-center gap-3 px-4 py-3 cursor-pointer tap-highlight-none transition-transform duration-200 hover:translate-x-1 text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-900"
        href="#">
        <span class="material-symbols-outlined" data-icon="logout">logout</span>
        <span>Logout</span>
      </a>
    </div>
  </aside>
  <main id="main-content" class="flex-1 lg:ml-64 min-h-screen relative overflow-y-auto bg-surface transition-all duration-300">
    <header
      class="sticky top-0 w-full flex justify-between items-center px-6 py-3 bg-slate-50/80 dark:bg-slate-900/80 backdrop-blur-xl text-slate-900 dark:text-slate-50 font-manrope text-sm font-semibold tracking-tight z-40 shadow-sm dark:shadow-none">
      <div class="flex items-center gap-4 lg:gap-8">
        <button id="sidebarToggle" class="p-2 -ml-2 rounded-full hover:bg-slate-200/50 transition-colors active:scale-95 duration-200">
          <span class="material-symbols-outlined" data-icon="menu">menu</span>
        </button>
        <h1 class="text-xl font-bold tracking-tighter text-slate-900 dark:text-slate-50">Labourmgmt</h1>
        <nav class="hidden md:flex items-center gap-6">
          <a class="text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-100 transition-colors"
            href="dashboard">Dashboard</a>
          <a class="text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-100 transition-colors"
            href="labour_atds">Labour</a>
          <a class="text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-100 transition-colors"
            href="material">Materials</a>
          <a class="text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-100 transition-colors"
            href="invoice">Invoices</a>

        </nav>
      </div>
      <div class="flex items-center gap-4">
        <!-- <div class="relative group">
          <input
            class="bg-surface-container-low border-none rounded-full px-4 py-2 text-xs w-64 focus:ring-2 focus:ring-secondary/20 transition-all outline-none"
            placeholder="Search resources..." type="text" />
          <span class="material-symbols-outlined absolute right-3 top-2 text-on-surface-variant text-lg"
            data-icon="search">search</span>
        </div> -->
        <div class="flex items-center gap-2">
          <button class="p-2 rounded-full hover:bg-slate-200/50 transition-colors active:scale-95 duration-200">
            <span class="material-symbols-outlined" data-icon="notifications">notifications</span>
          </button>
          <button class="p-2 rounded-full hover:bg-slate-200/50 transition-colors active:scale-95 duration-200">
            <span class="material-symbols-outlined" data-icon="settings">settings</span>
          </button>
          <div class="h-8 w-8 rounded-full bg-surface-variant overflow-hidden ml-2 ring-2 ring-outline-variant/20">
            <img alt="User profile avatar" class="w-full h-full object-cover"
              data-alt="professional headshot of an executive in a well-lit modern architectural office setting"
              src="https://lh3.googleusercontent.com/aida-public/AB6AXuB4lK-U27ORagTwehaOH6O67FFZTjbTat7ITKaTg4_uB2XSUjg5prw2Ckf6v1s6Kj0NUxlRLTLRDaiKya3w3cD20ZXOkTjEaukocWQvyt1v3DXXxgBNxncly112ZCcjzDbj4WTYGN3-rCUYsV18Q1HyZ0DUR-kACfXxLbvT9TfYdBkrowcel9bA1_n0fgdM__MTNZorEpKJNmhA0rHZh08NDPXNHfJLrAy9o_d_du0seaDcgECfPsvbe-rh5AKAcrlTPt63oa-_wNKJ" />
          </div>
        </div>
      </div>
    </header>

    <!-- Overlay for mobile sidebar -->
    <div id="sidebarOverlay" class="fixed inset-0 bg-slate-900/50 z-40 hidden lg:hidden backdrop-blur-sm transition-opacity opacity-0"></div>

    <script>
      document.addEventListener('DOMContentLoaded', () => {
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('main-content');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebarOverlay = document.getElementById('sidebarOverlay');

        if (sidebarToggle) {
          sidebarToggle.addEventListener('click', () => {
            if (window.innerWidth < 1024) {
              // Mobile toggle
              sidebar.classList.toggle('-translate-x-full');

              // Toggle overlay
              if (sidebar.classList.contains('-translate-x-full')) {
                sidebarOverlay.classList.remove('opacity-100');
                sidebarOverlay.classList.add('opacity-0');
                setTimeout(() => sidebarOverlay.classList.add('hidden'), 300);
              } else {
                sidebarOverlay.classList.remove('hidden');
                // Small delay to allow display:block to apply before animating opacity
                setTimeout(() => {
                  sidebarOverlay.classList.remove('opacity-0');
                  sidebarOverlay.classList.add('opacity-100');
                }, 10);
              }
            } else {
              // Desktop toggle
              sidebar.classList.toggle('lg:translate-x-0');
              mainContent.classList.toggle('lg:ml-64');
            }
          });
        }

        // Close sidebar when clicking overlay
        if (sidebarOverlay) {
          sidebarOverlay.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
            sidebarOverlay.classList.remove('opacity-100');
            sidebarOverlay.classList.add('opacity-0');
            setTimeout(() => sidebarOverlay.classList.add('hidden'), 300);
          });
        }
      });
    </script>