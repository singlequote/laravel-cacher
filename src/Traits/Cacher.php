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
    public function scopeRemember(Builder $builder, int $ttl = 86400*7)
    {
        $query = str_replace(array('?'), array('\'%s\''), $builder->toSql());
        $query = vsprintf($query, $builder->getBindings());
        return Cache::remember(md5($query), $ttl, function() use($builder){
            return $builder->get();
        });
    }
    
    /**
     * 
     * @param type $query
     * @return \Illuminate\Contracts\Cache\Repository
     */
    public function scopeRememberForever(Builder $builder)
    {
        $query = str_replace(array('?'), array('\'%s\''), $builder->toSql());
        $query = vsprintf($query, $builder->getBindings());
        return Cache::rememberForever(md5($query), function() use($builder){
            return $builder->get();
        });
    }
}
