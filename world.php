<?php
header("Content-Type: text/html; charset=UTF-8");

$host = 'localhost';
$dbname = 'world';
$username = 'lab5_user';
$password = 'password123';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $lookup = $_GET['lookup'] ?? 'countries'; 
    $country = $_GET['country'] ?? '';

    if (!empty($country)) {
        if ($lookup === 'cities') {
            $stmt = $pdo->prepare("
                SELECT cities.name AS city_name, cities.district, cities.population 
                FROM cities
                JOIN countries ON cities.country_code = countries.code
                WHERE countries.name LIKE ?
            ");
            $stmt->execute(["%$country%"]);

            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($results) {
                echo "<table border='1'>";
                echo "<thead>";
                echo "<tr><th>City Name</th><th>District</th><th>Population</th></tr>";
                echo "</thead>";
                echo "<tbody>";
                foreach ($results as $row) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['city_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['district']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['population']) . "</td>";
                    echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>";
            } else {
                echo "<p>No cities found for \"$country\".</p>";
            }
        } else {
            $stmt = $pdo->prepare("
                SELECT name, continent, independence_year, head_of_state 
                FROM countries 
                WHERE name LIKE ?
            ");
            $stmt->execute(["%$country%"]);

            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($results) {
                echo "<table border='1'>";
                echo "<thead>";
                echo "<tr><th>Country Name</th><th>Continent</th><th>Independence Year</th><th>Head of State</th></tr>";
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
        }
    } else {
        echo "<p>Please provide a country name.</p>";
    }
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
}
?>
