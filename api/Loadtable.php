<?php
require_once __DIR__ . '/connect.php';

$f = $_POST['FID'];
$date = $_POST['Sel'];

// Prepare the SQL query
$stmt = $conn->prepare("SELECT l.labour_name,la.labour_id,la.Present_date,la.attendance,la.OT,la.withdrawal,
  SUM(la.attendance) AS totalATT, 
  SUM(l.salary * la.attendance) AS salary_of_date, 
  SUM(la.OT) AS total_OT, 
  SUM(la.withdrawal) AS total_withdrawal, 
  SUM(l.salary * la.attendance) + SUM(la.OT) - SUM(la.withdrawal) AS total_earnings FROM  labour l 
  INNER JOIN labour_attedance la ON l.labour_id = la.labour_id 
WHERE 
  l.labour_id = ? AND DATE_FORMAT(la.Present_date, '%Y-%m') = ? 
GROUP BY 
  l.labour_name, la.Present_date 
WITH ROLLUP;");

$stmt->bind_param("is", $f, $date);

$stmt->execute();

$result = $stmt->get_result();

$output = "";
$i = 1;

while ($row = $result->fetch_assoc()) {
    if (!is_null($row['Present_date'])) {
        if (($row['attendance']) == 1) {
            $output .= "  <tr class='hover:bg-surface-container-low transition-colors group'>
        <td class='px-6 py-5 text-sm font-semibold text-slate-400'>" . $i++ . "</td>
        <td class='px-6 py-5 text-sm font-medium text-primary'>" . $row['Present_date'] . "</td>
        <td class='px-6 py-5'>
                                    <div class='flex items-center gap-3'>
                                        <div>
                                            <p class='text-sm font-bold text-primary leading-tight'>" . $row['labour_name'] . "</p>
                                            <p class='text-xs text-on-surface-variant'>Skilled Mason</p>
                                        </div>
                                    </div>
                                </td>
        <td class='px-6 py-5 text-center'>
                                    <span
                                        class='inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-700'>
                                        Present
                                    </span>
                                </td>
         <td class='px-6 py-5 text-sm font-semibold text-primary'>" . $row['salary_of_date'] . "</td>
        <td class='px-6 py-5 text-sm font-semibold text-secondary'>" . $row['OT'] . "</td>
        <td class='px-6 py-5 text-sm font-semibold text-error'>" . $row['withdrawal'] . "</td>
          <td class='px-6 py-5 text-right'>
                                    <button
                                        class='p-1.5 text-slate-400 hover:text-error hover:bg-error-container/20 rounded transition-colors active:scale-90 btn-delete-attendance'
                                        data-labour-id='" . $row["labour_id"] . "'
                                        data-date='" . $row['Present_date'] . "'
                                        data-name='" . $row['labour_name'] . "'>
                                        <span class='material-symbols-outlined text-xl' data-icon='delete'>delete</span>
                                    </button>
                                </td>
                                
        </tr>";
        } else {
            $output .= "<tr class='hover:bg-surface-container-low transition-colors group'>
        <td class='px-6 py-5 text-sm font-semibold text-slate-400'>" . $i++ . "</td>
        <td class='px-6 py-5 text-sm font-medium text-primary'>" . $row['Present_date'] . "</td>
        <td class='px-6 py-5'>
                                    <div class='flex items-center gap-3'>
                                        <div>
                                            <p class='text-sm font-bold text-primary leading-tight'>" . $row['labour_name'] . "</p>
                                            <p class='text-xs text-on-surface-variant'>Skilled Mason</p>
                                        </div>
                                    </div>
                                </td>
        <td class='px-6 py-5 text-center'>
                                    <span
                                        class='inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-error-container text-on-error-container'>
                                        Absent
                                    </span>
                                </td>
        <td></td>
        <td class='px-6 py-5 text-sm font-semibold text-secondary'>" . $row['OT'] . "</td>
        <td class='px-6 py-5 text-sm font-semibold text-error'>" . $row['withdrawal'] . "</td>
          <td class='px-6 py-5 text-right'>
                                    <button
                                        class='p-1.5 text-slate-400 hover:text-error hover:bg-error-container/20 rounded transition-colors active:scale-90 btn-delete-attendance'
                                        data-labour-id='" . $row["labour_id"] . "'
                                        data-date='" . $row['Present_date'] . "'
                                        data-name='" . $row['labour_name'] . "'>
                                        <span class='material-symbols-outlined text-xl' data-icon='delete'>delete</span>
                                    </button>
                                </td>
                                
        </tr>";
        }
    } else {
        $output .= "<tr>
        <td></td>
        <td></td>
        
        <td><b>Total Presents</b></td>
        <td><b>" . $row['totalATT'] . "</b></td>
        <td><b>₹" . $row['total_earnings'] . "</b></td>
        <td></td>
        <td><b>" . $row['total_withdrawal'] . "</b></td>
        </tr>";
    }
}

echo $output;

// Close the statement and connection
$stmt->close();
$conn->close();
