# SmartCache component
The PSR-16 cache component that wraps other external cache libraries. It gives you the opportunity to easily change the cache library in your applications.

## Installation
Download SmartCache component via Composer:
```
composer require pawel-brzezinski/smart-cache-component
```

## Supported cache libraries
- [Symfony Cache Component](docs/symfony_cache_component.md)

## Cache tags
SmartCache component provides tagging methods for cache item and cache pool for libraries which support tagging.

### Example
**Tagging cache item**
```
$cacheItem1 = $cache->getItem('foo');
$cacheItem1->setTags(['tag1', 'tag2']);

$cacheItem2 = $cache->getItem('bar');
$cacheItem2->setTags(['tag2', 'tag3']);

$cache->save($cacheItem1);
$cache->save($cacheItem2);
```

**Invalidating cache by cache tags**
```
// All cache keys tagged by "tag2" tag will be invalidated
$cache->invalidateTags(['tag2']); 
```
