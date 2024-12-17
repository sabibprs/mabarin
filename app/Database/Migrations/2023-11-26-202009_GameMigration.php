<?php

namespace App\Database\Migrations;

use App\Models\GameModel;
use App\Models\UserModel;
use CodeIgniter\Database\Migration;

class GameMigration extends Migration
{
    protected string $tableName;
    protected string $primaryKey;
    protected string $uniqueKey  = 'code';
    protected array $foreignKeys = [];

    public function __construct()
    {
        parent::__construct();

        $this->tableName = GameModel::getConfigName('tableName');
        $this->primaryKey = GameModel::getConfigName('primaryKey');
        $this->foreignKeys = [
            "FK_GameCreator" => [
                'field'      => 'creator',
                'field_type' => [
                    'type'       => 'BIGINT',
                    'constraint' => 5,
                    'unsigned'   => true,
                ],
                'ref_table'  => UserModel::getConfigName('tableName'),
                'ref_field'  => UserModel::getConfigName('primaryKey'),
                'on_update'  => 'CASCADE',
                'on_delete'  => 'CASCADE',
            ],
        ];
    }


    public function up(): void
    {
        $foreignKey = [];
        foreach ($this->foreignKeys as $foreignKeyConstraintName => $foreignKeyConstraintValue) {
            $foreignKey[$this->foreignKeys[$foreignKeyConstraintName]['field']] = $foreignKeyConstraintValue['field_type'];
        }

        $this->forge->addField([
            $this->primaryKey => [
                'type'           => 'BIGINT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            $this->uniqueKey => [
                'type'       => 'VARCHAR',
                'constraint' => 32,
                'null'       => false
            ],
            ...$foreignKey,
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => 64,
                'null'       => false
            ],
            'description' => [
                'type'       => 'TEXT',
                'null'       => true
            ],
            'image' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true
            ],
            'max_player' => [
                'type'       => 'INT',
                'constraint' => 5,
                'null'       => true
            ],
            'is_verified' => [
                'type'       => 'BOOLEAN',
                'default'    => false,
                'null'       => false
            ],
            'created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP',
            'updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
        ]);

        $this->forge->addKey($this->primaryKey, true);
        $this->forge->addKey($this->uniqueKey, false, true);

        foreach ($this->foreignKeys as $foreignKeyConstraintName => $foreignKey) {
            $this->forge->addForeignKey($foreignKey['field'], $foreignKey['ref_table'], $foreignKey['ref_field'], $foreignKey['on_update'], $foreignKey['on_delete'], $foreignKeyConstraintName);
        }

        $this->forge->createTable($this->tableName, true);
    }

    public function down(): void
    {
        foreach ($this->foreignKeys as $foreignKeyConstraintName => $foreignKey) {
            $this->forge->dropForeignKey($this->tableName, $foreignKeyConstraintName);
        }
        $this->forge->dropTable($this->tableName, true);
    }
}
