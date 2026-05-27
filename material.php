<?php
include('api/connect.php');
include('includes/navbar.php');

$sql = "SELECT * FROM material";
$result = $conn->query($sql);

if (!$result) {
die("Query failed: ". $conn->error);
}
?>

<body class="bg-surface text-on-surface min-h-screen selection:bg-secondary-fixed selection:text-on-secondary-fixed">
  
  
   
    <!-- Canvas Content -->
    <div class="p-10 flex-1 space-y-10">
      <!-- Page Header -->
      <section class="flex justify-between items-end">
        <div class="space-y-1">
          <p class="text-secondary font-bold text-xs uppercase tracking-[0.2em]">Inventory Hub</p>
          <h2 class="text-4xl font-extrabold tracking-tight text-on-surface">Materials Management</h2>
          <p class="text-on-surface-variant max-w-lg">Track, manage, and optimize your construction resources across
            active architectural projects.</p>
        </div>
        <button onclick="document.getElementById('popup-box').style.display = 'flex'"
          class="group flex items-center gap-2 bg-gradient-to-br from-primary to-primary-container text-white px-6 py-3.5 rounded-lg font-bold shadow-xl hover:shadow-primary/20 transition-all active:scale-95">
          <span class="material-symbols-outlined" data-icon="add">add</span>
          Add Material
        </button>
      </section>
      <!-- Stats Overview (Atmospheric Layering) -->
      <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-surface-container-low p-6 rounded-xl space-y-3">
          <span class="text-secondary material-symbols-outlined text-3xl" data-icon="category">category</span>
          <div>
            <p class="text-on-surface-variant text-xs font-bold uppercase tracking-wider">Total Categories</p>
            <p class="text-3xl font-black text-on-surface">14</p>
          </div>
        </div>
        <div class="bg-surface-container-low p-6 rounded-xl space-y-3">
          <span class="text-on-tertiary-container material-symbols-outlined text-3xl" data-icon="warning">warning</span>
          <div>
            <p class="text-on-surface-variant text-xs font-bold uppercase tracking-wider">Low Stock Items</p>
            <p class="text-3xl font-black text-on-surface">03</p>
          </div>
        </div>
        <div class="bg-surface-container-low p-6 rounded-xl space-y-3">
          <span class="text-secondary material-symbols-outlined text-3xl" data-icon="payments">payments</span>
          <div>
            <p class="text-on-surface-variant text-xs font-bold uppercase tracking-wider">Inventory Value</p>
            <p class="text-3xl font-black text-on-surface">$142,500</p>
          </div>
        </div>
        <div class="bg-surface-container-low p-6 rounded-xl space-y-3">
          <span class="text-secondary material-symbols-outlined text-3xl" data-icon="history">history</span>
          <div>
            <p class="text-on-surface-variant text-xs font-bold uppercase tracking-wider">Recent Orders</p>
            <p class="text-3xl font-black text-on-surface">28</p>
          </div>
        </div>
      </div>
      <!-- Materials Table (Enterprise Grade) -->
      <div class="bg-surface-container-lowest rounded-xl shadow-sm overflow-hidden">
        <div
          class="px-6 py-4 border-b border-outline-variant/10 flex justify-between items-center bg-surface-container-lowest">
          <div class="flex items-center gap-4">
            <span class="font-headline font-bold text-on-surface">Active Inventory</span>
            <div
              class="flex items-center gap-2 bg-surface-container-low px-3 py-1 rounded-full text-[10px] font-bold text-on-surface-variant uppercase">
              <span class="w-1.5 h-1.5 bg-secondary rounded-full"></span>
              Live Sync
            </div>
          </div>
          <div class="flex items-center gap-2">
            <button class="p-2 hover:bg-surface-container text-on-surface-variant rounded transition-colors">
              <span class="material-symbols-outlined text-sm" data-icon="filter_list">filter_list</span>
            </button>
            <button class="p-2 hover:bg-surface-container text-on-surface-variant rounded transition-colors">
              <span class="material-symbols-outlined text-sm" data-icon="download">download</span>
            </button>
          </div>
        </div>
        <table class="w-full text-left border-collapse">
          <thead class="bg-surface-container-low/50">
            <tr>
              <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-on-surface-variant">Material ID
              </th>
              <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-on-surface-variant">Name</th>
              <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-on-surface-variant">Quantity
              </th>
              <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-on-surface-variant">Price
                (Unit)</th>
              <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-on-surface-variant text-right">
                Actions</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-outline-variant/5">
            <?php
                       $i = 1;
                      while($row = $result->fetch_assoc()) {
                        echo "<tr class='group hover:bg-surface-container-low/30 transition-colors'>";
                        echo "<td class='px-6 py-5'>
                          <span class='font-mono text-xs font-medium text-on-surface-variant'>". $i++. "</span>
                        </td>";
                        echo "<td class='px-6 py-5'>
                          <div class='flex items-center gap-3'>
                            <div class='w-10 h-10 rounded-lg bg-surface-container flex items-center justify-center text-secondary'>
                              <span class='material-symbols-outlined' data-icon='grid_view'>grid_view</span>
                            </div>
                            <span class='font-headline font-semibold text-on-surface'>". $row["Material_name"]. "</span>
                          </div>
                        </td>";
                        echo "<td class='px-6 py-5'>
                          <div class='flex items-center gap-2'>
                            <span class='font-bold text-on-surface'>". $row["Material_quantity"]."</span>
                            <span class='text-[10px] text-on-surface-variant'>Qty</span>
                          </div>
                        </td>";
                        echo "<td class='px-6 py-5 font-medium text-on-surface'>" . $row["Material_cost"]. "</td>";
                        echo "<td class='px-6 py-5 text-right'>
                          <div class='flex justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity'>
                            <button class='p-2 text-secondary hover:bg-secondary/10 rounded-lg transition-colors'>
                              <span class='material-symbols-outlined' data-icon='edit'>edit</span>
                            </button>
                            <button class='p-2 text-error hover:bg-error/10 rounded-lg transition-colors'>
                              <span class='material-symbols-outlined' data-icon='delete'>delete</span>
                            </button>
                          </div>
                        </td>
                        </tr>";
                      }
                     ?>






            <!-- <tr class="group hover:bg-surface-container-low/30 transition-colors">
              <td class="px-6 py-5">
                <span class="font-mono text-xs font-medium text-on-surface-variant">#MAT-2210</span>
              </td>
              <td class="px-6 py-5">
                <div class="flex items-center gap-3">
                  <div
                    class="w-10 h-10 rounded-lg bg-surface-container flex items-center justify-center text-secondary">
                    <span class="material-symbols-outlined" data-icon="straighten">straighten</span>
                  </div>
                  <span class="font-headline font-semibold text-on-surface">Structural Grade Steel Beams</span>
                </div>
              </td>
              <td class="px-6 py-5">
                <div class="flex items-center gap-2">
                  <span class="font-bold text-error">12</span>
                  <span class="text-[10px] text-on-surface-variant">UNITS</span>
                  <span class="bg-error/10 text-error text-[8px] px-1.5 py-0.5 rounded font-black">LOW</span>
                </div>
              </td>
              <td class="px-6 py-5 font-medium text-on-surface">$1,450.00</td>
              <td class="px-6 py-5 text-right">
                <div class="flex justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                  <button class="p-2 text-secondary hover:bg-secondary/10 rounded-lg transition-colors">
                    <span class="material-symbols-outlined" data-icon="edit">edit</span>
                  </button>
                  <button class="p-2 text-error hover:bg-error/10 rounded-lg transition-colors">
                    <span class="material-symbols-outlined" data-icon="delete">delete</span>
                  </button>
                </div>
              </td>
            </tr>
            <tr class="group hover:bg-surface-container-low/30 transition-colors">
              <td class="px-6 py-5">
                <span class="font-mono text-xs font-medium text-on-surface-variant">#MAT-1104</span>
              </td>
              <td class="px-6 py-5">
                <div class="flex items-center gap-3">
                  <div
                    class="w-10 h-10 rounded-lg bg-surface-container flex items-center justify-center text-secondary">
                    <span class="material-symbols-outlined" data-icon="opacity">opacity</span>
                  </div>
                  <span class="font-headline font-semibold text-on-surface">Ultra-Clear Low Iron Glass</span>
                </div>
              </td>
              <td class="px-6 py-5">
                <div class="flex items-center gap-2">
                  <span class="font-bold text-on-surface">450</span>
                  <span class="text-[10px] text-on-surface-variant">PANELS</span>
                </div>
              </td>
              <td class="px-6 py-5 font-medium text-on-surface">$420.00</td>
              <td class="px-6 py-5 text-right">
                <div class="flex justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                  <button class="p-2 text-secondary hover:bg-secondary/10 rounded-lg transition-colors">
                    <span class="material-symbols-outlined" data-icon="edit">edit</span>
                  </button>
                  <button class="p-2 text-error hover:bg-error/10 rounded-lg transition-colors">
                    <span class="material-symbols-outlined" data-icon="delete">delete</span>
                  </button>
                </div>
              </td>
            </tr> -->
          </tbody>
        </table>
        <div
          class="px-6 py-4 bg-surface-container-low/30 border-t border-outline-variant/10 flex justify-between items-center">
          <p class="text-[11px] font-medium text-on-surface-variant">Showing 3 of 14 materials</p>
          <div class="flex gap-2">
            <button
              class="px-3 py-1.5 border border-outline-variant/20 rounded text-xs font-bold text-on-surface hover:bg-surface-container transition-colors disabled:opacity-30"
              disabled="">Previous</button>
            <button
              class="px-3 py-1.5 border border-outline-variant/20 rounded text-xs font-bold text-on-surface hover:bg-surface-container transition-colors">Next</button>
          </div>
        </div>
      </div>
    </div>
  </main>
  <!-- Modal Overlay (Add Material) - Positioned Fixed -->
  <!-- Note: Hidden by default in production, but displayed here for design representation as requested -->
  <div class="fixed inset-0 z-[100] flex items-center justify-center bg-primary/40 backdrop-blur-sm px-4"
    id="popup-box" style="display:none;">
    <div
      class="bg-surface-container-lowest w-full max-w-lg rounded-xl shadow-2xl ring-1 ring-on-surface/5 overflow-hidden">
      <div class="px-8 py-6 border-b border-outline-variant/10 flex justify-between items-center">
        <h3 class="text-xl font-bold font-headline text-on-surface">Add New Material</h3>
        <button class="p-1 hover:bg-surface-container rounded-full transition-colors text-on-surface-variant " onclick="document.getElementById('popup-box').style.display = 'none'">
          <span class="material-symbols-outlined" data-icon="close">close</span>
        </button>
      </div>
      <div class="p-8 space-y-6">
        <!-- Name Field -->
        <div class="space-y-2">
          <label class="text-[10px] font-black uppercase tracking-[0.1em] text-on-surface-variant ml-1">Material
            Name</label>
          <div class="relative">
            <input
              class="w-full bg-surface-container-low border-none rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-secondary/40 transition-all outline-none placeholder:text-outline-variant"
              placeholder="e.g. Premium White Oak" type="text" />
          </div>
        </div>
        <div class="grid grid-cols-2 gap-4">
          <!-- Quantity Field -->
          <div class="space-y-2">
            <label class="text-[10px] font-black uppercase tracking-[0.1em] text-on-surface-variant ml-1">Total
              Quantity</label>
            <input
              class="w-full bg-surface-container-low border-none rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-secondary/40 transition-all outline-none"
              placeholder="0" type="number" />
          </div>
          <!-- Price Field -->
          <div class="space-y-2">
            <label class="text-[10px] font-black uppercase tracking-[0.1em] text-on-surface-variant ml-1">Price per Unit
              ($)</label>
            <input
              class="w-full bg-surface-container-low border-none rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-secondary/40 transition-all outline-none"
              placeholder="0.00" type="text" />
          </div>
        </div>
        <div class="space-y-2 pt-2">
          <label class="text-[10px] font-black uppercase tracking-[0.1em] text-on-surface-variant ml-1">Category &amp;
            Project</label>
          <select
            class="w-full bg-surface-container-low border-none rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-secondary/40 transition-all outline-none text-on-surface-variant">
            <option>Flooring &amp; Finishes</option>
            <option>Structural Materials</option>
            <option>Glass &amp; Glazing</option>
            <option>Electrical Systems</option>
          </select>
        </div>
      </div>
      <div class="px-8 py-6 bg-surface-container-low flex justify-end gap-3">
        <button
          class="px-6 py-3 rounded-lg text-sm font-bold text-on-surface-variant hover:bg-surface-container-high transition-colors" onclick="document.getElementById('popup-box').style.display = 'none'">
          Cancel
        </button>
        <button
          class="bg-gradient-to-br from-primary to-primary-container text-white px-8 py-3 rounded-lg font-bold shadow-lg hover:brightness-110 active:scale-95 transition-all">
          Save Material
        </button>
      </div>
    </div>
  </div>
</body>

</html>