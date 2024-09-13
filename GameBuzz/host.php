<?php
session_start();
require 'db.php';  // Menghubungkan ke database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION['roomName'] = $_POST['roomName'];

    // Simpan room ke database
    $stmt = $pdo->prepare("INSERT INTO rooms (room_name) VALUES (?)");
    $stmt->execute([$_SESSION['roomName']]);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Host - Buzz In</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body style="background-color: #f3f4f6;">
    <div class="container mt-5">
        <div class="card shadow-lg p-3 mb-5 bg-body rounded">
            <div class="card-header bg-primary text-white text-center">
                <h1>Host Room: <?php echo $_SESSION['roomName']; ?></h1>
            </div>
            <div class="card-body">
                <div id="resultArea" class="mt-4">
                    <h3>Player Results:</h3>
                    <table class="table table-striped mt-3">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Player Name</th>
                                <th scope="col">Time</th>
                            </tr>
                        </thead>
                        <tbody id="results">
                            <!-- Player results will be loaded here dynamically -->
                        </tbody>
                    </table>
                </div>
                <button id="resetBtn" class="btn btn-danger mt-3 w-100">Reset</button>
            </div>
        </div>
    </div>

    <script>
        function fetchResults() {
            $.ajax({
                url: 'server.php?action=fetch',
                method: 'GET',
                success: function (data) {
                    $('#results').html(data);
                }
            });
        }

        $('#resetBtn').on('click', function () {
            $.ajax({
                url: 'server.php?action=reset',
                method: 'GET',
                success: function () {
                    fetchResults();
                }
            });
        });

        setInterval(fetchResults, 1000); // Fetch results every second
    </script>
</body>

</html>