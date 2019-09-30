<?php
namespace SingleQuote\Cacher\Traits;

use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Builder;

trait Cacher
{
    /**
     * 
     * @param \Illuminate\Database\Query\Builder $builder
     * @param int $ttl | default 1 week
     * @return \Illuminate\Contracts\Cache\Repository
     */
    public function scopeRemember(Builder $builder, int $ttl = 86400*7)
    {
        $queryString = str_replace(array('?'), array('\'%s\''), $builder->toSql());
        $query = vsprintf($queryString, $builder->getBindings());
        return Cache::remember(md5($query), $ttl, function() use($builder){
            return $builder->get();
        });
    }
    
    /**
     * 
     * @param \Illuminate\Database\Query\Builder $builder
     * @param int $ttl | default 1 week
     * @return \Illuminate\Contracts\Cache\Repository
     */
    public function scopeFindAndRemember(Builder $builder, $find, int $ttl = 86400*7)
    {
        $queryString = str_replace(array('?'), array('\'%s\''), $builder->toSql());
        $query = vsprintf($queryString, $builder->getBindings());
        return Cache::remember(md5($query), $ttl, function() use($builder, $find){
            return $builder->find($find);
        });
    }
    
    /**
     * 
     * @param \Illuminate\Database\Query\Builder $builder
     * @return \Illuminate\Contracts\Cache\Repository
     */
    public function scopeRememberForever(Builder $builder)
    {
        $queryString = str_replace(array('?'), array('\'%s\''), $builder->toSql());
        $query = vsprintf($queryString, $builder->getBindings());
        return Cache::rememberForever(md5($query), function() use($builder){
            return $builder->get();
        });
    }
}
