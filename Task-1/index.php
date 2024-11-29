<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spiro System - Task 1</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css" />

</head>

<body>
    <div class="container card p-3 mt-4">
        <div class="card-title bg-primary-subtle p-2">
            <h2 class="text-center">Task 1</h2>
        </div>
        <div class="card-body">
            <div class="table-responsive ">
                <table id="myTable" class="table table-bordered table-stripped">
                    <thead>
                        <th>Job No</th>
                        <th>Borough</th>
                        <th>Street Name</th>
                        <th>Job Type</th>
                        <th>Filling Date</th>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>

    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "fetchrecord.php",
                    "type": "GET"
                },
                "columns": [
                    {  "data": "Job_"},
                    { "data": "Borough"},
                    {  "data": "Street_Name"},
                    {  "data": "Job_Type" },
                    {"data": "Latest_Action_Date"}
                ]
            });
        });
    </script>

</body>

</html>