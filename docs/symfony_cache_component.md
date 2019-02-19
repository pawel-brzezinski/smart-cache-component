# SmartCache component

## Symfony Cache Component
[Symfony Cache Component](https://github.com/symfony/cache) provides PSR-6 and PSR-16 cache implementation for applications. SmartCache component support only PSR-16 implementation. 
For more inforaction visit the [Symfony Cache Component](https://symfony.com/doc/current/components/cache.html) documentation.

### Example
Create Symfony cache instance by usinging one of available adapters:
```
use Symfony\Component\Cache\Adapter\NullAdapter;

$adapter = new NullAdapter();
```
Now you can create SmartCache cache item pool instance:
```
use PB\Component\Cache\CacheItemPool\SymfonyCacheItemPool;

$cache = new SymfonyCacheItemPool($cache);
```
Save data to cache
```
$cacheKey = 'foo';
$content = 'Lorem Ipsum';

$cacheItem = $cache->getItem($cacheKey);
$cacheItem->set($content);

$cache->save($cacheItem);
```

### Cache tags
To use tags features you should use Symfony `TagAwareAdapterInterface`. For more info check the [documentation](https://symfony.com/doc/current/components/cache/cache_invalidation.html#cache-component-tags).
