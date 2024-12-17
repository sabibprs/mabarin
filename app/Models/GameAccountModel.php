<?php

namespace App\Models;

use CodeIgniter\Model;
use Error;
use PhpParser\Node\Stmt\TryCatch;
use stdClass;

class GameAccountModel extends Model
{
    public static array $availableStatus = ['verified', 'unverified', 'scam'];
    public static string $defaultStatus  = 'unverified';

    protected $table            = 'game_accounts';
    protected $tableSingular    = 'account';

    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['identity', 'identity_zone_id', 'user', 'game', 'status'];

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

    public function findAllAccounts(int $limit = 0, int $offset = 0)
    {
        $accounts = $this->select("$this->table.*")
            ->withUser()
            ->withGame()
            ->orderBy("$this->table.updated_at", "DESC");

        $accounts = $accounts->findAll($limit, $offset);
        $accounts = $this->serialize($accounts);

        return $accounts;
    }

    public function findAccountById(int|string $id,  array $options = ["withUser" => true, "withGame" => true, "withParseGameCreator" => true]): array|\stdClass|null
    {

        $account = $this->select("$this->table.*")->where("$this->table.id", $id);
        if (!empty($options['withUser']) && $options['withUser'] == true) $account = $account->withUser();
        if (!empty($options['withGame']) && $options['withGame'] == true) {
            (!empty($options['withParseGameCreator']) && $options['withParseGameCreator'] == true)
                ? $account = $account->withGame(null, $options['withParseGameCreator'])
                : $account = $account->withGame();
        }

        $account = $account->first();
        $account = $this->serialize($account);

        return $account;
    }

    public function findAccountsByUser(int|string $userId, int $limit = 0, int $offset = 0, array $options = ["withUser" => true, "withGame" => true, "withParseGameCreator" => true]): array|\stdClass|null
    {

        $account = $this->select("$this->table.*")->where("$this->table.user", $userId);
        if (!empty($options['withUser']) && $options['withUser'] == true) $account = $account->withUser();
        if (!empty($options['withGame']) && $options['withGame'] == true) {
            (!empty($options['withParseGameCreator']) && $options['withParseGameCreator'] == true)
                ? $account = $account->withGame(null, $options['withParseGameCreator'])
                : $account = $account->withGame();
        }

        $account = $account->findAll($limit, $offset);
        $account = $this->serialize($account);

        return $account;
    }

    public function findAccountsByUserAndGame(int|string $userId, int|string $gameId, int $limit = 0, int $offset = 0, array $options = ["withUser" => true, "withGame" => true, "withParseGameCreator" => true]): array|\stdClass|null
    {

        $account = $this->select("$this->table.*")
            ->where("$this->table.game", $gameId)
            ->where("$this->table.user", $userId);
        if (!empty($options['withUser']) && $options['withUser'] == true) $account = $account->withUser();
        if (!empty($options['withGame']) && $options['withGame'] == true) {
            (!empty($options['withParseGameCreator']) && $options['withParseGameCreator'] == true)
                ? $account = $account->withGame(null, $options['withParseGameCreator'])
                : $account = $account->withGame();
        }

        $account = $account->findAll($limit, $offset);
        $account = $this->serialize($account);

        return $account;
    }

    public function findAccountByIdentity(int|string $identity, int|string $gameCodeOrId = null,  array $options = ["gameType" => "code", "withUser" => true, "withGame" => true, "withParseGameCreator" => true]): array|\stdClass|null
    {
        $account = $this->select("$this->table.*")->where("$this->table.identity", $identity);
        if (!empty($options['withUser']) && $options['withUser'] == true) $account = $account->withUser();
        if (!empty($options['withGame']) && $options['withGame'] == true) {
            (!empty($options['withParseGameCreator']) && $options['withParseGameCreator'] == true)
                ? $account = $account->withGame($gameCodeOrId, $options['gameType'], $options['withParseGameCreator'])
                : $account = $account->withGame($gameCodeOrId, $options['gameType']);
        }

        $account = $account->first();
        $account = $this->serialize($account);

        return $account;
    }


    /**
     * Add new Game Account
     *
     * @param array $accountData
     * @return integer|boolean
     */
    public function addAccount(array $accountData): int|bool
    {
        try {
            return $this->insert($accountData, true);
        } catch (\Throwable $th) {
            dd($th);
            return false;
        }
    }

    public function updateAccount(string|int $accountId, array|\stdClass $accountData): bool
    {
        try {
            return $this->update($accountId, $accountData);
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function deleteAccount(string|int $accountId): bool
    {
        try {
            return $this->delete($accountId);
        } catch (\Throwable $th) {
            return false;
        }
    }

    public static function getConfigName(string $configName = null): string|array
    {
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


    public function withUser()
    {
        $userTable = UserModel::getConfigName('tableName');
        $userPK = UserModel::getConfigName('primaryKey');
        $maper = $this->modelMapper(UserModel::class, "{$this->tableSingular}_user");

        return $this->select($maper)->join($userTable, "$this->table.user = $userTable.$userPK", "left");
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
            $creatorPK = UserModel::getConfigName('primaryKey');
            $gameCreatorMaped = $this->modelMapper(UserModel::class, "{$this->tableSingular}_{$gameTableSingular}_{$creatorTableSingular}");

            $game = $game->select($gameCreatorMaped)
                ->join("$creatorTable AS game_creator", "$gameTable.creator = game_creator.$creatorPK", "left");
        }

        return $game;
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

        if (gettype($data) == "array") {
            $accounts = array_map(fn ($account) => $this->serialize($account), $data);
            return $accounts;
        }

        $account = [];
        foreach ($data as $accountKey => $accountVal) {
            $childUser = "/{$this->tableSingular}_{$userTable}_/";
            $childGame = "/{$this->tableSingular}_{$gameTable}_/";
            $childGameCreator = "/{$this->tableSingular}_{$gameTable}_{$userTable}_/";

            if (preg_match($childGameCreator, $accountKey)) {
                $prefixName = 'creator';
                $prefixKey = preg_replace($childGameCreator, "", $accountKey);
                if (empty($account[$gameTable][$prefixName]) || !is_array($account[$gameTable][$prefixName])) {
                    $account[$gameTable][$prefixName] = [];
                    $account[$gameTable][$prefixName][$prefixKey] = $this->serializeType($accountVal);
                } else {
                    $account[$gameTable][$prefixName][$prefixKey] = $this->serializeType($accountVal);
                }
                continue;
            } else if (preg_match($childGame, $accountKey)) {
                $prefixKey = preg_replace($childGame, "", $accountKey);
                if (!is_array($account[$gameTable])) {
                    $account[$gameTable] = [];
                    $account[$gameTable][$prefixKey] = $this->serializeType($accountVal);
                } else {
                    $account[$gameTable][$prefixKey] = $this->serializeType($accountVal);
                }
                continue;
            } else if (preg_match($childUser, $accountKey)) {
                $prefixKey = preg_replace($childUser, "", $accountKey);
                if (!is_array($account[$userTable])) {
                    $account[$userTable] = [];
                    $account[$userTable][$prefixKey] = $this->serializeType($accountVal);
                } else {
                    $account[$userTable][$prefixKey] = $this->serializeType($accountVal);
                }
                continue;
            }

            $account[$accountKey] = $this->serializeType($accountVal);
        }


        return to_object($account);
    }

    private function serializeType(mixed $data): mixed
    {
        if (is_numeric($data)) return intval($data);
        if (is_bool($data)) return boolval($data);
        if (is_string($data)) return strval($data);

        return $data;
    }
}
