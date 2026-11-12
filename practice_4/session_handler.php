<?php
// session_handler.php
require_once __DIR__ . '/db.php';

class DbSessionHandler implements SessionHandlerInterface {
    private $conn;
    private $table = 'user_sessions';

    public function __construct() {
        $this->conn = getDbConnection();
    }

    public function open($savePath, $sessionName): bool {
        return true;
    }

    public function close(): bool {
        return true;
    }

    public function read($id): string|false {
        $stmt = $this->conn->prepare("SELECT data FROM {$this->table} WHERE id = ?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            return $row['data'];
        }
        return '';
    }

    public function write($id, $data): bool {
        $time = time();
        $stmt = $this->conn->prepare("REPLACE INTO {$this->table} (id, data, last_accessed) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $id, $data, $time);
        return $stmt->execute();
    }

    public function destroy($id): bool {
        $stmt = $this->conn->prepare("DELETE FROM {$this->table} WHERE id = ?");
        $stmt->bind_param("s", $id);
        return $stmt->execute();
    }

    public function gc($maxlifetime): int|false {
        $old = time() - $maxlifetime;
        $stmt = $this->conn->prepare("DELETE FROM {$this->table} WHERE last_accessed < ?");
        $stmt->bind_param("i", $old);
        $stmt->execute();
        return $stmt->affected_rows;
    }
}

// Регистрируем обработчик
$handler = new DbSessionHandler();
session_set_save_handler($handler, true);
session_start();