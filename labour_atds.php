<?php
require("includes/navbar.php");
?>

<style>
    body {
        font-family: 'Inter', sans-serif;
    }

    .font-manrope {
        font-family: 'Manrope', sans-serif;
    }

    .material-symbols-outlined {
        font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
    }

    ::-webkit-scrollbar {
        width: 6px;
    }

    ::-webkit-scrollbar-track {
        background: transparent;
    }

    ::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 10px;
    }

    /* Skeleton loading animation */
    @keyframes shimmer {
        0% {
            background-position: -200% 0;
        }

        100% {
            background-position: 200% 0;
        }
    }

    .skeleton {
        background: linear-gradient(90deg, #eff4ff 25%, #dce9ff 50%, #eff4ff 75%);
        background-size: 200% 100%;
        animation: shimmer 1.5s infinite;
        border-radius: 6px;
    }

    /* Fade-in animation */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(12px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .fade-in-up {
        animation: fadeInUp 0.35s ease-out forwards;
    }

    /* Toast animation */
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

<body class="bg-background text-on-background min-h-screen">

    <!-- Toast Notification Container -->
    <div id="toast-container" class="fixed top-6 right-6 z-[200] space-y-3"></div>

    <!-- Main Content Canvas -->
    <main>
        <!-- Content Area -->
        <div class="p-8 max-w-7xl mx-auto">
            <!-- Page Header -->
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10">
                <div>
                    <h2 class="text-4xl font-extrabold text-primary font-manrope tracking-tight leading-tight">Labour
                        Attendance &amp; Payroll</h2>
                    <p class="text-on-surface-variant mt-2 font-medium max-w-2xl">Manage daily presence, calculate
                        precise wage outputs, and track financial distributions for your construction workforce.</p>
                </div>
                <div class="flex flex-wrap gap-2 md:gap-3 md:flex-nowrap">
                    <button
                        class="bg-surface-container-lowest text-secondary px-4 py-2 md:px-5 md:py-2.5 rounded font-semibold text-sm flex items-center gap-2 shadow-sm border border-outline-variant/20 hover:bg-surface-container-low transition-colors whitespace-nowrap">
                        <span class="material-symbols-outlined text-lg" data-icon="download">download</span>
                        Export PDF
                    </button>
                    <button id="btn-open-ot-modal"
                        class="bg-primary text-on-primary px-4 py-2 md:px-6 md:py-2.5 rounded font-semibold text-sm flex items-center gap-2 shadow-lg shadow-primary/20 active:scale-95 transition-transform whitespace-nowrap">
                        <span class="material-symbols-outlined text-lg"
                            data-icon="account_balance_wallet">account_balance_wallet</span>
                        Add OT/Withdrawal
                    </button>
                </div>
            </div>

            <!-- Summary Stats (loaded via AJAX) -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10" id="stats-container">
                <!-- Skeleton loaders -->
                <div class="bg-surface-container-low p-6 rounded-xl border-l-4 border-secondary">
                    <div class="skeleton h-3 w-24 mb-3"></div>
                    <div class="skeleton h-8 w-16 mb-2"></div>
                    <div class="skeleton h-3 w-32"></div>
                </div>
                <div class="bg-surface-container-low p-6 rounded-xl border-l-4 border-primary">
                    <div class="skeleton h-3 w-24 mb-3"></div>
                    <div class="skeleton h-8 w-16 mb-2"></div>
                    <div class="skeleton h-3 w-32"></div>
                </div>
                <div class="bg-surface-container-low p-6 rounded-xl border-l-4 border-tertiary-fixed-dim">
                    <div class="skeleton h-3 w-24 mb-3"></div>
                    <div class="skeleton h-8 w-16 mb-2"></div>
                    <div class="skeleton h-3 w-32"></div>
                </div>
                <div class="bg-slate-900 text-slate-100 p-6 rounded-xl relative overflow-hidden">
                    <div class="skeleton h-3 w-24 mb-3" style="background: linear-gradient(90deg, #334155 25%, #475569 50%, #334155 75%); background-size: 200% 100%;"></div>
                    <div class="skeleton h-8 w-20 mb-2" style="background: linear-gradient(90deg, #334155 25%, #475569 50%, #334155 75%); background-size: 200% 100%;"></div>
                    <div class="skeleton h-3 w-32" style="background: linear-gradient(90deg, #334155 25%, #475569 50%, #334155 75%); background-size: 200% 100%;"></div>
                </div>
            </div>

            <!-- Filters & Controls Section -->
            <div class="bg-surface-container-lowest rounded-xl shadow-sm border border-outline-variant/10 p-6 mb-6">
                <div class="flex flex-col md:flex-row gap-4 items-end">
                    <div class="flex-1 grid grid-cols-1 md:grid-cols-3 gap-4 w-full">
                        <div class="space-y-1.5">
                            <label
                                class="text-xs font-bold text-on-surface-variant uppercase tracking-tighter ml-1">Labour
                                Name</label>
                            <div class="relative">
                                <select name="labourname" required id="labour-select"
                                    class="w-full bg-surface-container-low border-none rounded-lg py-2.5 pl-4 pr-10 text-sm font-medium focus:ring-2 focus:ring-secondary appearance-none">
                                    <option value="">-----Labour Name-----</option>
                                    <!-- Populated via AJAX -->
                                </select>
                                <span
                                    class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">expand_more</span>
                            </div>
                        </div>
                        <div class="space-y-1.5">
                            <label
                                class="text-xs font-bold text-on-surface-variant uppercase tracking-tighter ml-1">Month</label>
                            <div class="relative">
                                <input type="month"
                                    class="w-full bg-surface-container-low border-none rounded-lg py-2.5 pl-4 pr-10 text-sm font-medium focus:ring-2 focus:ring-secondary appearance-none"
                                    id="month-select">
                                <span
                                    class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">calendar_month</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex gap-2 w-full md:w-auto">
                        <button id="btn-apply-filter"
                            class="flex-1 md:flex-none px-6 py-2.5 bg-secondary text-white rounded font-bold text-sm flex items-center justify-center gap-2 transition-transform active:scale-95">
                            <span class="material-symbols-outlined text-lg">filter_alt</span>
                            Apply Filters
                        </button>
                        <button id="btn-reset-filter"
                            class="px-3 py-2.5 bg-slate-100 text-slate-500 rounded hover:bg-slate-200 transition-colors">
                            <span class="material-symbols-outlined">restart_alt</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Salary Status Card -->
            <div id="salary-status-panel" class="mb-6" style="display: none;">
                <div class="bg-surface-container-lowest rounded-xl shadow-sm border border-outline-variant/10 overflow-hidden">
                    <div class="px-6 py-4 flex items-center gap-3 border-b border-slate-50">
                        <span class="material-symbols-outlined text-secondary" data-icon="account_balance_wallet">account_balance_wallet</span>
                        <h3 class="font-bold text-primary font-manrope">Salary Status</h3>
                        <span id="salary-labour-name" class="text-xs font-semibold bg-secondary-fixed text-on-secondary-fixed-variant px-2.5 py-0.5 rounded-full uppercase"></span>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                            <div class="bg-surface-container-low rounded-lg p-4 text-center">
                                <p class="text-[10px] font-bold text-on-surface-variant uppercase tracking-wider mb-1">Daily Rate</p>
                                <p class="text-lg font-black text-primary" id="ss-daily-rate">₹0</p>
                            </div>
                            <div class="bg-surface-container-low rounded-lg p-4 text-center">
                                <p class="text-[10px] font-bold text-on-surface-variant uppercase tracking-wider mb-1">Days Present</p>
                                <p class="text-lg font-black text-secondary" id="ss-days-present">0</p>
                            </div>
                            <div class="bg-surface-container-low rounded-lg p-4 text-center">
                                <p class="text-[10px] font-bold text-on-surface-variant uppercase tracking-wider mb-1">Base Salary</p>
                                <p class="text-lg font-black text-primary" id="ss-base-salary">₹0</p>
                            </div>
                            <div class="bg-surface-container-low rounded-lg p-4 text-center">
                                <p class="text-[10px] font-bold text-on-surface-variant uppercase tracking-wider mb-1">OT Earned</p>
                                <p class="text-lg font-black text-green-600" id="ss-total-ot">₹0</p>
                            </div>
                            <div class="bg-surface-container-low rounded-lg p-4 text-center">
                                <p class="text-[10px] font-bold text-on-surface-variant uppercase tracking-wider mb-1">Withdrawn</p>
                                <p class="text-lg font-black text-error" id="ss-total-withdrawal">₹0</p>
                            </div>
                            <div class="bg-slate-900 rounded-lg p-4 text-center">
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Net Pay</p>
                                <p class="text-lg font-black text-white" id="ss-net-pay">₹0</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Data Table Section -->
            <div class="bg-surface-container-lowest rounded-xl shadow-sm border border-outline-variant/10 overflow-hidden">
                <div class="px-6 py-4 flex items-center justify-between border-b border-slate-50">
                    <h3 class="font-bold text-primary font-manrope">Labour Attendance Log</h3>
                    <div class="flex items-center gap-4">
                        <span class="text-xs font-medium text-on-surface-variant" id="record-count">Select a labour and month to view records</span>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-surface-container-low/50">
                                <th class="px-6 py-4 text-xs font-bold text-on-surface-variant uppercase tracking-widest">
                                    SR_NO</th>
                                <th class="px-6 py-4 text-xs font-bold text-on-surface-variant uppercase tracking-widest">
                                    Date</th>
                                <th class="px-6 py-4 text-xs font-bold text-on-surface-variant uppercase tracking-widest">
                                    Labourer</th>
                                <th class="px-6 py-4 text-xs font-bold text-on-surface-variant uppercase tracking-widest text-center">
                                    Presence</th>
                                <th class="px-6 py-4 text-xs font-bold text-on-surface-variant uppercase tracking-widest">
                                    Base Salary</th>
                                <th class="px-6 py-4 text-xs font-bold text-on-surface-variant uppercase tracking-widest">
                                    OT Salary</th>
                                <th class="px-6 py-4 text-xs font-bold text-on-surface-variant uppercase tracking-widest">
                                    Withdrawal</th>
                                <th class="px-6 py-4 text-xs font-bold text-on-surface-variant uppercase tracking-widest text-right">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody id="attendance-tbody" class="divide-y divide-slate-50">
                            <!-- Empty state -->
                            <tr id="empty-state">
                                <td colspan="8" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center gap-3">
                                        <div class="w-16 h-16 rounded-full bg-surface-container-low flex items-center justify-center">
                                            <span class="material-symbols-outlined text-3xl text-on-surface-variant opacity-40"
                                                data-icon="event_note">event_note</span>
                                        </div>
                                        <p class="font-semibold text-primary">No Records Loaded</p>
                                        <p class="text-sm text-on-surface-variant max-w-sm">Select a labourer and month from the filters above, then click "Apply Filters" to load attendance data.</p>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- Pagination Footer -->
                <div class="px-6 py-4 flex items-center justify-between bg-surface-container-low/30">
                    <div class="flex items-center gap-2" id="pagination-info">
                        <p class="text-xs text-on-surface-variant font-medium italic">Select filters to load data</p>
                    </div>
                    <div class="hidden sm:block">
                        <p class="text-xs text-on-surface-variant font-medium italic" id="sync-time">
                            Ready
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- OT/Withdrawal Modal -->
    <div id="ot-modal"
        class="fixed inset-0 bg-primary/40 backdrop-blur-sm z-[100] flex items-center justify-center p-4 transition-opacity duration-300"
        style="display: none;">
        <div
            class="bg-surface-container-lowest w-full max-w-lg rounded-xl shadow-2xl overflow-hidden transform transition-all duration-300 fade-in-up">
            <div class="p-6 border-b border-slate-100 flex justify-between items-center">
                <h4 class="text-xl font-bold font-manrope text-primary">Process Withdrawal/OT</h4>
                <button class="text-slate-400 hover:text-slate-900 transition-colors" id="btn-close-ot-modal">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            <div class="p-6 space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-1.5">
                        <label class="text-xs font-bold text-on-surface-variant uppercase tracking-tighter">Labour
                            Name</label>
                        <select id="ot-labour-select"
                            class="w-full bg-slate-100 border-none rounded-lg py-2.5 px-4 text-sm focus:ring-2 focus:ring-secondary">
                            <!-- Populated via AJAX -->
                        </select>
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-xs font-bold text-on-surface-variant uppercase tracking-tighter">Transaction
                            Type</label>
                        <select id="ot-type-select"
                            class="w-full bg-slate-100 border-none rounded-lg py-2.5 px-4 text-sm focus:ring-2 focus:ring-secondary">
                            <option value="OT">Overtime (OT)</option>
                            <option value="withdrawal">Withdrawal/Advance</option>
                        </select>
                    </div>
                </div>
                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-on-surface-variant uppercase tracking-tighter">Amount
                        (₹)</label>
                    <input id="ot-amount"
                        class="w-full bg-slate-100 border-none rounded-lg py-2.5 px-4 text-sm focus:ring-2 focus:ring-secondary"
                        placeholder="Enter amount" type="number" />
                </div>
                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-on-surface-variant uppercase tracking-tighter">Date</label>
                    <input id="ot-date" type="date"
                        class="w-full bg-slate-100 border-none rounded-lg py-2.5 px-4 text-sm focus:ring-2 focus:ring-secondary">
                </div>
            </div>
            <div class="p-6 bg-slate-50 flex gap-3 justify-end">
                <button id="btn-cancel-ot"
                    class="px-6 py-2 rounded text-slate-500 font-semibold text-sm hover:bg-slate-200 transition-colors">Cancel</button>
                <button id="btn-save-ot"
                    class="px-8 py-2 bg-primary text-white rounded font-bold text-sm shadow-lg shadow-primary/20 active:scale-95 transition-transform flex items-center gap-2">
                    <span class="material-symbols-outlined text-sm" id="ot-save-icon">save</span>
                    Save
                </button>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="delete-modal"
        class="fixed inset-0 bg-primary/40 backdrop-blur-sm z-[100] flex items-center justify-center p-4"
        style="display: none;">
        <div class="bg-surface-container-lowest w-full max-w-sm rounded-xl shadow-2xl overflow-hidden fade-in-up">
            <div class="p-6 text-center space-y-4">
                <div class="w-14 h-14 rounded-full bg-error-container mx-auto flex items-center justify-center">
                    <span class="material-symbols-outlined text-error text-2xl" data-icon="delete_forever">delete_forever</span>
                </div>
                <h4 class="text-lg font-bold text-primary font-manrope">Delete Attendance Record?</h4>
                <p class="text-sm text-on-surface-variant">This action cannot be undone. The attendance record for <strong id="delete-desc"></strong> will be permanently removed.</p>
            </div>
            <div class="p-4 bg-slate-50 flex gap-3 justify-center">
                <button id="btn-cancel-delete"
                    class="px-6 py-2 rounded text-slate-500 font-semibold text-sm hover:bg-slate-200 transition-colors">Cancel</button>
                <button id="btn-confirm-delete"
                    class="px-6 py-2 bg-error text-white rounded font-bold text-sm shadow-lg active:scale-95 transition-transform flex items-center gap-2">
                    <span class="material-symbols-outlined text-sm">delete</span>
                    Delete
                </button>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // ─── State ───
            let labourList = [];
            let pendingDelete = {
                labour_id: null,
                date: null
            };

            // ─── Initialize ───
            loadLabourDropdowns();
            setDefaultDate();

            // ─── Load Labour Dropdowns via AJAX ───
            function loadLabourDropdowns() {
                $.ajax({
                    url: 'api/fetch_labour',
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        labourList = data;
                        let filterOptions = '<option value="">-----Labour Name-----</option>';
                        let modalOptions = '';

                        data.forEach(function(labour) {
                            filterOptions += `<option value="${labour.labour_id}">${labour.labour_name}</option>`;
                            modalOptions += `<option value="${labour.labour_id}">${labour.labour_name}</option>`;
                        });

                        $('#labour-select').html(filterOptions);
                        $('#ot-labour-select').html(modalOptions);

                        // Load stats after labours loaded
                        loadStats();
                    },
                    error: function() {
                        showToast('Failed to load labour list', 'error');
                    }
                });
            }

            // ─── Set Default Date ───
            function setDefaultDate() {
                let today = new Date().toISOString().split('T')[0];
                $('#ot-date').val(today);
            }

            // ─── Load Summary Stats ───
            function loadStats() {
                let totalLabourers = labourList.length;
                let statsHtml = `
                    <div class="bg-surface-container-low p-6 rounded-xl border-l-4 border-secondary fade-in-up">
                        <p class="text-on-surface-variant font-medium uppercase tracking-wider text-xs">Active Laborers</p>
                        <p class="text-3xl font-black text-primary mt-1">${totalLabourers}</p>
                        <div class="flex items-center gap-1 text-slate-500 mt-2 text-sm">
                            <span class="material-symbols-outlined text-sm" data-icon="groups">groups</span>
                            <span>Registered workers</span>
                        </div>
                    </div>
                    <div class="bg-surface-container-low p-6 rounded-xl border-l-4 border-primary fade-in-up" style="animation-delay: 0.05s;">
                        <p class="text-on-surface-variant font-medium uppercase tracking-wider text-xs">Filter Status</p>
                        <p class="text-3xl font-black text-primary mt-1" id="stat-records">--</p>
                        <div class="flex items-center gap-1 text-slate-500 mt-2 text-sm">
                            <span>Records loaded</span>
                        </div>
                    </div>
                    <div class="bg-surface-container-low p-6 rounded-xl border-l-4 border-tertiary-fixed-dim fade-in-up" style="animation-delay: 0.1s;">
                        <p class="text-on-surface-variant font-medium uppercase tracking-wider text-xs">Total Earnings</p>
                        <p class="text-3xl font-black text-primary mt-1" id="stat-earnings">₹0</p>
                        <div class="flex items-center gap-1 text-on-tertiary-fixed-variant mt-2 text-sm font-semibold">
                            <span class="material-symbols-outlined text-sm" data-icon="payments">payments</span>
                            <span>Selected period</span>
                        </div>
                    </div>
                    <div class="bg-slate-900 text-slate-100 p-6 rounded-xl relative overflow-hidden fade-in-up" style="animation-delay: 0.15s;">
                        <div class="relative z-10">
                            <p class="text-slate-400 font-medium uppercase tracking-wider text-xs">Total Withdrawal</p>
                            <p class="text-3xl font-black text-white mt-1" id="stat-withdrawal">₹0</p>
                            <p class="text-slate-400 mt-2 text-sm">Selected period</p>
                        </div>
                        <div class="absolute -right-4 -bottom-4 opacity-10">
                            <span class="material-symbols-outlined text-8xl" data-icon="payments">payments</span>
                        </div>
                    </div>
                `;
                $('#stats-container').html(statsHtml);
            }

            // ─── Load Attendance Table via AJAX ───
            function loadAttendanceTable() {
                let labourId = $('#labour-select').val();
                let month = $('#month-select').val();

                if (!labourId || !month) {
                    showToast('Please select both a labourer and a month', 'warning');
                    return;
                }

                // Show loading skeleton
                let skeletonRows = '';
                for (let i = 0; i < 5; i++) {
                    skeletonRows += `<tr>
                        <td class="px-6 py-5"><div class="skeleton h-4 w-8"></div></td>
                        <td class="px-6 py-5"><div class="skeleton h-4 w-24"></div></td>
                        <td class="px-6 py-5"><div class="skeleton h-4 w-32"></div></td>
                        <td class="px-6 py-5"><div class="skeleton h-4 w-16 mx-auto"></div></td>
                        <td class="px-6 py-5"><div class="skeleton h-4 w-20"></div></td>
                        <td class="px-6 py-5"><div class="skeleton h-4 w-16"></div></td>
                        <td class="px-6 py-5"><div class="skeleton h-4 w-16"></div></td>
                        <td class="px-6 py-5"><div class="skeleton h-4 w-12 ml-auto"></div></td>
                    </tr>`;
                }
                $('#attendance-tbody').html(skeletonRows);
                $('#record-count').text('Loading...');

                $.ajax({
                    url: 'api/Loadtable',
                    type: 'POST',
                    data: {
                        FID: labourId,
                        Sel: month
                    },
                    success: function(data) {
                        if (data.trim() === '') {
                            $('#attendance-tbody').html(`
                                <tr>
                                    <td colspan="8" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center gap-3 fade-in-up">
                                            <div class="w-16 h-16 rounded-full bg-surface-container-low flex items-center justify-center">
                                                <span class="material-symbols-outlined text-3xl text-on-surface-variant opacity-40" data-icon="search_off">search_off</span>
                                            </div>
                                            <p class="font-semibold text-primary">No Records Found</p>
                                            <p class="text-sm text-on-surface-variant max-w-sm">No attendance data exists for this labourer in the selected month.</p>
                                        </div>
                                    </td>
                                </tr>
                            `);
                            $('#record-count').text('0 records found');
                            $('#stat-records').text('0');
                            $('#stat-earnings').text('₹0');
                            $('#stat-withdrawal').text('₹0');
                        } else {
                            // Wrap received HTML rows and add fade-in
                            $('#attendance-tbody').html(data);

                            // Add fade-in animation to each row
                            $('#attendance-tbody tr').each(function(index) {
                                $(this).addClass('fade-in-up').css('animation-delay', (index * 0.03) + 's');
                            });

                            // Count rows (exclude total row)
                            let rowCount = $('#attendance-tbody tr').length;
                            $('#record-count').text(rowCount + ' records loaded');
                            $('#stat-records').text(rowCount);

                            // Parse totals from the last row
                            updateStatsFromTable();
                        }

                        // Load salary status
                        loadSalaryStatus();

                        // Update sync time
                        let now = new Date();
                        let timeStr = now.toLocaleTimeString('en-IN', {
                            hour: '2-digit',
                            minute: '2-digit'
                        });
                        $('#sync-time').text('Last synced: ' + timeStr);
                    },
                    error: function() {
                        showToast('Failed to load attendance data', 'error');
                        $('#attendance-tbody').html(`
                            <tr>
                                <td colspan="8" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center gap-3">
                                        <div class="w-16 h-16 rounded-full bg-error-container flex items-center justify-center">
                                            <span class="material-symbols-outlined text-3xl text-error" data-icon="error">error</span>
                                        </div>
                                        <p class="font-semibold text-error">Failed to Load Data</p>
                                        <p class="text-sm text-on-surface-variant">Please check your connection and try again.</p>
                                    </div>
                                </td>
                            </tr>
                        `);
                    }
                });
            }

            // ─── Parse stats from loaded table ───
            function updateStatsFromTable() {
                let lastRow = $('#attendance-tbody tr:last');
                let cells = lastRow.find('td');

                // Try to parse earnings and withdrawal from the total row
                if (cells.length >= 7) {
                    let earningsText = cells.eq(4).text().replace(/[^\d.]/g, '');
                    let withdrawalText = cells.eq(6).text().replace(/[^\d.]/g, '');

                    if (earningsText) {
                        $('#stat-earnings').text('₹' + Number(earningsText).toLocaleString('en-IN'));
                    }
                    if (withdrawalText) {
                        $('#stat-withdrawal').text('₹' + Number(withdrawalText).toLocaleString('en-IN'));
                    }
                }
            }

            // ─── Load Salary Status Panel ───
            function loadSalaryStatus() {
                let labourId = $('#labour-select').val();
                let month = $('#month-select').val();

                if (!labourId || !month) {
                    $('#salary-status-panel').slideUp(200);
                    return;
                }

                $.ajax({
                    url: 'api/fetch_salary_status',
                    type: 'POST',
                    data: { labour_id: labourId, month: month },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            let d = response.data;
                            let fmt = (v) => '₹' + Number(v).toLocaleString('en-IN');

                            $('#salary-labour-name').text(d.labour_name);
                            $('#ss-daily-rate').text(fmt(d.daily_rate));
                            $('#ss-days-present').text(d.days_present + '/' + d.total_days);
                            $('#ss-base-salary').text(fmt(d.base_salary));
                            $('#ss-total-ot').text(fmt(d.total_ot));
                            $('#ss-total-withdrawal').text(fmt(d.total_withdrawal));
                            $('#ss-net-pay').text(fmt(d.net_pay));

                            $('#salary-status-panel').slideDown(300).find('.rounded-lg').addClass('fade-in-up');
                        }
                    }
                });
            }

            // ─── Apply Filters Button ───
            $('#btn-apply-filter').on('click', function() {
                loadAttendanceTable();
            });

            // Also trigger on Enter key in month input
            $('#month-select').on('change', function() {
                if ($('#labour-select').val()) {
                    loadAttendanceTable();
                }
            });

            // ─── Reset Filters ───
            $('#btn-reset-filter').on('click', function() {
                $('#labour-select').val('');
                $('#month-select').val('');
                $('#attendance-tbody').html(`
                    <tr id="empty-state">
                        <td colspan="8" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center gap-3 fade-in-up">
                                <div class="w-16 h-16 rounded-full bg-surface-container-low flex items-center justify-center">
                                    <span class="material-symbols-outlined text-3xl text-on-surface-variant opacity-40" data-icon="event_note">event_note</span>
                                </div>
                                <p class="font-semibold text-primary">No Records Loaded</p>
                                <p class="text-sm text-on-surface-variant max-w-sm">Select a labourer and month from the filters above, then click "Apply Filters" to load attendance data.</p>
                            </div>
                        </td>
                    </tr>
                `);
                $('#record-count').text('Select a labour and month to view records');
                $('#stat-records').text('--');
                $('#stat-earnings').text('₹0');
                $('#stat-withdrawal').text('₹0');
                $('#salary-status-panel').slideUp(200);
                showToast('Filters cleared', 'info');
            });

            // ─── OT/Withdrawal Modal Controls ───
            $('#btn-open-ot-modal').on('click', function() {
                setDefaultDate();
                $('#ot-amount').val('');
                $('#ot-modal').fadeIn(200);
            });

            $('#btn-close-ot-modal, #btn-cancel-ot').on('click', function() {
                $('#ot-modal').fadeOut(200);
            });

            // Close modal on backdrop click
            $('#ot-modal').on('click', function(e) {
                if (e.target === this) {
                    $(this).fadeOut(200);
                }
            });

            // ─── Save OT/Withdrawal ───
            $('#btn-save-ot').on('click', function() {
                let labourId = $('#ot-labour-select').val();
                let type = $('#ot-type-select').val();
                let amount = $('#ot-amount').val();
                let date = $('#ot-date').val();

                if (!labourId || !amount || !date) {
                    showToast('Please fill all fields', 'warning');
                    return;
                }

                if (parseFloat(amount) <= 0) {
                    showToast('Amount must be greater than 0', 'warning');
                    return;
                }

                // Show loading state on button
                let $btn = $('#btn-save-ot');
                let originalText = $btn.html();
                $btn.prop('disabled', true).html('<span class="material-symbols-outlined text-sm animate-spin">progress_activity</span> Saving...');

                $.ajax({
                    url: 'api/save_ot_withdrawal',
                    type: 'POST',
                    data: {
                        labour_id: labourId,
                        type: type,
                        amount: amount,
                        date: date
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            showToast(response.message, 'success');
                            $('#ot-modal').fadeOut(200);
                            $('#ot-amount').val('');

                            // Refresh table if filters are active
                            if ($('#labour-select').val() && $('#month-select').val()) {
                                loadAttendanceTable();
                            }
                        } else {
                            showToast(response.message, 'error');
                        }
                    },
                    error: function() {
                        showToast('Server error. Please try again.', 'error');
                    },
                    complete: function() {
                        $btn.prop('disabled', false).html(originalText);
                    }
                });
            });

            // ─── Delete Attendance Record ───
            // Delegated event for dynamically loaded delete buttons
            $(document).on('click', '.btn-delete-attendance', function(e) {
                e.preventDefault();
                let labourId = $(this).data('labour-id');
                let date = $(this).data('date');
                let name = $(this).data('name') || 'this record';

                pendingDelete.labour_id = labourId;
                pendingDelete.date = date;
                $('#delete-desc').text(name + ' on ' + date);
                $('#delete-modal').fadeIn(200);
            });

            $('#btn-cancel-delete').on('click', function() {
                $('#delete-modal').fadeOut(200);
            });

            $('#delete-modal').on('click', function(e) {
                if (e.target === this) {
                    $(this).fadeOut(200);
                }
            });

            $('#btn-confirm-delete').on('click', function() {
                if (!pendingDelete.labour_id || !pendingDelete.date) return;

                let $btn = $(this);
                let originalText = $btn.html();
                $btn.prop('disabled', true).html('<span class="material-symbols-outlined text-sm animate-spin">progress_activity</span> Deleting...');

                $.ajax({
                    url: 'api/delete_attendance',
                    type: 'POST',
                    data: {
                        labour_id: pendingDelete.labour_id,
                        date: pendingDelete.date
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            showToast('Record deleted successfully', 'success');
                            $('#delete-modal').fadeOut(200);

                            // Refresh the table
                            if ($('#labour-select').val() && $('#month-select').val()) {
                                loadAttendanceTable();
                            }
                        } else {
                            showToast(response.message, 'error');
                        }
                    },
                    error: function() {
                        showToast('Server error. Please try again.', 'error');
                    },
                    complete: function() {
                        $btn.prop('disabled', false).html(originalText);
                    }
                });
            });

            // ─── Toast Notification System ───
            function showToast(message, type) {
                let icons = {
                    success: 'check_circle',
                    error: 'error',
                    warning: 'warning',
                    info: 'info'
                };
                let colors = {
                    success: 'bg-green-600',
                    error: 'bg-red-600',
                    warning: 'bg-amber-500',
                    info: 'bg-blue-600'
                };

                let id = 'toast-' + Date.now();
                let toast = `
                    <div id="${id}" class="toast-slide-in ${colors[type] || colors.info} text-white px-5 py-3 rounded-lg shadow-2xl flex items-center gap-3 min-w-[300px] cursor-pointer">
                        <span class="material-symbols-outlined text-lg" data-icon="${icons[type] || icons.info}">${icons[type] || icons.info}</span>
                        <span class="text-sm font-medium flex-1">${message}</span>
                        <span class="material-symbols-outlined text-sm opacity-60 hover:opacity-100 transition-opacity" data-icon="close">close</span>
                    </div>
                `;

                $('#toast-container').append(toast);

                // Auto remove after 4 seconds
                setTimeout(function() {
                    $('#' + id).fadeOut(300, function() {
                        $(this).remove();
                    });
                }, 4000);

                // Click to dismiss
                $('#' + id).on('click', function() {
                    $(this).fadeOut(300, function() {
                        $(this).remove();
                    });
                });
            }
        });
    </script>

</body>

</html>