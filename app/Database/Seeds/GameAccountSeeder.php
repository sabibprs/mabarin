<?php

namespace App\Database\Seeds;

use App\Models\GameAccountModel;
use CodeIgniter\Database\Seeder;
use Faker\Factory as FakerFactory;

class GameAccountSeeder extends Seeder
{
    protected int $seedCount = 20;

    public function run()
    {
        $faker =  FakerFactory::create('id_ID');
        $tableName = GameAccountModel::getConfigName("tableName");

        $randExist = ["identity" => [], 'zone_id' => []];
        $max = $this->seedCount;
        for ($i = 1; $i <= $max; $i++) {
            $identity = $faker->numberBetween(1000000000, 2147483647);
            $zoneId = $faker->numberBetween(100, 9999);
            if (in_array($identity, $randExist['identity']) || in_array($zoneId, $randExist['zone_id'])) {
                $max++;
                continue;
            }

            $randExist = array_merge($randExist, [
                'identity' => array_merge($randExist['identity'], [$identity]),
                'zone_id' => array_merge($randExist['zone_id'], [$zoneId])
            ]);

            $this->db->table($tableName)->insert([
                'user' => $faker->numberBetween(1, $this->seedCount),
                'game' => $faker->numberBetween(1, 2),
                'identity' => $identity,
                'identity_zone_id' => $zoneId,
                'status' => $faker->randomElement(GameAccountModel::$availableStatus),
            ]);
        }
    }
}
