<?php
/**
 * Script untuk import data saja dari SQL dump ke database lokal
 * Mengabaikan CREATE TABLE dan struktur, hanya import INSERT statements
 */

// Read the SQL file
$sqlFile = 'database_backup.sql';
$sqlContent = file_get_contents($sqlFile);

if (!$sqlContent) {
    die("Could not read SQL file: $sqlFile\n");
}

// Split into lines
$lines = explode("\n", $sqlContent);

// Extract only INSERT statements
$insertStatements = [];
$currentInsert = '';
$inInsert = false;

foreach ($lines as $line) {
    $line = trim($line);
    
    // Skip comments and empty lines
    if (empty($line) || substr($line, 0, 2) === '--' || substr($line, 0, 2) === '/*') {
        continue;
    }
    
    // Check if this is an INSERT statement
    if (preg_match('/^INSERT INTO/', $line)) {
        $inInsert = true;
        $currentInsert = $line;
        
        // Check if this INSERT is complete on one line
        if (substr($line, -1) === ';') {
            $insertStatements[] = $currentInsert;
            $currentInsert = '';
            $inInsert = false;
        }
    } else if ($inInsert) {
        // Continue building multi-line INSERT
        $currentInsert .= "\n" . $line;
        
        // Check if INSERT is complete
        if (substr($line, -1) === ';') {
            $insertStatements[] = $currentInsert;
            $currentInsert = '';
            $inInsert = false;
        }
    }
}

// Write extracted INSERT statements to a new file
$insertOnlyFile = 'data_only.sql';
$insertContent = "-- Data-only import\n";
$insertContent .= "-- Generated from: $sqlFile\n\n";
$insertContent .= "SET FOREIGN_KEY_CHECKS = 0;\n\n";

foreach ($insertStatements as $insert) {
    $insertContent .= $insert . "\n\n";
}

$insertContent .= "SET FOREIGN_KEY_CHECKS = 1;\n";

file_put_contents($insertOnlyFile, $insertContent);

echo "✅ Data extraction completed!\n";
echo "📁 File created: $insertOnlyFile\n";
echo "📊 Total INSERT statements: " . count($insertStatements) . "\n\n";

echo "🚀 Next step: Run this command to import:\n";
echo "php artisan db:seed --class=ImportDataSeeder\n";

?>
