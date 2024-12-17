<?php

namespace App\Models;

use CodeIgniter\Database\BaseResult;
use CodeIgniter\Model;
use Error;

class TeamMemberModel extends Model
{
    protected $table            = 'team_members';
    protected $tableSingular    = 'team_member';

    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['team', 'account', 'hero', 'hero_id', 'hero_role', 'hero_image', 'hero_scraper'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function findAllMembers(bool $withAccount = true, bool $withTeam = false)
    {
        $members = $this->select("$this->table.*")
            ->orderBy("$this->table.updated_at");

        if ($withAccount) $members = $members->withAccount();
        if ($withTeam) $members = $members->withTeam();
        $members = $members->findAll();

        return $this->serialize($members);
    }

    public function withAccount(?array $options = ['withAccountUser' => true, 'withAccountGame' => true])
    {
        $accountTable = GameAccountModel::getConfigName('tableName');
        $accountTableSingular = GameAccountModel::getConfigName('tableSingular');
        $accountPK = GameAccountModel::getConfigName('primaryKey');

        $accountMaped = $this->modelMapper(GameAccountModel::class, "{$this->tableSingular}_{$accountTableSingular}",);
        $account = $this->select($accountMaped)->join($accountTable, "$this->table.account = $accountTable.$accountPK", "left");

        if (!empty($options['withAccountUser'])) {
            $userTable = UserModel::getConfigName('tableName');
            $userTableSingular = UserModel::getConfigName('tableSingular');
            $userPK = UserModel::getConfigName('primaryKey');
            $accountUserMaped = $this->modelMapper(UserModel::class, "{$this->tableSingular}_{$accountTableSingular}_{$userTableSingular}");

            $account = $account->select($accountUserMaped)
                ->join("$userTable", "$accountTable.user = $userTable.$userPK", "left");
        }

        if (!empty($options['withAccountGame'])) {
            $gameTable = GameModel::getConfigName('tableName');
            $gameTableSingular = GameModel::getConfigName('tableSingular');
            $gamePK = GameModel::getConfigName('primaryKey');
            $accountGameMaped = $this->modelMapper(GameModel::class, "{$this->tableSingular}_{$accountTableSingular}_{$gameTableSingular}");

            $account = $account->select($accountGameMaped)
                ->join("$gameTable", "$accountTable.game = $gameTable.$gamePK", "left");
        }

        return $account;
    }

    public function withTeam(bool $withCreator = true, bool $withGame = true)
    {
        $teamTable = TeamModel::getConfigName('tableName');
        $teamTableSingular = TeamModel::getConfigName('tableSingular');
        $teamPK = TeamModel::getConfigName('primaryKey');

        $teamMaped = $this->modelMapper(TeamModel::class, "{$this->tableSingular}_{$teamTableSingular}",);
        $team = $this->select($teamMaped)->join($teamTable, "$this->table.team = $teamTable.$teamPK", "left");

        if (!empty($withCreator)) {
            $userTable = UserModel::getConfigName('tableName');
            $userTableSingular = 'creator';
            $userPK = UserModel::getConfigName('primaryKey');
            $teamCreatorMaped = $this->modelMapper(UserModel::class, "{$this->tableSingular}_{$teamTableSingular}_{$userTableSingular}");

            $team = $team->select($teamCreatorMaped)
                ->join("$userTable", "$teamTable.creator = $userTable.$userPK", "left");
        }

        if (!empty($withGame)) {
            $gameTable = GameModel::getConfigName('tableName');
            $gameTableSingular = GameModel::getConfigName('tableSingular');
            $gamePK = GameModel::getConfigName('primaryKey');
            $teamGameMaped = $this->modelMapper(GameModel::class, "{$this->tableSingular}_{$teamTableSingular}_{$gameTableSingular}");

            $team = $team->select($teamGameMaped)
                ->join("$gameTable", "$teamTable.game = $gameTable.$gamePK", "left");
        }

        return $team;
    }

    /**
     * Join to team 
     *
     * @param array $teamMemberData
     * @return integer|boolean
     */
    public function joinTeam(array $teamMemberData): int|bool
    {
        try {
            return $this->insert($teamMemberData, true);
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function leaveTeam(string|int $teamMemberId): BaseResult|bool
    {
        try {
            return $this->delete($teamMemberId);
        } catch (\Throwable $th) {
            return false;
        }
    }

    private function modelMapper(string $model, ?string $prefixName = null): string
    {
        if (!class_exists($model)) throw new Error("Model $model is not exist!");
        $instance = new $model;

        $tableName = $instance->table;
        $tableNameSingular = $instance->tableSingular;

        $tablePK = $instance->primaryKey;
        $tableField = array_filter($instance->allowedFields, fn ($field) => $field !== 'password');

        $prefix = !empty($prefixName) ? $prefixName : $tableNameSingular;

        $maping = join(", ", array_merge(
            ["$tableName.$tablePK AS {$prefix}_{$tablePK}"],
            array_map(fn ($field) => "$tableName.$field AS {$prefix}_{$field}", $tableField)
        ));

        return $maping;
    }

    public function serialize(array|\stdClass|null $data)
    {
        if ($data == null) return $data;
        $gameTable = GameModel::getConfigName('tableSingular');
        $accountTable = GameAccountModel::getConfigName('tableSingular');
        $userTable = UserModel::getConfigName('tableSingular');
        $teamTable = TeamModel::getConfigName('tableSingular');

        if (gettype($data) == "array") {
            $teams = array_map(fn ($team) => $this->serialize($team), $data);
            return $teams;
        }

        $data = to_array($data);
        $member = [];
        foreach ($data as $memberKey => $memberVal) {
            $childAccountUser = "/{$this->tableSingular}_{$accountTable}_{$userTable}_/";
            $childAccountGame = "/{$this->tableSingular}_{$accountTable}_{$gameTable}_/";
            $childAccount = "/{$this->tableSingular}_{$accountTable}_/";
            $childTeam = "/{$this->tableSingular}_{$teamTable}_/";
            $childTeamCreator = "/{$this->tableSingular}_{$teamTable}_creator_/";
            $childTeamGame = "/{$this->tableSingular}_{$teamTable}_{$gameTable}_/";

            if (preg_match($childAccountUser, $memberKey)) {
                $prefixKey = preg_replace($childAccountUser, "", $memberKey);

                if (empty($member[$accountTable][$userTable][$prefixKey]) || !is_array($member[$accountTable][$userTable][$prefixKey])) {
                    if (!is_array($member[$accountTable][$userTable])) $member[$accountTable][$userTable] = [];
                    $member[$accountTable][$userTable][$prefixKey] = $this->serializeType($memberVal);
                } else {
                    $member[$accountTable][$userTable][$prefixKey] = $this->serializeType($memberVal);
                }
                continue;
            }
            if (preg_match($childAccountGame, $memberKey)) {
                $prefixKey = preg_replace($childAccountGame, "", $memberKey);

                if (empty($member[$accountTable][$gameTable][$prefixKey]) || !is_array($member[$accountTable][$gameTable][$prefixKey])) {
                    if (!is_array($member[$accountTable][$gameTable])) $member[$accountTable][$gameTable] = [];
                    $member[$accountTable][$gameTable][$prefixKey] = $this->serializeType($memberVal);
                } else {
                    $member[$accountTable][$gameTable][$prefixKey] = $this->serializeType($memberVal);
                }
                continue;
            } else if (preg_match($childTeamCreator, $memberKey)) {
                $prefixKey = preg_replace($childTeamCreator, "", $memberKey);
                $userTable = "creator";
                if (empty($member[$teamTable][$userTable][$prefixKey]) || !is_array($member[$teamTable][$userTable][$prefixKey])) {
                    if (!is_array($member[$teamTable][$userTable])) $member[$teamTable][$userTable] = [];
                    $member[$teamTable][$userTable][$prefixKey] = $this->serializeType($memberVal);
                } else {
                    $member[$teamTable][$userTable][$prefixKey] = $this->serializeType($memberVal);
                }
                continue;
            } else if (preg_match($childTeamGame, $memberKey)) {
                $prefixKey = preg_replace($childTeamGame, "", $memberKey);

                if (empty($member[$teamTable][$gameTable][$prefixKey]) || !is_array($member[$teamTable][$gameTable][$prefixKey])) {
                    if (!is_array($member[$teamTable][$gameTable])) $member[$teamTable][$gameTable] = [];
                    $member[$teamTable][$gameTable][$prefixKey] = $this->serializeType($memberVal);
                } else {
                    $member[$teamTable][$gameTable][$prefixKey] = $this->serializeType($memberVal);
                }
                continue;
            } else if (preg_match($childAccount, $memberKey)) {
                $prefixKey = preg_replace($childAccount, "", $memberKey);

                if (empty($member[$accountTable][$prefixKey]) || !is_array($member[$accountTable][$prefixKey])) {
                    if (!is_array($member[$accountTable])) $member[$accountTable] = [];
                    $member[$accountTable][$prefixKey] = $this->serializeType($memberVal);
                } else {
                    $member[$accountTable][$prefixKey] = $this->serializeType($memberVal);
                }
                continue;
            } else if (preg_match($childTeam, $memberKey)) {
                $prefixKey = preg_replace($childTeam, "", $memberKey);

                if (empty($member[$teamTable][$prefixKey]) || !is_array($member[$teamTable][$prefixKey])) {
                    if (!is_array($member[$teamTable])) $member[$teamTable] = [];
                    $member[$teamTable][$prefixKey] = $this->serializeType($memberVal);
                } else {
                    $member[$teamTable][$prefixKey] = $this->serializeType($memberVal);
                }
                continue;
            }

            $member[$memberKey] = $this->serializeType($memberVal);
        }


        return to_object($member);
    }


    private function serializeType(mixed $data): mixed
    {
        if (is_numeric($data)) return intval($data);
        if (is_bool($data)) return boolval($data);
        if (is_string($data)) return strval($data);

        return $data;
    }

    public static function getConfigName(string $configName = null): string|array
    {;
        $instance = new self();

        switch ($configName) {
            case 'tableName':
                return $instance->table;
            case 'tableSingular':
                return $instance->tableSingular;
            case 'primaryKey':
                return $instance->primaryKey;
            case 'createdField':
                return $instance->createdField;
            case 'updatedField':
                return $instance->updatedField;
            default:
                return [
                    'tableName'    => $instance->table,
                    'primaryKey'   => $instance->primaryKey,
                    'createdField' => $instance->createdField,
                    'updatedField' => $instance->updatedField,
                ];
        }
    }
}
