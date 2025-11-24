<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Symfony\Component\HttpFoundation\Response;

class RedisLearingController extends Controller
{
    
    public function index()
    {
        return view('redis-learning');
    }
    
    
    public function store(Request $request)
    {
        $key = $request->input('key');
        $value = $request->input('value');
        
        Redis::set($key, $value);
        
        return response()->json([
            'success' => true,
            'message' => "✅ Stored: {$key} = {$value}"
        ]);
    }
    
    
    public function get($key)
    {
        $value = Redis::get($key);
        
        if ($value === null) {
            return response()->json([
                'success' => false,
                'message' => "❌ Key '{$key}' not found"
            ]);
        }
        
        return response()->json([
            'success' => true,
            'key' => $key,
            'value' => $value
        ]);
    }
    
    
    public function allKeys()
    {
        $keys = Redis::keys('*');
        $data = [];
        
        foreach ($keys as $key) {
            $data[$key] = Redis::get($key);
        }
        
        return response()->json([
            'success' => true,
            'count' => count($data),
            'data' => $data
        ]);
    }
    
    
    public function delete($key)
    {
        Redis::del($key);
        
        return response()->json([
            'success' => true,
            'message' => "🗑️ Deleted: {$key}"
        ]);
    }
    
    
    public function exists($key)
    {
        $exists = Redis::exists($key);
        
        return response()->json([
            'success' => true,
            'exists' => (bool)$exists,
            'message' => $exists ? "✅ Key exists" : "❌ Key does not exist"
        ]);
    }
}