<?php

namespace App\Models;

use CodeIgniter\Model;
use PhpParser\Node\Stmt\TryCatch;

class UserModel extends Model
{
    public static array $availableRole = ['user', 'admin'];
    public static string $defaultRole = 'user';
    public static string $superRole = 'admin';

    protected $table            = 'users';
    protected $tableSingular    = 'user';

    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['name', 'username', 'email', 'phone', 'photo', 'password', 'role'];

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

    /**
     * Register a new User
     *
     * @param string $name
     * @param string $username
     * @param string $email
     * @param string $password
     * @param string $role
     * @param string|null $phone
     * @param string|null $photo
     * @return mixed
     */
    public function registerUser(
        string $name,
        string $username,
        string $email,
        string $password,
        string $role = 'user',
        ?string $phone = null,
        ?string $photo = null
    ): int|bool {
        try {
            return $this->insert([
                'name'     => $name,
                'username' => $username,
                'email'    => $email,
                'phone'    => $phone ?? null,
                'photo'    => $photo ?? self::getDefaultAvatar($name),
                'password' => auth(true)->hashCreds($password),
                'role'     => $role,
            ], true);
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function find($id = null)
    {
        $this->select("$this->table.*");
        return parent::find($id);
    }

    public function findByUsernameOrEmail(int|string $usernameOrEmail, array $options = ['returning_model' => false])
    {
        $this->select("$this->table.*")
            ->where("$this->table.username", $usernameOrEmail)
            ->orWhere("$this->table.email", $usernameOrEmail);

        if (!empty($options['returning_model']) && $options['returning_model'] = true) return $this;
        return $this->first();
    }

    public function withTotalAccounts()
    {
        $accountTable = GameAccountModel::getConfigName('tableName');
        $accountPK = GameAccountModel::getConfigName('primaryKey');
        $accountFK = 'user';

        $this->select("COUNT($accountTable.$accountPK) total_accounts")
            ->join("$accountTable", "$accountTable.$accountFK = $this->table.$this->primaryKey", "LEFT")
            ->groupBy("$this->table.$this->primaryKey");
        return $this;
    }

    public function withTotalGames()
    {
        $gameTable = GameModel::getConfigName('tableName');
        $gamePK = GameModel::getConfigName('primaryKey');
        $gameFK = 'creator';

        $this->select("COUNT($gameTable.$gamePK) total_games")
            ->join("$gameTable", "$gameTable.$gameFK = $this->table.$this->primaryKey", "LEFT")
            ->groupBy("$this->table.$this->primaryKey");
        return $this;
    }

    public function withTotalTeams()
    {
        $teamTable = TeamModel::getConfigName('tableName');
        $teamPK = TeamModel::getConfigName('primaryKey');
        $teamFK = 'creator';

        $this->select("COUNT($teamTable.$teamPK) total_teams")
            ->join("$teamTable", "$teamTable.$teamFK = $this->table.$this->primaryKey", "LEFT")
            ->groupBy("$this->table.$this->primaryKey");
        return $this;
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

    public static function getAvatarAmikomA22(string $nim): string
    {
        $formattedUriNim = preg_replace("/\./i", "_", $nim);
        return "https://fotomhs.amikom.ac.id/2022/$formattedUriNim.jpg";
    }

    public static function getDefaultAvatar(string $name, string $color = "7F9CF5", string $background = "EBF4FF"): string
    {
        $initialName = initial_name($name, "+");
        return "https://ui-avatars.com/api?name=$initialName&color=$color&background=$background";
    }
}
