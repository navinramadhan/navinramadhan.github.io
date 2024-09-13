<?php
require 'db.php';  // Menghubungkan ke database

// Ambil semua room yang ada dari database
$stmt = $pdo->prepare("SELECT room_name FROM rooms");
$stmt->execute();
$rooms = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buzz In Game</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar-custom {
            background-color: #343a40;
        }

        .navbar-custom .navbar-brand,
        .navbar-custom .nav-link {
            color: #ffffff;
        }

        .navbar-custom .nav-link:hover {
            color: #d4d4d4;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-custom mb-4">
        <div class="container">
            <a class="navbar-brand" href="index.php">Buzz In Game</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="history.php">History</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h1 class="text-center mb-4">Buzz In Game: Choose Your Role</h1>
        <div class="row justify-content-center">
            <!-- Host Card -->
            <div class="col-md-5">
                <div class="card text-center">
                    <div class="card-header bg-primary text-white">
                        <h3>Host</h3>
                    </div>
                    <div class="card-body">
                        <form action="host.php" method="post">
                            <div class="mb-3">
                                <label for="roomName" class="form-label">Room Name:</label>
                                <input type="text" class="form-control" id="roomName" name="roomName" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Create Room</button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Player Card -->
            <div class="col-md-5">
                <div class="card text-center">
                    <div class="card-header bg-success text-white">
                        <h3>Player</h3>
                    </div>
                    <div class="card-body">
                        <form action="player.php" method="post">
                            <div class="mb-3">
                                <label for="playerName" class="form-label">Player Name:</label>
                                <input type="text" class="form-control" id="playerName" name="playerName" required>
                            </div>
                            <div class="mb-3">
                                <label for="roomNameJoin" class="form-label">Choose Room:</label>
                                <select class="form-select" id="roomNameJoin" name="roomNameJoin" required>
                                    <option value="" disabled selected>Select a Room</option>
                                    <?php foreach ($rooms as $room): ?>
                                        <option value="<?= htmlspecialchars($room['room_name']); ?>">
                                            <?= htmlspecialchars($room['room_name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success w-100">Join Room</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>