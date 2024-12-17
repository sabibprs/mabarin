<?php

namespace App\Models;

use App\Libraries\MobileLegendsLibrary;
use CodeIgniter\Database\BaseResult;
use CodeIgniter\Model;
use Error;
use PhpParser\Node\Stmt\TryCatch;


enum HeroScraper: string
{
    case MOBILE_LEGENDS = 'mobile-legends';
    case PUBG_MOBILE = 'pubg-mobile';
}

class GameModel extends Model
{
    public static array $availableScraper = [HeroScraper::MOBILE_LEGENDS->value, HeroScraper::PUBG_MOBILE->value];
    public static string $defaultScrapper = HeroScraper::MOBILE_LEGENDS->value;

    protected $table            = 'games';
    protected $tableSingular    = 'game';

    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['code', 'creator', 'name', 'description', 'image', 'max_player', 'is_verified'];

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

    public function findAllGame(int $limit = 0, int $offset = 0, array $options = ['isVerifiedOnly' => false, 'isVerified' => null])
    {
        $allGames = $this->select("$this->table.*")
            ->withAccountsCount()
            ->withCreator()
            ->orderBy("{$this->table}.is_verified", "DESC")
            ->orderBy("{$this->table}.updated_at", "DESC");

        if (isset($options['isVerifiedOnly']) && $options['isVerifiedOnly']) $allGames = $allGames->where('is_verified', true);
        if (isset($options['isVerified']) && gettype($options['isVerified']) == 'boolean') $allGames = $allGames->where('is_verified', $options['isVerified']);

        $allGames = $allGames->findAll($limit, $offset);
        return $this->serialize($allGames);
    }

    public function findGameByUserId(string|int $userId, int $limit = 0, int $offset = 0)
    {
        $allGames = $this->select("{$this->table}.*")
            ->where("$this->table.creator", $userId)
            ->withAccountsCount()
            ->withCreator()
            ->orderBy("{$this->table}.is_verified", "ASC")
            ->orderBy("{$this->table}.updated_at", "DESC")
            ->findAll($limit, $offset);

        return $this->serialize($allGames);
    }

    public function findGameByCode(string $gameCode): \stdClass|null
    {
        $userTable = UserModel::getConfigName('tableName');
        $userPK = UserModel::getConfigName('primaryKey');

        $this->where('code', $gameCode)
            ->select("{$this->table}.*")
            ->withAccountsCount()
            ->withCreator()
            ->orderBy("{$this->table}.updated_at", "DESC");

        return $this->serialize($this->first());
    }

    public function updateGame(string|int $gameId, array $gameData): bool
    {
        try {
            return $this->update($gameId, $gameData);
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function deleteGame(string|int $gameId): BaseResult|bool
    {
        try {
            return $this->delete($gameId);
        } catch (\Throwable $th) {
            return false;
        }
    }

    /**
     * Add new Game
     *
     * @param array $gameData
     * @return integer|boolean
     */
    public function addGame(array $gameData): int|bool
    {
        try {
            return $this->insert($gameData, true);
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function withCreator()
    {
        $userTable = UserModel::getConfigName('tableName');
        $userPK = UserModel::getConfigName('primaryKey');
        $maper = $this->modelMapper(UserModel::class, "{$this->tableSingular}_creator");

        return $this->select($maper)->join($userTable, "$this->table.creator = $userTable.$userPK", "left");
    }

    public function withAccountsCount()
    {
        $accountTable = GameAccountModel::getConfigName('tableName');
        $accountPK  = GameAccountModel::getConfigName('primaryKey');
        $accountFK = "game";
        $accountCountAlias = "total_accounts";

        $this->select("COUNT($accountTable.$accountPK) AS $accountCountAlias")
            ->join($accountTable, "$this->table.$this->primaryKey = $accountTable.$accountFK", 'left')
            ->groupBy("$this->table.id");

        return $this;
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
        $userTable = UserModel::getConfigName("tableName");
        $prefixUserTable = 'creator';

        if (gettype($data) == "array") {
            $games = array_map(fn ($game) => $this->serialize($game), $data);
            return $games;
        }

        $data = to_array($data);
        $game = [];
        foreach ($data as $gameKey => $gameVal) {
            $childCreator = "/{$this->tableSingular}_{$prefixUserTable}_/";

            if (preg_match($childCreator, $gameKey)) {
                $prefixKey = preg_replace($childCreator, "", $gameKey);
                if (!is_array($game[$prefixUserTable])) {
                    $game[$prefixUserTable] = [];
                    $game[$prefixUserTable][$prefixKey] = $this->serializeType($gameVal);
                } else {
                    $game[$prefixUserTable][$prefixKey] = $this->serializeType($gameVal);
                }
                continue;
            }

            $game[$gameKey] = $this->serializeType($gameVal);
        }

        return to_object($game);
    }

    private function serializeType(mixed $data): mixed
    {
        if (is_numeric($data)) return intval($data);
        if (is_bool($data)) return boolval($data);
        if (is_string($data)) return strval($data);

        return $data;
    }

    public static function getHeroScraper(string|null $gameCode = null)
    {
        switch ($gameCode) {
            case HeroScraper::MOBILE_LEGENDS->value:
                return new MobileLegendsLibrary();
            default:
                return null;
        }
    }

    public static function getHeroScraperName(object $heroScraperClass)
    {
        if ($heroScraperClass instanceof MobileLegendsLibrary) {
            return HeroScraper::MOBILE_LEGENDS->value;
        }

        return null;
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
}
