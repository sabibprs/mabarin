<?php

namespace App\Database\Migrations;

use App\Models\GameAccountModel;
use App\Models\GameModel;
use App\Models\UserModel;
use CodeIgniter\Database\Migration;

class GameAccountMigration extends Migration
{
    protected string $tableName;
    protected string $primaryKey;
    protected array $foreignKeys = [];

    public function __construct()
    {
        parent::__construct();

        $this->tableName  = GameAccountModel::getConfigName('tableName');
        $this->primaryKey = GameAccountModel::getConfigName('primaryKey');
        $this->foreignKeys = [
            "FK_GameAccountUser" => [
                'field'      => 'user',
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
            "FK_GameAccountGame" => [
                'field'      => 'game',
                'field_type' => [
                    'type'       => 'BIGINT',
                    'constraint' => 5,
                    'unsigned'   => true,
                ],
                'ref_table'  => GameModel::getConfigName('tableName'),
                'ref_field'  => GameModel::getConfigName('primaryKey'),
                'on_update'  => 'CASCADE',
                'on_delete'  => 'CASCADE',
            ],
        ];
    }

    public function up()
    {
        $foreignKey = [];
        foreach ($this->foreignKeys as $foreignKeyConstraintName => $foreignKeyConstraintValue) {
            $foreignKey[$this->foreignKeys[$foreignKeyConstraintName]['field']] = $foreignKeyConstraintValue['field_type'];
        }

        $availableAccountStatus = "'" . implode("', '", GameAccountModel::$availableStatus) . "'";

        $this->forge->addField([
            $this->primaryKey => [
                'type'           => 'BIGINT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            ...$foreignKey,
            'identity' => [
                'type'       => 'INT',
                'constraint' => 32,
                'null'       => false
            ],
            'identity_zone_id' => [
                'type'       => 'INT',
                'constraint' => 16,
                'null'       => true
            ],
            'status' => [
                'type'       => "ENUM($availableAccountStatus)",
                'default'    => GameAccountModel::$defaultStatus,
                'null'       => false
            ],
            'created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP',
            'updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
        ]);

        $this->forge->addKey($this->primaryKey, true);
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
