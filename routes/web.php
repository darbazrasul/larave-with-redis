<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Cache;

Route::get('/redis-test', function () {
    // Test Redis
    Redis::set('test_key', 'Hello from Redis!');
    $value = Redis::get('test_key');
    
    // Test Cache
    Cache::put('cached_data', 'Laravel Cache Works!', 60);
    $cached = Cache::get('cached_data');
    
    return response()->json([
        'redis_direct' => $value,
        'cache_data' => $cached,
        'status' => 'Redis is working! 🎉'
    ]);
});

?>