<?php
namespace SingleQuote\Cacher\Traits;

use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Builder;

trait Cacher
{
    /**
     * 
     * @param type $query
     * @param int $ttl | default 1 week
     * @return \Illuminate\Contracts\Cache\Repository
     */
    public function scopeRemember(Builder $query, int $ttl = 86400*7)
    {
        return Cache::remember(md5($query->toSql()), $ttl, function() use($query){
            return $query->get();
        });
    }
    
    /**
     * 
     * @param type $query
     * @return \Illuminate\Contracts\Cache\Repository
     */
    public function scopeRememberForever(Builder $query)
    {
        return Cache::rememberForever(md5($query->toSql()), function() use($query){
            return $query->get();
        });
    }
}
