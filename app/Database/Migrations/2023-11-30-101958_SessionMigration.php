<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;
use Config\{Session as SessionConfig};

class SessionMigration extends Migration
{
    protected SessionConfig $config;

    public function __construct()
    {
        parent::__construct();
        $this->config = config(SessionConfig::class);
    }

    public function up()
    {
        $tableName = $this->config->cookieName;
        $this->forge->addField([
            'id' => [
                'type' => 'VARCHAR',
                'constraint' => 128,
                'null' => false,
            ],
            'ip_address' => [
                'type' => 'VARCHAR',
                'constraint' => 45,
                'null' => false,
            ],
            'timestamp' => [
                'type' => 'TIMESTAMP',
                'default' => new RawSql("CURRENT_TIMESTAMP"),
                'null' => false,
            ],
            'data' => [
                'type' => 'BLOB',
                'null' => false,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('timestamp');
        $this->forge->createTable($tableName, true);
    }

    public function down()
    {
        $this->forge->dropTable($this->config->cookieName, true);
    }
}
