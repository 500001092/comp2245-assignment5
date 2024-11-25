<?php
header("Content-Type: text/html; charset=UTF-8");

$host = 'localhost';
$dbname = 'world';
$username = 'lab5_user';
$password = 'password123';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_GET['country']) && !empty($_GET['country'])) {
        $country = $_GET['country'];
        $stmt = $pdo->prepare("SELECT name, continent, independence_year, head_of_state FROM countries WHERE name LIKE ?");
        $stmt->execute(["%$country%"]);

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($results) {
            echo "<table border='1'>";
            echo "<thead>";
            echo "<tr>";
            echo "<th>Country Name</th>";
            echo "<th>Continent</th>";
            echo "<th>Independence Year</th>";
            echo "<th>Head of State</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            foreach ($results as $row) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['continent']) . "</td>";
                echo "<td>" . htmlspecialchars($row['independence_year'] ?? 'N/A') . "</td>";
                echo "<td>" . htmlspecialchars($row['head_of_state'] ?? 'N/A') . "</td>";
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
        } else {
            echo "<p>No results found for \"$country\".</p>";
        }
    } else {
        echo "<p>Please provide a country name.</p>";
    }
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
}
?>
