<?php
/**
 * MySQL Setup Helper Script
 * Run this script to test MySQL connection and create the database
 * 
 * Usage: php setup-mysql.php
 */

echo "=================================\n";
echo "MySQL Setup Helper\n";
echo "=================================\n\n";

// Read .env file
$envFile = __DIR__ . '/.env';
if (!file_exists($envFile)) {
    echo "❌ Error: .env file not found!\n";
    exit(1);
}

$env = parse_ini_file($envFile);

$host = $env['DB_HOST'] ?? '127.0.0.1';
$port = $env['DB_PORT'] ?? 3306;
$database = $env['DB_DATABASE'] ?? 'purchasing_db';
$username = $env['DB_USERNAME'] ?? 'root';
$password = $env['DB_PASSWORD'] ?? '';

echo "📋 Current Configuration:\n";
echo "   Host: {$host}\n";
echo "   Port: {$port}\n";
echo "   Database: {$database}\n";
echo "   Username: {$username}\n";
echo "   Password: " . ($password ? str_repeat('*', strlen($password)) : '(empty)') . "\n\n";

// Test connection
echo "🔗 Testing MySQL connection...\n";

try {
    $dsn = "mysql:host={$host};port={$port}";
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "✅ Connected to MySQL successfully!\n\n";
    
    // Check if database exists
    echo "🔍 Checking if database '{$database}' exists...\n";
    $stmt = $pdo->query("SHOW DATABASES LIKE '{$database}'");
    $exists = $stmt->fetch();
    
    if ($exists) {
        echo "✅ Database '{$database}' already exists.\n\n";
        
        // Show tables if any
        $pdo->exec("USE {$database}");
        $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
        
        if (count($tables) > 0) {
            echo "📊 Existing tables in '{$database}':\n";
            foreach ($tables as $table) {
                $count = $pdo->query("SELECT COUNT(*) FROM {$table}")->fetchColumn();
                echo "   • {$table} ({$count} records)\n";
            }
            echo "\n⚠️  Warning: Running migrations will drop all existing tables!\n";
        }
    } else {
        echo "❌ Database '{$database}' does not exist.\n\n";
        
        // Ask to create
        echo "Would you like to create it now? (yes/no): ";
        $handle = fopen("php://stdin", "r");
        $answer = trim(fgets($handle));
        
        if (strtolower($answer) === 'yes' || strtolower($answer) === 'y') {
            $pdo->exec("CREATE DATABASE {$database} CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
            echo "✅ Database '{$database}' created successfully!\n\n";
        } else {
            echo "⏭️  Skipped database creation.\n\n";
        }
    }
    
    echo "🚀 Next steps:\n";
    echo "   1. Run migrations: php artisan migrate:fresh --seed\n";
    echo "   2. Start server: php artisan serve\n";
    echo "   3. Visit: http://localhost:8000\n\n";
    
} catch (PDOException $e) {
    echo "❌ Connection failed!\n\n";
    echo "Error: " . $e->getMessage() . "\n\n";
    
    echo "💡 Troubleshooting:\n";
    
    if (strpos($e->getMessage(), 'Access denied') !== false) {
        echo "   • The password in .env might be incorrect\n";
        echo "   • Update DB_PASSWORD in .env file\n";
        echo "   • Or create a new MySQL user (see MYSQL_SETUP.md)\n\n";
        
        echo "🔧 Quick fix - Update .env with your MySQL password:\n";
        echo "   DB_PASSWORD=your_actual_password\n\n";
        
    } elseif (strpos($e->getMessage(), 'Connection refused') !== false) {
        echo "   • MySQL server might not be running\n";
        echo "   • Start MySQL: brew services start mysql\n";
        echo "   • Or check: brew services list\n\n";
        
    } else {
        echo "   • Check MySQL is installed and running\n";
        echo "   • Verify credentials in .env file\n";
        echo "   • See MYSQL_SETUP.md for detailed instructions\n\n";
    }
    
    exit(1);
}
