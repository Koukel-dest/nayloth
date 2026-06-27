<?php
// Database initialization script
$host = 'localhost';
$user = 'root';
$password = '';

// Connect to MySQL without specifying a database initially
$conn = new mysqli($host, $user, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "Connected successfully\n";

// Read and execute the initialization SQL file
$sqlFile = dirname(__FILE__) . '/init_all.sql';
$sql = file_get_contents($sqlFile);

if ($sql === false) {
    die("Error reading SQL file: $sqlFile\n");
}

echo "SQL file loaded: " . strlen($sql) . " bytes\n";

// Parse SQL file handling DELIMITER statements
$queries = parseSQL($sql);

echo "Found " . count($queries) . " SQL statements\n";

$executedCount = 0;
$errorCount = 0;

foreach ($queries as $i => $query) {
    if (empty($query)) {
        continue;
    }

    if ($conn->multi_query($query)) {
        // Process all results
        do {
            if ($result = $conn->store_result()) {
                $result->free();
            }
        } while ($conn->more_results() && $conn->next_result());

        $executedCount++;
        echo "[" . ($i+1) . "] Executed\n";
    } else {
        $errorCount++;
        echo "[" . ($i+1) . "] ERROR: " . $conn->error . "\n";
        echo "Query: " . substr($query, 0, 80) . "...\n";
        // Clear pending results if any
        while ($conn->more_results()) {
            $conn->next_result();
        }
    }
}

echo "\n=== Summary ===\n";
echo "Executed: $executedCount\n";
echo "Errors: $errorCount\n";

$conn->close();
echo "\nDone!\n";

function parseSQL($sql) {
    $queries = array();
    $currentQuery = '';
    $delimiter = ';';
    $lines = explode("\n", $sql);

    foreach ($lines as $line) {
        $trimmedLine = trim($line);

        // Handle DELIMITER statements
        if (strpos($trimmedLine, 'DELIMITER') === 0) {
            if ($currentQuery) {
                $queries[] = $currentQuery;
                $currentQuery = '';
            }
            // Extract the new delimiter
            $parts = explode(' ', $trimmedLine);
            if (isset($parts[1])) {
                $delimiter = $parts[1];
            }
            continue;
        }

        // Skip empty lines and comments
        if (empty($trimmedLine) || strpos($trimmedLine, '--') === 0) {
            if ($currentQuery) {
                $currentQuery .= "\n";
            }
            continue;
        }

        $currentQuery .= $line . "\n";

        // Check if line ends with current delimiter
        if (strpos($line, $delimiter) !== false) {
            // Remove the delimiter from the end
            $currentQuery = rtrim($currentQuery);
            if (substr($currentQuery, -strlen($delimiter)) === $delimiter) {
                $currentQuery = substr($currentQuery, 0, -strlen($delimiter));
            }

            $currentQuery = trim($currentQuery);
            if ($currentQuery) {
                $queries[] = $currentQuery;
            }
            $currentQuery = '';
        }
    }

    // Add any remaining query
    if ($currentQuery) {
        $currentQuery = trim($currentQuery);
        if ($currentQuery) {
            $queries[] = $currentQuery;
        }
    }

    return array_filter($queries);
}
?>
