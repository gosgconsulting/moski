<?php
// Test Redis Extension
echo "<h1>Redis Extension Test</h1>";

if (extension_loaded('redis')) {
    echo "<p style='color: green;'>✅ Redis extension is loaded!</p>";
    
    // Test connection
    $redis = new Redis();
    try {
        $redis->connect('redis', 6379);
        echo "<p style='color: green;'>✅ Redis connection successful!</p>";
        
        // Test basic operations
        $redis->set('test_key', 'Hello from WordPress!');
        $value = $redis->get('test_key');
        
        if ($value === 'Hello from WordPress!') {
            echo "<p style='color: green;'>✅ Redis read/write operations working!</p>";
        } else {
            echo "<p style='color: red;'>❌ Redis read/write failed!</p>";
        }
        
        // Get Redis info
        $info = $redis->info();
        echo "<h2>Redis Server Info:</h2>";
        echo "<ul>";
        echo "<li>Redis Version: " . $info['redis_version'] . "</li>";
        echo "<li>Used Memory: " . $info['used_memory_human'] . "</li>";
        echo "<li>Connected Clients: " . $info['connected_clients'] . "</li>";
        echo "</ul>";
        
        $redis->close();
        
    } catch (Exception $e) {
        echo "<p style='color: red;'>❌ Redis connection failed: " . $e->getMessage() . "</p>";
    }
} else {
    echo "<p style='color: red;'>❌ Redis extension is NOT loaded!</p>";
}

// Test database connection
echo "<h1>Database Connection Test</h1>";
$db_host = getenv('WORDPRESS_DB_HOST') ?: 'localhost';
$db_user = getenv('WORDPRESS_DB_USER') ?: 'root';
$db_pass = getenv('WORDPRESS_DB_PASSWORD') ?: '';
$db_name = getenv('WORDPRESS_DB_NAME') ?: 'wordpress';

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    echo "<p style='color: green;'>✅ Database connection successful!</p>";
    echo "<p>Database: $db_name on $db_host</p>";
} catch (PDOException $e) {
    echo "<p style='color: red;'>❌ Database connection failed: " . $e->getMessage() . "</p>";
}

// System info
echo "<h1>System Information</h1>";
echo "<ul>";
echo "<li>PHP Version: " . phpversion() . "</li>";
echo "<li>Server: " . $_SERVER['SERVER_SOFTWARE'] . "</li>";
echo "<li>Loaded Extensions: " . count(get_loaded_extensions()) . "</li>";
echo "</ul>";

echo "<h2>Key Extensions:</h2>";
$key_extensions = ['redis', 'mysql', 'pdo', 'opcache', 'curl', 'gd'];
echo "<ul>";
foreach ($key_extensions as $ext) {
    $status = extension_loaded($ext) ? "✅" : "❌";
    echo "<li>$status $ext</li>";
}
echo "</ul>";
?>
