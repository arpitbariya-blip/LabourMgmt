<?php
include "navbar.php";
?>
<header
  class="sticky top-0 w-full flex justify-between items-center px-6 py-3 bg-slate-50/80 dark:bg-slate-900/80 backdrop-blur-xl z-40 shadow-sm dark:shadow-none">
  <div class="flex items-center gap-4">
    <h2 class="text-xl font-bold tracking-tighter text-slate-900 dark:text-slate-50 font-manrope">User Directory
    </h2>
  </div>
  <div class="flex items-center gap-6">
    <div class="hidden md:flex items-center gap-6 font-manrope text-sm font-semibold tracking-tight">
      <a class="text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-100 transition-colors"
        href="dashboard">Dashboard</a>
      <a class="text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-100 transition-colors"
        href="labour_atds">Labour</a>
      <a class="text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-100 transition-colors"
        href="invoice">Invoice</a>
      <a class="text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-100 transition-colors"
        href="material">Materials</a>
    </div>
    <div class="flex items-center gap-2 pl-6 border-l border-outline-variant/30">
      <button
        class="p-2 rounded-full hover:bg-slate-200/50 dark:hover:bg-slate-800/50 transition-colors active:scale-95 text-slate-700 dark:text-slate-300">
        <span class="material-symbols-outlined" data-icon="notifications">notifications</span>
      </button>
      <button
        class="p-2 rounded-full hover:bg-slate-200/50 dark:hover:bg-slate-800/50 transition-colors active:scale-95 text-slate-700 dark:text-slate-300">
        <span class="material-symbols-outlined" data-icon="settings">settings</span>
      </button>
      <div class="ml-2 ring-2 ring-primary-container/10 p-0.5 rounded-full">
        <img alt="User profile avatar" class="w-8 h-8 rounded-full object-cover"
          data-alt="professional male architect with short hair wearing a navy linen shirt in a bright modern studio setting"
          src="https://lh3.googleusercontent.com/aida-public/AB6AXuDJHQ0S7VvnOe2JQfmu03cnEzH0bWMCMHJxILGPFxTNFIp4rzY_iryexDQRHpIY0P1nUMoRFFJhznmm9vj296AGWDgoXrSSL6sRe_zi-VKtnkKzvY2LmpbRYqoo3MqTyO0sWoHhOBuwJutnksuH7nHloYDdlu3fXACVgsE1OxNh5lfyKtSbYw9Oetm1P2TbQV1KJMA1-w6qw2b3-wbri6Nngm5qYSvty5vxG5yNLhBr6k5FU1oHdO0J9OuRaR3pWSjrupP9Y4sPXpJe" />
      </div>
    </div>
  </div>
</header>