<?php
if (!class_exists('DB')) {
    class DB {
        public $pdo;

        public function __construct($db = "planning", $user = "root", $pwd = "", $host = "localhost") {
            try {
                $this->pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pwd);
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
            }
        }

        public function run($sql, $placeholders = null) {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($placeholders); 
            return $stmt;
        }
    }
}
$db = new db();
?>
