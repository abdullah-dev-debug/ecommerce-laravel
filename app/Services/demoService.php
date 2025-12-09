<?php

namespace App\Services;

use App\Models\Ads;
use App\Services\BaseService;
use App\Utils\AppUtils;

class AdsService extends BaseService
{
    protected const CACHE_KEY = "ads_cache";
    protected const MSG_NOT_FOUND = "Ads Not Found!";
    protected const MSG_ENABLED_ADS = "Ads Enabled Successfully";
    protected const MSG_DISABLED_ADS = "Ads Disabled Successfully";
    protected const PAGE_QUERY_PARAMETER = "perPage";
    public function __construct(Ads $ads, AppUtils $appUtils)
    {
        parent::__construct($ads, self::MSG_NOT_FOUND, $appUtils);
    }
    public function createAds(array $data)
    {
        return parent::create($data, self::CACHE_KEY);
    }
    public function getPaginatedCacheAds()
    {
        return parent::getPaginatedCacheItem(self::PAGE_QUERY_PARAMETER, self::CACHE_KEY, 60, [], ['title']);
    }
    public function getSingleAds(int $id, array $relation = [])
    {
        return parent::getSingleItem($id, $relation);
    }
    public function deleteAds(int $id, $filePath = null)
    {
        return parent::destroy($id, self::CACHE_KEY, $filePath);
    }
    public function updateAds(array $data, int $id, $filePath = null)
    {
        return parent::update($data, $id, self::CACHE_KEY, $filePath);
    }
    public function updateStatusAds(int $id, $currentStatus)
    {
        return parent::toggleStatus($id, $currentStatus, self::MSG_DISABLED_ADS, self::MSG_ENABLED_ADS);
    }
}
