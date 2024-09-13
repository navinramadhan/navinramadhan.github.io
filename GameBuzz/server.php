<?php
session_start();
require 'db.php';  // Menghubungkan ke database

// Set timezone to Jakarta (WIB)
date_default_timezone_set('Asia/Jakarta');

if (isset($_GET['action'])) {
    $action = $_GET['action'];

    if ($action == 'fetch') {
        // Ambil semua pemain dari database berdasarkan room yang sama
        $stmt = $pdo->prepare("SELECT players.player_name, players.buzz_time 
                               FROM players 
                               JOIN rooms ON players.room_id = rooms.id 
                               WHERE rooms.room_name = ?");
        $stmt->execute([$_SESSION['roomName']]);
        $players = $stmt->fetchAll();

        asort($players); // Mengurutkan berdasarkan waktu
        $index = 1;
        foreach ($players as $player) {
            // Convert timestamp to milliseconds and format the time
            $milliseconds = round(($player['buzz_time'] - floor($player['buzz_time'])) * 1000);
            $formattedTime = date('H:i:s', floor($player['buzz_time'])) . ':' . str_pad($milliseconds, 3, '0', STR_PAD_LEFT);

            echo "<tr>
                    <td>{$index}</td>
                    <td>{$player['player_name']}</td>
                    <td>{$formattedTime}</td>
                  </tr>";
            $index++;
        }
    } elseif ($action == 'buzz') {
        $player = $_GET['player'];

        // Cek apakah player sudah pernah klik "buzz" di room ini
        $stmt = $pdo->prepare("SELECT * FROM players WHERE player_name = ? AND room_id = (SELECT id FROM rooms WHERE room_name = ?)");
        $stmt->execute([$player, $_SESSION['roomName']]);
        $existingPlayer = $stmt->fetch();

        if (!$existingPlayer) {
            // Masukkan waktu buzz player ke database
            $stmt = $pdo->prepare("INSERT INTO players (player_name, room_id, buzz_time) VALUES (?, (SELECT id FROM rooms WHERE room_name = ?), ?)");
            $stmt->execute([$player, $_SESSION['roomName'], microtime(true)]);
        }
    } elseif ($action == 'reset') {
        // Hapus semua player dari room
        $stmt = $pdo->prepare("DELETE FROM players WHERE room_id = (SELECT id FROM rooms WHERE room_name = ?)");
        $stmt->execute([$_SESSION['roomName']]);
    }
}
?>