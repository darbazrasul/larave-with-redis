<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Cache;
use App\http\Controllers\RedisLearingController;

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


Route::get('/learn-redis', [RedisLearingController::class, 'index']);
Route::post('/learn-redis/store', [RedisLearingController::class, 'store']);
Route::get('/learn-redis/get/{key}', [RedisLearingController::class, 'get']);
Route::get('/learn-redis/all', [RedisLearingController::class, 'allKeys']);
Route::delete('/learn-redis/delete/{key}', [RedisLearingController::class, 'delete']);
Route::get('/learn-redis/exists/{key}', [RedisLearingController::class, 'exists']);
?>