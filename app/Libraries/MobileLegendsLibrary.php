<?php

namespace App\Libraries;

use CodeIgniter\HTTP\CURLRequest;
use Config\Services;

/**
 * The library for scraping hero data on the Mobile Legends mobile game.
 * Based on known endpoints at https://mapi.mobilelegends.com/
 *
 * @package \App\Libraries\MobileLegendsLibrary
 * @version 1.0.0
 * @since 2023-12-03
 *
 * @example
 * $mobileLegends = new \App\Libraries\MobileLegendsLibrary();
 * $heroList = $mobileLegends->getHero();
 * $heroDetail = $mobileLegends->getHero(1, 'object');
 * var_dump($heroList[1]);
 * var_dump($heroDetail->name);
 * 
 * @author Fiki Pratama (nsmle) <fikiproductionofficial@gmail.com>
 * @author PWL Team Group 23 (biteteam)
 * @copyright Copyright (c) 2023
 * 
 * @see https://github.com/biteteam/mabar.in/blob/master/app/Libraries/MobileLegendsLibrary.php
 * @see https://github.com/bitecore/mabar.in/blob/master/app/Libraries/MobileLegendsLibrary.php
 * @see https://github.com/nsmle/mabar.in/blob/master/app/Libraries/MobileLegendsLibrary.php
 */
class MobileLegendsLibrary
{
    /**
     * @var \CodeIgniter\HTTP\CURLRequest
     */
    protected CURLRequest $http;

    /**
     * Initialize Http Client
     *
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        $options['verify']  = false;
        $options['headers'] = array_merge([
            'Accept'          => 'application/json',
            'Accept-Language' => 'id,en-US;q=0.9,en;q=0.8,ko;q=0.7,th;q=0.6,nso;q=0.5,zh-CN;q=0.4,zh-TW;q=0.3,zh;q=0.2',
            'User-Agent'      => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/119.0.0.0 Safari/537.36'
        ], isset($options['headers']) ? $options['headers'] : []);

        $this->http = Services::curlrequest($options);
    }

    /**
     * Get Hero List / Get Hero By Id
     *
     * @param integer|string|null $heroId
     * @param string|null $returnType Acceptable values are 'array', 'object', 'json', or null.
     * 
     * @return array|\stdClass
     */
    public function getHero(int|string $heroId = null, ?string $returnType = 'array', bool $withDetail = false): array|\stdClass
    {
        $uri = 'https://mapi.mobilelegends.com/hero/list';
        if (!empty($heroId)) $uri = "https://mapi.mobilelegends.com/hero/detail?id=$heroId";

        // $cacheName = base64_encode($uri);
        $cacheName = preg_replace("/\/|\?/", "-", preg_replace("/https:\/\//", "", $uri));

        $body = cache($cacheName);
        if (empty($body)) {
            log_message('info', "Scrape mobile legegends " . !empty($heroId) ? "on hero id $heroId" : "all hero" . ", because cache not found on $uri");
            $response = $this->http->get($uri);
            $body = json_decode($response->getBody(), true);

            cache()->save($cacheName, $body, 2592000);
        }

        if (empty($heroId) && $withDetail) {
            foreach ($body['data'] as $index => $hero) {
                $heroDetailCacheName = preg_replace("/\/|\?/", "-", preg_replace("/https:\/\//", "", "https://mapi.mobilelegends.com/hero/detail?id={$hero['heroid']}"));
                $heroDetailCached = cache($heroDetailCacheName);

                $withDetailCachedData = [];
                if (!empty($heroDetailCached)) $withDetailCachedData['detail'] = $heroDetailCached['data'];

                $body['data'][$index] = array_merge($hero, $withDetailCachedData);
            }

            cache()->save($cacheName, $body, 2592000);
        }

        $data =  empty($heroId) ? $this->serializeHero($body['data']) : $this->serializeHeroDetail($body['data']);
        if (empty($heroId)) usort($data, function ($prevHero, $nextHero) {
            return intval($prevHero['id']) - intval($nextHero['id']);
        });

        if (!empty($returnType)) {
            if ($returnType == "json") return json_encode($body['data']);
            if ($returnType == "object") return to_object($data);
        }

        return $data;
    }

    /**
     * Serialize Hero Data on List
     *
     * @param array $heroes
     * @return array
     */
    protected function serializeHero(array $heroes): array
    {
        return array_map(function ($hero) {
            $data = [
                'id'    => $this->validate($hero, 'heroid'),
                'name'  => $this->validate($hero, 'name'),
                'image' => preg_replace('/^\/\//', 'https://', $this->validate($hero, 'key'))
            ];

            if (!empty($hero['detail']))
                $data['detail'] = $this->serializeHeroDetail($hero['detail']);

            return $data;
        }, $heroes);
    }

    /**
     * Serialize Detail of Hero
     *
     * @param array $heroData
     * @return array
     */
    protected function serializeHeroDetail(array $heroData): array
    {
        return [
            'name'        => $this->validate($heroData, 'name'),
            'role'        => $this->validate($heroData, 'type'),
            'description' => $this->validate($heroData, 'des'),
            'phy'         => $this->validate($heroData, 'phy'),
            'mag'         => $this->validate($heroData, 'mag'),
            'alive'       => $this->validate($heroData, 'alive'),
            'diff'        => $this->validate($heroData, 'diff'),
            'junling'     => $this->validate($heroData, 'junling'),
            'cost'        => $this->validate($heroData, 'cost'),
            'image'       => $this->validate($heroData, 'cover_picture'),
            'skill'       => $this->serializeHeroSkill($this->validate($heroData, 'skill')),
            'gear'        => $this->serializeHeroGear($this->validate($heroData, 'gear')),
            'counters'    => $this->serializeHeroCounter($this->validate($heroData, 'counters'))

        ];
    }

    /**
     * Serialize Skills of Hero on Detail Hero
     *
     * @param array|null $skillsData
     * @return array|null
     */
    protected function serializeHeroSkill(array|null $skillsData): array|null
    {
        if ($skillsData == null) return $skillsData;

        $skills = $this->validate($skillsData, 'skill');
        $skills = !empty($skills) ? array_map(function ($skill) {
            return [
                'name'        => $this->validate($skill, 'name'),
                'image'       => $this->validate($skill, 'icon'),
                'description' => $this->validate($skill, 'des'),
                'tips'        => $this->validate($skill, 'tips'),
            ];
        }, $skillsData['skill']) : [];

        $formattedSkillItem = [];
        $skillItems = $this->validate($skillsData, 'item');
        foreach ($skillItems as $itemKey => $itemVal) {
            if (empty($itemVal['icon'])) {
                $formattedSkillItem[$itemKey] = $itemVal;
                continue;
            }
            $iconKey = $itemVal['icon'];
            $formatted = array_filter($skills, function ($skill) use ($iconKey) {
                return $skill['image'] == $iconKey;
            });

            if (count($formatted) >= 1) $formattedSkillItem[$itemKey] = reset($formatted);
        }

        return [
            'list' => $skills,
            'item' => $formattedSkillItem
        ];
    }

    /**
     * Serialize Gear of Hero on Detail Hero
     *
     * @param array|null $gearData
     * @return array|null
     */
    protected function serializeHeroGear(array|null $gearData): array|null
    {
        if ($gearData == null) return $gearData;

        $outpack = $this->validate($gearData, 'out_pack');
        if (!empty($outpack) && is_array($outpack)) $outpack = array_map(function ($pack) {
            $equipmentData = $this->validate($pack, 'equip');
            return [
                'id'          => $this->validate($pack, 'equipment_id'),
                'name'        => !empty($equipmentData) ? $this->validate($equipmentData, 'name') : null,
                'image'       => !empty($equipmentData) ? $this->validate($equipmentData, 'icon') : null,
                'description' => !empty($equipmentData) ? $this->validate($equipmentData, 'des') : null,
            ];
        }, $outpack);

        return [
            'pack'    => $outpack,
            'tips'    => $this->validate($gearData, 'out_pack_tips'),
            'verysix'    => $this->validate($gearData, 'verysix')
        ];
    }

    /**
     * Serialize Hero Counters on Detail Hero
     *
     * @param array|null $countersData
     * @return array|null
     */
    protected function serializeHeroCounter(array|null $countersData): array|null
    {
        if ($countersData == null) return $countersData;

        $counters = [];
        foreach ($countersData as $counterKey => $counterVal) {
            $counters[$counterKey] = [
                'id'    => $this->validate($counterVal, 'heroid'),
                'name'  => $this->validate($counterVal, 'name'),
                'image' => $this->validate($counterVal, 'icon'),
                'tips'  => $this->validate($counterVal, 'by_restrain_tips')
                    ?? $this->validate($counterVal, 'restrain_hero_tips')
                    ?? $this->validate($counterVal, 'best_mate_tips'),
            ];
        }

        return $counters;
    }

    /**
     * Validate the Key of Hero Data from HttpResponse
     * Returning data with formatted value
     *
     * @param array $data
     * @param string $key
     * @return mixed
     */
    private function validate(array $data, string $key): mixed
    {
        if (isset($data[$key]) && $data[$key] !== '') {
            if (is_numeric($data[$key])) return intval($data[$key]);
            if (is_bool($data[$key])) return boolval($data[$key]);
            if (is_string($data[$key])) return preg_replace('/^\/\//', 'https://', strval($data[$key]));

            return $data[$key];
        };

        return null;
    }
}
