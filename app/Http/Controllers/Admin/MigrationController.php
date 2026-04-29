<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MigrationController extends Controller
{
    /**
     * Show migration status
     */
    public function index()
    {
        // Check if email_logs table exists
        $tableExists = Schema::hasTable('email_logs');
        
        return view('admin.migration.index', compact('tableExists'));
    }

    /**
     * Run specific migration
     */
    public function runMigration(Request $request)
    {
        try {
            // Check if table already exists
            if (Schema::hasTable('email_logs')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email logs table already exists'
                ]);
            }

            // Run the migration manually
            DB::statement('
                CREATE TABLE `email_logs` (
                  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
                  `recipient_email` varchar(255) NOT NULL,
                  `recipient_type` varchar(255) DEFAULT NULL,
                  `recipient_id` bigint(20) UNSIGNED DEFAULT NULL,
                  `subject` varchar(255) NOT NULL,
                  `message` text NOT NULL,
                  `email_type` varchar(255) NOT NULL,
                  `status` varchar(255) NOT NULL DEFAULT "pending",
                  `error_message` text DEFAULT NULL,
                  `sent_at` timestamp NULL DEFAULT NULL,
                  `created_at` timestamp NULL DEFAULT NULL,
                  `updated_at` timestamp NULL DEFAULT NULL,
                  PRIMARY KEY (`id`),
                  KEY `email_logs_recipient_email_status_index` (`recipient_email`, `status`),
                  KEY `email_logs_email_type_status_index` (`email_type`, `status`),
                  KEY `email_logs_sent_at_index` (`sent_at`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
            ');

            return response()->json([
                'success' => true,
                'message' => 'Email logs table created successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating table: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Drop table (for rollback)
     */
    public function rollbackMigration(Request $request)
    {
        try {
            if (!Schema::hasTable('email_logs')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email logs table does not exist'
                ]);
            }

            Schema::dropIfExists('email_logs');

            return response()->json([
                'success' => true,
                'message' => 'Email logs table dropped successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error dropping table: ' . $e->getMessage()
            ]);
        }
    }
}
