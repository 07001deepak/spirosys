<?php

include('config.php');


$draw = isset($_GET['draw']) ? intval($_GET['draw']) : 1;
$start = isset($_GET['start']) ? intval($_GET['start']) : 0;
$length = isset($_GET['length']) ? intval($_GET['length']) : 10;
$orderColumn = isset($_GET['order'][0]['column']) ? intval($_GET['order'][0]['column']) : 0;
$orderDir = isset($_GET['order'][0]['dir']) ? $_GET['order'][0]['dir'] : 'asc';
$searchValue = isset($_GET['search']['value']) ? $_GET['search']['value'] : '';

$columns = [
    0 => 'Job_',
    1 => 'Borough',
    2 => 'Street_Name',
    3 => 'Job_Type',
    4 => 'Latest_Action_Date'
];

$orderByColumn = $columns[$orderColumn];

$searchQuery = "";
if (!empty($searchValue)) {
    $searchQuery = "WHERE 
        Job_ LIKE '%" . mysqli_real_escape_string($con, $searchValue) . "%' OR 
        Borough LIKE '%" . mysqli_real_escape_string($con, $searchValue) . "%' OR 
        Street_Name LIKE '%" . mysqli_real_escape_string($con, $searchValue) . "%' OR 
        Job_Type LIKE '%" . mysqli_real_escape_string($con, $searchValue) . "%' OR 
        Latest_Action_Date LIKE '%" . mysqli_real_escape_string($con, $searchValue) . "%'";
}

$totalRecordsQuery = "SELECT COUNT(*) FROM dob_latest_action $searchQuery";
$result = mysqli_query($con, $totalRecordsQuery);

$totalRecords = mysqli_fetch_array($result)[0];
$query = "SELECT Job_, Borough, Street_Name, Job_Type, Latest_Action_Date
          FROM dob_latest_action $searchQuery
          ORDER BY $orderByColumn $orderDir
          LIMIT $start, $length";

$result = mysqli_query($con, $query);
$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}
$response = [
    "draw" => $draw,
    "recordsTotal" => $totalRecords,
    "recordsFiltered" => $totalRecords, 
    "data" => $data
];
echo json_encode($response);

mysqli_close($con);
?>
