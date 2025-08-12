<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ImportDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Read the data-only SQL file
        $sqlFile = base_path('data_only.sql');
        
        if (!file_exists($sqlFile)) {
            $this->command->error("SQL file not found: $sqlFile");
            return;
        }
        
        $sql = file_get_contents($sqlFile);
        
        if (!$sql) {
            $this->command->error("Could not read SQL file");
            return;
        }
        
        $this->command->info("🚀 Starting data import...");
        
        try {
            // Disable foreign key checks
            DB::statement('SET FOREIGN_KEY_CHECKS = 0');
            
            // Split SQL into individual statements
            $statements = array_filter(
                array_map('trim', explode(';', $sql)),
                function($stmt) {
                    return !empty($stmt) && 
                           !str_starts_with($stmt, '--') && 
                           !str_starts_with($stmt, '/*') &&
                           str_contains(strtoupper($stmt), 'INSERT');
                }
            );
            
            $imported = 0;
            $errors = 0;
            
            foreach ($statements as $statement) {
                try {
                    DB::statement($statement);
                    $imported++;
                    
                    // Extract table name for progress
                    preg_match('/INSERT INTO `?([^`\s]+)`?/', $statement, $matches);
                    $tableName = $matches[1] ?? 'unknown';
                    
                    $this->command->info("✅ Imported data to: $tableName");
                    
                } catch (\Exception $e) {
                    $errors++;
                    $this->command->warn("❌ Error in statement: " . substr($statement, 0, 100) . "...");
                    $this->command->warn("   Error: " . $e->getMessage());
                }
            }
            
            // Re-enable foreign key checks
            DB::statement('SET FOREIGN_KEY_CHECKS = 1');
            
            $this->command->info("\n🎉 Import completed!");
            $this->command->info("✅ Successfully imported: $imported statements");
            
            if ($errors > 0) {
                $this->command->warn("⚠️  Errors encountered: $errors statements");
            }
            
        } catch (\Exception $e) {
            DB::statement('SET FOREIGN_KEY_CHECKS = 1'); // Re-enable on error
            $this->command->error("❌ Import failed: " . $e->getMessage());
        }
    }
}
