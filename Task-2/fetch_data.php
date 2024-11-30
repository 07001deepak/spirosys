<?php
require 'config.php';

$filter = $_POST['filter'];
$selected_date = $_POST['selected_date'];

if (!$filter || !$selected_date) {
    echo json_encode(["error" => "Invalid input"]);
    exit;
}

$query = "";
$selected_date = (new DateTime($selected_date))->format('m-d-Y');

$query = "";
$date = DateTime::createFromFormat('m-d-Y', $selected_date);

if ($filter === 'day') {
    $start_date = $date->modify('-7 days')->format('m-d-Y');
    mysqli_query($con, "truncate table top_permits");
    $query = "SELECT Job_, Borough, Initial_Cost,Latest_Action_Date 
              FROM dob_latest_action 
              WHERE STR_TO_DATE(Latest_Action_Date, '%m-%d-%Y') BETWEEN STR_TO_DATE('$start_date', '%m-%d-%Y') 
              AND STR_TO_DATE('$selected_date', '%m-%d-%Y') 
              ORDER BY Initial_Cost DESC 
              LIMIT 50";
} elseif ($filter === 'month') {
    $start_date = $date->modify('-30 days')->format('m-d-Y');
    mysqli_query($con, "TRUNCATE TABLE top_permits");

    $query = "SELECT Job_, Borough,Initial_Cost, Latest_Action_Date FROM dob_latest_action WHERE STR_TO_DATE(Latest_Action_Date, '%m-%d-%Y') >= STR_TO_DATE('$start_date', '%m-%d-%Y') AND STR_TO_DATE(Latest_Action_Date, '%m-%d-%Y') < STR_TO_DATE('$selected_date', '%m-%d-%Y') ORDER BY Initial_Cost DESC LIMIT 50;";
} elseif ($filter === 'year') {
    $start_date = $date->modify('-1 year')->format('m-d-Y');
    mysqli_query($con, "truncate table top_permits");
    $query = "SELECT Job_, Borough, Initial_Cost,Latest_Action_Date 
    FROM dob_latest_action 
    WHERE STR_TO_DATE(Latest_Action_Date, '%m-%d-%Y') BETWEEN STR_TO_DATE('$start_date', '%m-%d-%Y') 
    AND STR_TO_DATE('$selected_date', '%m-%d-%Y') 
    ORDER BY Initial_Cost 
    LIMIT 50";
}

$result = $con->query($query);

if ($result->num_rows > 0) {

    while ($row = $result->fetch_assoc()) {
        $job = $row['Job_'];
        $borough = $row['Borough'];
        $Initial_Cost = $row['Initial_Cost'];
        $latest_action_date = $row['Latest_Action_Date'];
        $created_at = date('Y-m-d H:i:s');

        $insert_query = "INSERT INTO top_permits (Job_, Borough, Initial_Cost,Latest_Action_Date, created_At) 
                         VALUES ('$job', '$borough','$Initial_Cost', '$latest_action_date', '$created_at')";
        $con->query($insert_query);
    }
}





$display_query = "SELECT Job_, Borough,Initial_Cost , Latest_Action_Date 
    FROM top_permits ORDER BY Initial_Cost  DESC 
    LIMIT 50";



$display_result = $con->query($display_query);

if ($display_result->num_rows > 0) {
    $data = [];
    while ($row = $display_result->fetch_assoc()) {
        $data[] = $row;
    }
    echo json_encode($data);
} else {
    echo json_encode([]);
}

$con->close();
