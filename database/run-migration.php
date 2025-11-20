<?php
declare(strict_types=1);

require_once __DIR__ . '/../src/bootstrap.php';

use SRP\Config\Database;

echo "Running database migration for postbacks table...\n";

try {
    $db = Database::getConnection();

    $sql = file_get_contents(__DIR__ . '/postbacks.sql');

    if ($sql === false) {
        throw new RuntimeException('Failed to read SQL file');
    }

    if ($db->multi_query($sql)) {
        do {
            if ($result = $db->store_result()) {
                $result->free();
            }
        } while ($db->more_results() && $db->next_result());
    }

    if ($db->errno) {
        throw new RuntimeException('MySQL Error: ' . $db->error);
    }

    echo "✓ Postbacks table created successfully!\n";

    // Verify table exists
    $result = $db->query("SHOW TABLES LIKE 'postbacks'");
    if ($result && $result->num_rows > 0) {
        echo "✓ Table verified in database\n";
    }

} catch (Throwable $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
    exit(1);
}
