<?php
require("includes/navbar.php");
require("api/connect.php");

if (isset($_POST['insert'])) {
  $labour_name = $_POST['labour_name'];
  $labour_date = $_POST['labour_date'];
  // $hours_worked = $_POST['hours_worked'];
  $salary = $_POST['salary'];

  $sql = "INSERT INTO labour (labour_name, labour_date, salary) VALUES ('$labour_name', '$labour_date', '$salary')";
  $result = $conn->query($sql);

  if (!$result) {
    die("Query failed: " . $conn->error);
  } else {
    header("Location: dashboard?success=record_added");
    exit();
  }
}

$sql = "SELECT * FROM labour";
$result = $conn->query($sql);

if (!$result) {
  die("Query failed: " . $conn->error);
}

?>
<!-- Toast Notification Container -->
<div id="toast-container" class="fixed top-6 right-6 z-[200] space-y-3"></div>

<style>
  @keyframes slideInRight {
    from {
      opacity: 0;
      transform: translateX(100%);
    }

    to {
      opacity: 1;
      transform: translateX(0);
    }
  }

  .toast-slide-in {
    animation: slideInRight 0.3s ease-out forwards;
  }
</style>
<div class="p-8 space-y-10 max-w-7xl mx-auto">
  <!-- Dashboard Header Section -->
  <section class="flex flex-col md:flex-row md:items-end justify-between gap-6">
    <div class="space-y-1">
      <h2 class="text-3xl font-extrabold font-manrope tracking-tight text-primary">Attendance &amp; Payroll</h2>
      <p class="text-on-surface-variant font-medium">Manage labours presence and financial disbursements.</p>
    </div>
  </section>
</div>
<!-- Main Layout Bento Grid -->
<div class="p-8 max-w-7xl mx-auto space-y-8">
  <!-- Attendance Tracking Card -->

  <div class="lg:col-span-8 bg-surface-container-lowest rounded-xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] overflow-hidden">
    <div class="px-6 py-5 flex items-center justify-between border-b border-surface-container">
      <div class="flex items-center gap-3">
        <span class="w-2 h-6 bg-secondary rounded-full"></span>
        <h3 class="font-manrope font-bold text-lg text-primary">Daily Attendance Registry</h3>
      </div>

      <div class="bg-surface-container-low px-4 py-2.5 rounded-lg border-none shadow-sm flex items-center gap-3">
        <span class="material-symbols-outlined text-primary/60" data-icon="calendar_today">calendar_today</span>
        <input id="att_date" name="att_date" class="bg-transparent border-none p-0 text-sm font-semibold text-primary focus:ring-0" type="date" value="<?php echo date('Y-m-d'); ?>" name="ATD_date" />
        <button type="submit" id="submit-attendance" class="bg-secondary text-white text-sm font-bold px-4 py-2 rounded shadow-md hover:bg-secondary/90 transition-colors flex items-center gap-2">
          <span class="material-symbols-outlined text-sm" data-icon="check_circle">check_circle</span>
          Submit Attendance
        </button>
      </div>

    </div>
    <div class="overflow-x-auto">
      <table class="w-full text-left border-collapse">
        <thead>
          <tr class="bg-surface-container-low/50">
            <th class="px-6 py-4 text-[10px] uppercase tracking-widest font-bold text-on-surface-variant">SR_NO</th>
            <th hidden>Date</th>
            <th class="px-6 py-4 text-[10px] uppercase tracking-widest font-bold text-on-surface-variant">Labourer</th>
            <th class="px-6 py-4 text-[10px] uppercase tracking-widest font-bold text-on-surface-variant text-center">Status</th>
            <th class="px-6 py-4 text-[10px] uppercase tracking-widest font-bold text-on-surface-variant text-right">Actions</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-surface-container-low">
          <?php
          $i = 1;
          while ($row = $result->fetch_assoc()) {
            echo "<tr class='hover:bg-surface-container-low/30 transition-colors'>";
            echo "<td class='px-6 py-4 text-sm font-medium text-slate-400'>" . $i++ . "</td>";
            echo "<td hidden>" . $row["labour_date"] . "</td>";
            echo "<td class='px-6 py-4'> <div class='flex items-center gap-3'><div>
         <p class='font-semibold text-primary text-sm'>" . $row["labour_name"] . "</p>
         </div></div></td>";

            echo "<td class='px-6 py-4 text-center'><div class='flex items-center justify-center gap-4'>";
            echo "<label class='inline-flex items-center gap-1 cursor-pointer'><input type='radio' class='attendance-radio' name='attendance_" . $row["labour_id"] . "' data-labour-id='" . $row["labour_id"] . "' value='1'> <span class='text-sm font-medium text-green-600'>Present</span></label>";
            echo "<label class='inline-flex items-center gap-1 cursor-pointer'><input type='radio' class='attendance-radio' name='attendance_" . $row["labour_id"] . "' data-labour-id='" . $row["labour_id"] . "' value='0'> <span class='text-sm font-medium text-red-500'>Absent</span></label>";
            echo "</div></td>";
            echo "<td class='px-6 py-4 text-right'><div class='flex justify-end gap-2'>
     <button id='open-popupss' name='update' labour-id='" . $row["labour_id"] . "' class='p-1.5 text-on-surface-variant hover:text-primary transition-colors'><span class='material-symbols-outlined text-lg' data-icon='edit'>edit</span></button>
     <button id='delete' name='delete' labour-id='" . $row["labour_id"] . "' class='p-1.5 text-on-surface-variant hover:text-error transition-colors'><span class='material-symbols-outlined text-lg' data-icon='delete'>delete</span></button>
     </div>
     </td>";
            echo "</tr>";
          }
          ?>


          <!-- <td class="px-6 py-4 text-center">
<label class="relative inline-flex items-center cursor-pointer">
<input checked="" class="sr-only peer" type="checkbox"/>
<div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-secondary"></div>
</label>
</td> -->

        </tbody>
        <script>
          $(document).ready(function() {
            $('#submit-attendance').click(function() {
              var attendanceData = [];
              var attendanceDate = $('#att_date').val(); // Get the selected date

              // Collect attendance for each checked radio button
              $('.attendance-radio:checked').each(function() {
                var labourId = $(this).data('labour-id');
                var attendanceValue = $(this).val();
                attendanceData.push({
                  labour_id: labourId,
                  attendance: attendanceValue
                });
              });

              if (attendanceData.length === 0) {
                alert('Please mark attendance for at least one labourer.');
                return;
              }

              $.ajax({
                type: 'POST',
                url: 'submit_selected',
                data: {
                  attendance_data: attendanceData,
                  attendance_date: attendanceDate
                },
                success: function(response) {
                  if (response.trim() == 1) {
                    showToast('Attendance recorded successfully for ' + attendanceData.length + ' laborers', 'success');
                    $('.attendance-radio:checked').prop('checked', false);
                  } else {
                    showToast('Error: ' + response, 'error');
                  }
                },
                error: function(xhr, status, error) {
                  showToast('Server connection error', 'error');
                }
              });
            });

            // Check for success query parameter on page load
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('success') === 'record_added') {
              showToast('New labour record added successfully', 'success');
              // Clean up the URL
              window.history.replaceState({}, document.title, window.location.pathname);
            }

            function showToast(message, type) {
              const icons = {
                success: 'check_circle',
                error: 'error',
                warning: 'warning'
              };
              const colors = {
                success: 'bg-green-600',
                error: 'bg-red-600',
                warning: 'bg-amber-500'
              };
              const id = 'toast-' + Date.now();
              const toast = `
                <div id="${id}" class="toast-slide-in ${colors[type] || 'bg-slate-800'} text-white px-5 py-3 rounded-lg shadow-2xl flex items-center gap-3 min-w-[300px] cursor-pointer">
                  <span class="material-symbols-outlined text-lg">${icons[type] || 'info'}</span>
                  <span class="text-sm font-medium flex-1">${message}</span>
                  <span class="material-symbols-outlined text-sm opacity-60 hover:opacity-100 transition-opacity" onclick="this.parentElement.remove()">close</span>
                </div>
              `;
              $('#toast-container').append(toast);
              setTimeout(() => {
                $(`#${id}`).fadeOut(300, function() {
                  $(this).remove();
                });
              }, 4000);
            }
          });
        </script>
      </table>
    </div>
  </div>
</div>
<!-- Page Canvas -->
<div class="p-8 max-w-7xl mx-auto space-y-8">
  <!-- Main Data Table Container -->
  <div class="bg-surface-container-lowest rounded-xl overflow-hidden shadow-sm border border-outline-variant/10">
    <div class="px-6 py-5 flex flex-col md:flex-row justify-between items-center gap-4 bg-white">
      <div>
        <h2 class="text-xl font-bold text-on-surface tracking-tight">Labour Recored</h2>
        <p class="text-sm text-on-surface-variant">Manage Labour data and Salary.</p>
      </div>
      <div class="flex gap-3 w-full md:w-auto">

        <button onclick="document.getElementById('popup-box2').style.display = 'flex'" class="bg-primary text-white font-manrope font-bold py-2.5 px-6 rounded shadow-lg hover:shadow-primary/20 hover:translate-y-[-1px] transition-all flex items-center gap-2">
          <span class="material-symbols-outlined text-lg" data-icon="person_add">person_add</span>
          Add Labour
        </button>
        <!-- <div class="relative flex-1 md:w-64">
          <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-lg"
            data-icon="search">search</span>
          <input
            class="w-full pl-10 pr-4 py-2 bg-surface-container-lowest border-outline-variant/30 rounded-lg text-sm focus:ring-2 focus:ring-secondary/20 focus:border-secondary transition-all"
            placeholder="Search team members..." type="text" />
        </div>

        <button
          class="bg-surface-container-low p-2 rounded-lg text-on-surface hover:bg-surface-container transition-colors">
          <span class="material-symbols-outlined" data-icon="filter_list">filter_list</span>
        </button> -->
      </div>
    </div>
    <div class="overflow-x-auto">
      <table class="w-full text-left border-collapse">
        <thead>
          <tr class="bg-surface-container-low/50">
            <th class="px-6 py-4 text-[11px] font-bold text-on-surface-variant uppercase tracking-widest">Sr_No</th>
            <th class="px-6 py-4 text-[11px] font-bold text-on-surface-variant uppercase tracking-widest">Name</th>
            <!-- <th class="px-6 py-4 text-[11px] font-bold text-on-surface-variant uppercase tracking-widest">Email</th> -->
            <th class="px-6 py-4 text-[11px] font-bold text-on-surface-variant uppercase tracking-widest">Role</th>
            <th class="px-6 py-4 text-[11px] font-bold text-on-surface-variant uppercase tracking-widest">Salary
            </th>
            <th class="px-6 py-4 text-[11px] font-bold text-on-surface-variant uppercase tracking-widest text-right">
              Actions</th>
          </tr>
        </thead>
        <tbody class="divide-y-0" id="labourTableBody">

          <script>
            document.addEventListener("DOMContentLoaded", function() {
              loadLabours();

              function loadLabours() {
                $.ajax({
                  url: "api/fetch_labour",
                  method: "GET",
                  success: function(response) {
                    let data = JSON.parse(response);
                    let html = "";

                    let i = 1;

                    data.forEach(row => {

                      let initials = row.labour_name
                        .split(" ")
                        .map(w => w[0])
                        .join("")
                        .toUpperCase();

                      html += `
              <tr class="hover:bg-surface-container-low/30 transition-colors group">
              
                <td class="px-6 py-5 text-sm font-medium text-outline">${i++}</td>
              
                <td class="px-6 py-5">
                  <div class="flex items-center gap-3">
                    <div
                      class="w-8 h-8 rounded-full bg-primary-container text-[10px] flex items-center justify-center text-white font-bold">
                      ${initials}
                    </div>
                    <span class="text-sm font-semibold text-on-surface">${row.labour_name}</span>
                  </div>
                </td>
              
                <td class="px-6 py-5">
                  <span class="text-[10px] font-bold px-2 py-1 rounded bg-secondary-fixed text-on-secondary-fixed-variant uppercase">
                    Labour
                  </span>
                </td>
              
                <td class="px-6 py-5">
                  <div class="flex items-center gap-1.5 text-xs font-semibold text-green-600">
                    <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                    ${row.salary}
                  </div>
                </td>
              
                <td class="px-6 py-5 text-right">
                  <div class="flex justify-end gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
              
                    <button class="viewBtn p-1.5 hover:bg-surface-container rounded-lg" data-id="${row.labour_id}">
                      👁️
                    </button>
              
                    <button class="editBtn p-1.5 hover:bg-surface-container rounded-lg" data-id="${row.labour_id}">
                      ✏️
                    </button>
              
                    <button class="deleteBtn p-1.5 hover:bg-error-container/20 rounded-lg text-red-600" data-id="${row.labour_id}">
                      🗑️
                    </button>
              
                  </div>
                </td>
              
              </tr>
              `;
                    });

                    $("#labourTableBody").html(html);
                  }
                });
              }
            });
          </script>

        </tbody>
      </table>
    </div>
    <!-- Table Footer -->
    <div class="px-6 py-4 bg-white border-t border-outline-variant/10 flex items-center justify-between">
      <p class="text-xs text-on-surface-variant font-medium">Showing 5 of null results</p>
      <div class="flex gap-2">
        <button
          class="px-3 py-1.5 rounded-lg text-xs font-bold border border-outline-variant/30 text-on-surface-variant hover:bg-surface-container transition-colors disabled:opacity-50"
          disabled="">Previous</button>
        <button
          class="px-3 py-1.5 rounded-lg text-xs font-bold bg-primary text-white hover:opacity-90 transition-opacity">Next</button>
      </div>
    </div>
  </div>
</div>

<div class="absolute inset-0 z-[60] flex items-center justify-center bg-primary/20 backdrop-blur-[2px] " id="popup-box2" style="display:none;">
  <div class="bg-surface-container-lowest w-full max-w-lg rounded-xl shadow-[0_8px_24px_-4px_rgba(9,20,38,0.12)] border border-outline-variant/10 overflow-hidden transform transition-all duration-300">
    <div class="p-8 border-b border-outline-variant/10 flex justify-between items-center bg-surface-container-low/30">
      <div>
        <h2 class="text-2xl font-headline font-extrabold text-primary tracking-tight">Add Labour Record</h2>
        <!-- <p class="text-on-surface-variant text-sm mt-1">Personnel deployment for active project sites.</p> -->
      </div>
      <button class="p-2 hover:bg-surface-container-high rounded-full transition-colors" onclick="document.getElementById('popup-box2').style.display = 'none'">
        <span class="material-symbols-outlined text-on-surface-variant">close</span>
      </button>
    </div>
    <form class="p-8 space-y-6" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
      <!-- Labour Name -->
      <div>
        <label class="block text-xs font-label font-bold uppercase tracking-widest text-on-surface-variant mb-2 ml-1">Labour Name</label>
        <div class="relative group">
          <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline group-focus-within:text-secondary transition-colors">person</span>
          <input id="labour_name" name="labour_name" class="w-full pl-12 pr-4 py-3.5 bg-surface-container-lowest border border-outline-variant/30 rounded-lg focus:ring-2 focus:ring-secondary/20 focus:border-secondary outline-none transition-all placeholder:text-outline/50 font-medium" placeholder="e.g. Arpit,K" type="text" />
        </div>
      </div>
      <div>
        <!-- Joining Date -->
        <div>
          <label class="block text-xs font-label font-bold uppercase tracking-widest text-on-surface-variant mb-2 ml-1">Joining Date</label>
          <div class="relative group">
            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline group-focus-within:text-secondary transition-colors">calendar_today</span>
            <input id="labour_date" name="labour_date" class="w-full pl-12 pr-4 py-3.5 bg-surface-container-lowest border border-outline-variant/30 rounded-lg focus:ring-2 focus:ring-secondary/20 focus:border-secondary outline-none transition-all font-medium text-on-surface" type="date" value="<?php echo date('Y-m-d'); ?>" name="labour_date" class="form-control" />
          </div>
        </div>

      </div>
      <!-- Salary -->
      <div>
        <label class="block text-xs font-label font-bold uppercase tracking-widest text-on-surface-variant mb-2 ml-1">Monthly Salary</label>
        <div class="relative group">
          <span class="absolute left-4 top-1/2 -translate-y-1/2 text-on-surface-variant font-bold text-sm">₹</span>
          <input type="number" id="salary" name="salary" class="w-full pl-8 pr-4 py-3.5 bg-surface-container-lowest border border-outline-variant/30 rounded-lg focus:ring-2 focus:ring-secondary/20 focus:border-secondary outline-none transition-all placeholder:text-outline/50 font-bold text-primary" placeholder="0.00" type="number" />

        </div>
        <div class="pt-4 flex gap-4">
          <button class="flex-1 py-4 px-6 rounded-lg bg-surface-container-low text-primary font-bold hover:bg-surface-container-high transition-colors scale-98-on-click" type="button" onclick="document.getElementById('popup-box2').style.display = 'none'">Cancel</button>
          <button type="submit" name="insert" value="Insert" class="flex-1 py-4 px-6 rounded-lg bg-gradient-to-br from-primary to-primary-container text-on-primary font-bold shadow-lg shadow-primary/20 scale-98-on-click" type="submit">Add Record</button>
        </div>
    </form>
  </div>
</div>
</main>
<button class="fixed bottom-10 right-10 w-16 h-16 bg-gradient-to-br from-primary to-primary-container text-on-primary rounded-xl shadow-2xl flex items-center justify-center hover:scale-105 active:scale-95 transition-all z-40 group " onclick="document.getElementById('popup-box2').style.display = 'flex'">
  <span class="material-symbols-outlined text-2xl" style="font-variation-settings: 'FILL' 1;">add</span>
  <span class="absolute right-full mr-4 bg-primary text-on-primary px-3 py-1.5 rounded-lg text-xs font-bold whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity">Add Labor Record</span>
</button>
</body>

</html>