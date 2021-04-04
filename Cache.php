<?php

/**
 * This assumes that there is a model class CacheData where it has the following columns:
 * id(Integer, unique, increments) , user_id(Integer, unique), json_data(String), time(Integer), endpoint(String).
 * This also assumes that this uses Laravel as framework
 * Class Cache
 */
class Cache
{
    /**
     * This function saves the cache data
     * @param Request $request
     * @return mixed
     */
    public function saveCache(Request $request)
    {
        $newCache               = new CacheData();
        $newCache->user_id      = $request->user_id;
        $newCache->endpoint     = $request->endpoint;
        $newCache->json_data    = json_encode($request->json_data);
        $newCache->time         = $request->time ? $request->time : 60000;
        $newCache->save();

        return response()->json($newCache);
    }

    /**
     * This function is to retrieve cached data for a user
     * @param $user_id
     * @return mixed
     */
    public function retrieveCache($user_id)
    {
        $hasCache = CacheData::where('user_id', $user_id)->get();

        if(empty($hasCache)){
            return response()->json(['code' => 404, 'message' => 'No cache data for user']);
        }

        return response()->json($hasCache);
    }

    /**
     * This function is called from a cronjob to run every second to check and delete cache data.
     */
    public function maintainCacheData()
    {
        $cacheData = CacheData::all();

        foreach($cacheData as $data){
            usleep($data->time);
            $data->delete();
        }
    }




}