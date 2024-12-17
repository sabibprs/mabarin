<?php

namespace App\Models;

use CodeIgniter\Database\BaseResult;
use CodeIgniter\Model;
use Error;
use PhpParser\Node\Stmt\TryCatch;

class TeamModel extends Model
{
    public static array $availableTeamStatus     = ['draft', 'recruite', 'matches', 'archive'];
    public static string $defaultStatus          = 'draft';

    protected $table            = 'teams';
    protected $tableSingular    = 'team';

    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['code', 'game', 'creator', 'name', 'status'];

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

    private TeamMemberModel $teamMemberModel;
    private bool $isWithMembers = false;

    public function __construct(...$params)
    {
        parent::__construct(...$params);
        $this->teamMemberModel = model(TeamMemberModel::class);
    }


    public function findAll(int $limit = 0, int $offset = 0)
    {
        $result = parent::findAll($limit, $offset);
        if (!$this->isWithMembers) return $this->serialize($result);

        $result = array_map(function ($team) {
            $team = to_object(array_merge(to_array($team), ['members' => []]));
            $teamMembers = $this->teamMemberModel->where('team', $team->id)->findAllMembers(true, false);
            $team->members = $this->teamMemberModel->serialize($teamMembers);

            return $team;
        }, $result);

        $this->isWithMembers = false;
        return $this->serialize($result);
    }

    public function first()
    {
        $result =  parent::first();
        if (!$this->isWithMembers) return $this->serialize($result);

        $result = to_object(array_merge(to_array($result), ['members' => []]));

        $teamMembers = $this->teamMemberModel->where('team', $result->id)->findAllMembers(true, false);
        if (count($teamMembers) > 0) $result->members = $this->teamMemberModel->serialize($teamMembers);

        $this->isWithMembers = false;
        return $this->serialize($result);
    }


    public function findAllTeams(int $limit = 0, int $offset = 0)
    {
        $teams = $this->select("$this->table.*")
            ->withMembers()
            ->withCreator()
            ->withGame()
            ->orderBy("$this->table.status", "DESC")
            ->orderBy("$this->table.updated_at", "DESC");
        $teams = $teams->findAll($limit, $offset);


        return $teams;
    }

    public function findTeamByCode(int|string $teamCode)
    {
        $team = $this->select("$this->table.*")
            ->where("$this->table.code", $teamCode)
            ->withMembers()
            ->withCreator()
            ->withGame()
            ->orderBy("$this->table.status", "DESC")
            ->orderBy("$this->table.updated_at", "DESC");

        return $team->first();
    }

    public function findOwnTeams(int $creatorId, int $limit = 0, int $offset = 0)
    {
        $teams = $this->select("$this->table.*")
            ->where("$this->table.creator", $creatorId)
            ->withMembers()
            ->withCreator()
            ->withGame()
            ->orderBy("$this->table.status", "DESC")
            ->orderBy("$this->table.updated_at", "DESC");
        $teams = $teams->findAll();


        return $teams;
    }

    public function withCreator()
    {
        $userTable = UserModel::getConfigName('tableName');
        $userPK = UserModel::getConfigName('primaryKey');
        $maper = $this->modelMapper(UserModel::class, "{$this->tableSingular}_creator");

        return $this->select($maper)->join($userTable, "$this->table.creator = $userTable.$userPK", "left");
    }


    public function withGame(string|int $gameCode = null, string|null $gameType = "code", bool $withParseCreator = true)
    {
        $gameTable = GameModel::getConfigName('tableName');
        $gameTableSingular = GameModel::getConfigName('tableSingular');
        $gamePK = GameModel::getConfigName('primaryKey');

        $gameMaped = $this->modelMapper(GameModel::class, "{$this->tableSingular}_{$gameTableSingular}");
        $game = $this->select($gameMaped)->join($gameTable, "$this->table.game = $gameTable.$gamePK", "left");
        if (!empty($gameCode)) $game = $game->where("$gameTable.$gameType", $gameCode);

        if ($withParseCreator) {
            $creatorTable = UserModel::getConfigName('tableName');
            $creatorTableSingular = UserModel::getConfigName('tableSingular');
            $creatorTableSingularPrefix = 'creator';
            $creatorPK = UserModel::getConfigName('primaryKey');
            $gameCreatorMaped = $this->modelMapper(UserModel::class, "{$this->tableSingular}_{$gameTableSingular}_{$creatorTableSingularPrefix}");

            $game = $game->select($gameCreatorMaped)
                ->join("$creatorTable AS {$this->tableSingular}_game_creator", "$gameTable.creator = {$this->tableSingular}_game_creator.$creatorPK", "left");
        }

        return $game;
    }

    public function withMembers()
    {
        $this->isWithMembers = true;
        return $this;
    }

    /**
     * Create new Team
     *
     * @param array $teamData
     * @return integer|boolean
     */
    public function addTeam(array $teamData): int|bool
    {
        try {
            return $this->insert($teamData, true);
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function updateTeam(string|int $teamId, array $teamData): bool
    {
        try {
            return $this->update($teamId, $teamData);
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function deleteTeam(string|int $teamId): BaseResult|bool
    {
        try {
            return $this->delete($teamId);
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
        $userTable = UserModel::getConfigName('tableSingular');
        $prefixUserTable = 'creator';

        if (gettype($data) == "array") {
            $teams = array_map(fn ($team) => $this->serialize($team), $data);
            return $teams;
        }

        $data = to_array($data);
        $team = [];
        foreach ($data as $teamKey => $teamVal) {
            $childGameCreator = "/{$this->tableSingular}_{$gameTable}_{$prefixUserTable}_/";
            $childCreator = "/{$this->tableSingular}_{$prefixUserTable}_/";
            $childGame = "/{$this->tableSingular}_{$gameTable}_/";

            if (preg_match($childGameCreator, $teamKey)) {
                $prefixName = 'creator';
                $prefixKey = preg_replace($childGameCreator, "", $teamKey);
                if (empty($team[$gameTable][$prefixName]) || !is_array($team[$gameTable][$prefixName])) {
                    $team[$gameTable][$prefixName] = [];
                    $team[$gameTable][$prefixName][$prefixKey] = $this->serializeType($teamVal);
                } else {
                    $team[$gameTable][$prefixName][$prefixKey] = $this->serializeType($teamVal);
                }
                continue;
            } else if (preg_match($childGame, $teamKey)) {
                $prefixKey = preg_replace($childGame, "", $teamKey);
                if (!is_array($team[$gameTable])) {
                    $team[$gameTable] = [];
                    $team[$gameTable][$prefixKey] = $this->serializeType($teamVal);
                } else {
                    $team[$gameTable][$prefixKey] = $this->serializeType($teamVal);
                }
                continue;
            } else if (preg_match($childCreator, $teamKey)) {
                $prefixName = 'creator';
                $prefixKey = preg_replace($childCreator, "", $teamKey);
                if (!is_array($team[$prefixName])) {
                    $team[$prefixName] = [];
                    $team[$prefixName][$prefixKey] = $this->serializeType($teamVal);
                } else {
                    $team[$prefixName][$prefixKey] = $this->serializeType($teamVal);
                }
                continue;
            }

            $team[$teamKey] = $this->serializeType($teamVal);
        }

        return to_object($team);
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
