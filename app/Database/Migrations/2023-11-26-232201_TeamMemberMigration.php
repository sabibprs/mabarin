<?php

namespace App\Database\Migrations;

use App\Models\GameAccountModel;
use App\Models\GameModel;
use App\Models\TeamMemberModel;
use App\Models\TeamModel;
use App\Models\UserModel;
use CodeIgniter\Database\Migration;

class TeamMemberMigration extends Migration
{
    protected string $tableName;
    protected string $primaryKey;
    protected array $foreignKeys = [];

    public function __construct()
    {
        parent::__construct();

        $this->tableName  = TeamMemberModel::getConfigName('tableName');
        $this->primaryKey = TeamMemberModel::getConfigName('primaryKey');
        $this->foreignKeys = [
            "FK_TeamMemberTeam" => [
                'field'      => 'team',
                'field_type' => [
                    'type'       => 'BIGINT',
                    'constraint' => 5,
                    'unsigned'   => true,
                ],
                'ref_table'  => TeamModel::getConfigName('tableName'),
                'ref_field'  => TeamModel::getConfigName('primaryKey'),
                'on_update'  => 'CASCADE',
                'on_delete'  => 'CASCADE',
            ],
            "FK_TeamMemberAccount" => [
                'field'      => 'account',
                'field_type' => [
                    'type'       => 'BIGINT',
                    'constraint' => 5,
                    'unsigned'   => true,
                ],
                'ref_table'  => GameAccountModel::getConfigName('tableName'),
                'ref_field'  => GameAccountModel::getConfigName('primaryKey'),
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

        $availableGameScraper = "('" . implode("', '", GameModel::$availableScraper) . "')";

        $this->forge->addField([
            $this->primaryKey => [
                'type'           => 'BIGINT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            ...$foreignKey,
            'hero' => [
                'type'       => 'VARCHAR',
                'constraint' => 64,
                'null'       => false,
            ],
            'hero_id' => [
                'type'       => 'VARCHAR',
                'constraint' => 64,
                'null'       => true,
            ],
            'hero_role' => [
                'type'       => 'VARCHAR',
                'constraint' => 64,
                'null'       => true
            ],
            'hero_image' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true
            ],
            'hero_scraper' => [
                'type'       => "VARCHAR",
                'constraint' => 32,
                'null'       => true,
                'check'      => "hero_scraper IN $availableGameScraper OR hero_scraper IS NULL",
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
