<?php
namespace SingleQuote\Cacher\Traits;

use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Builder;

trait Cacher
{
    protected $prefix;
    
    /**
     * 
     * @param \Illuminate\Database\Query\Builder $builder
     * @param int                                $ttl | default 1 week
     * @return \Illuminate\Contracts\Cache\Repository
     */
    public function scopeRemember(Builder $builder, int $ttl = 86400*7)
    {
        return Cache::remember($this->prefix($builder), $ttl, function() use($builder){
            return $builder->get();
        });
    }
        
    /**
     * 
     * @param \Illuminate\Database\Query\Builder $builder
     * @return \Illuminate\Contracts\Cache\Repository
     */
    public function scopeRememberForever(Builder $builder)
    {
        return Cache::rememberForever($this->prefix($builder), function() use($builder){
            return $builder->get();
        });
    }
    
    /**
     * 
     * @param \Illuminate\Database\Query\Builder $builder
     * @param mixed                              $find
     * @param int                                $ttl | default 1 week
     * @return \Illuminate\Contracts\Cache\Repository
     */
    public function scopeFindAndRemember(Builder $builder, $find, int $ttl = 86400*7)
    {
        return Cache::remember($this->prefix($builder), $ttl, function() use($builder, $find){
            return $builder->find($find);
        });
    }
    
    /**
     * 
     * @param \Illuminate\Database\Query\Builder $builder
     * @param mixed                              $find
     * @return \Illuminate\Contracts\Cache\Repository
     */
    public function scopeFindAndRememberForever(Builder $builder, $find)
    {
        return Cache::rememberForever($this->prefix($builder), function() use($builder, $find){
            return $builder->find($find);
        });
    }
    
    /**
     * 
     * @param \Illuminate\Database\Query\Builder $builder
     * @param int                                $ttl | default 1 week
     * @return \Illuminate\Contracts\Cache\Repository
     */
    public function scopeFirstAndRemember(Builder $builder, int $ttl = 86400*7)
    {
        return Cache::remember($this->prefix($builder), $ttl, function() use($builder, $find){
            return $builder->first($find);
        });
    }
        
    /**
     * 
     * @param \Illuminate\Database\Query\Builder $builder
     * @return \Illuminate\Contracts\Cache\Repository
     */
    public function scopeFirstAndRememberForever(Builder $builder)
    {
        return Cache::rememberForever($this->prefix($builder), function() use($builder, $find){
            return $builder->first($find);
        });
    }
    
    /**
     * Set the prefix for the cacher
     * 
     * @param Builder $builder
     * @param string $prefix
     * @return Builder
     */
    public function scopePrefix(Builder $builder, string $prefix)
    {
        $this->prefix = $prefix;
        
        return $builder;
    }
    
    /**
     * Get the prefix for the cache file
     * 
     * @param \Illuminate\Database\Query\Builder $builder
     * @return string
     */
    private function prefix(Builder $builder) : string
    {
        if($this->prefix){
            return $this->prefix;
        }
        
        $queryString = str_replace(array('?'), array('\'%s\''), $builder->toSql());
        
        return md5(vsprintf($queryString, $builder->getBindings()));
    }

}
