<?php

namespace App\Database\Migrations;

use App\Models\UserModel;
use CodeIgniter\Database\Migration;

class UserMigration extends Migration
{
    protected string $tableName;
    protected string $primaryKey;
    protected string $uniqueKey  = 'username';

    public function __construct()
    {
        parent::__construct();

        $this->tableName  = UserModel::getConfigName('tableName');
        $this->primaryKey = UserModel::getConfigName('primaryKey');
    }

    public function up(): void
    {
        $availableRole = "'" . implode("', '", UserModel::$availableRole) . "'";

        $this->forge->addField([
            $this->primaryKey => [
                'type'           => 'BIGINT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => '32',
                'null'       => false
            ],
            $this->uniqueKey => [
                'type'       => 'VARCHAR',
                'constraint' => '16',
                'null'       => false
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => '64',
                'null'       => false
            ],
            'phone' => [
                'type'       => 'VARCHAR',
                'constraint' => '15',
                'null'       => true
            ],
            'photo' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true
            ],
            'password' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => false
            ],
            'role' => [
                'type'       => "ENUM($availableRole)",
                'default'    => UserModel::$defaultRole,
                'null'       => false
            ],
            'created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP',
            'updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
        ]);

        $this->forge->addKey($this->primaryKey, true);
        $this->forge->addKey($this->uniqueKey, false, true);
        $this->forge->createTable($this->tableName, true);
    }

    public function down(): void
    {
        $this->forge->dropTable($this->tableName, true);
    }
}
