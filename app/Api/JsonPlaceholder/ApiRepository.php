<?php

namespace App\Api\JsonPlaceholder;

use Carbon\Carbon;
use RuntimeException;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

abstract class ApiRepository
{
    /**
     * The Api client
     */
    protected ApiClient $client;

    /**
     * The DatabaseApiCache client
     */
    // protected DatabaseApiCache $cache;

    /**
     * The cache minutes.
     */
    protected int $cacheMinutes = 0;

    /**
     * The resource
     */
    protected string $resource;

    /**
     * Create a new instance.
     */
    public function __construct(ApiClient $client)
    {
        $this->client = $client;
    }

    /**
     * Get all resources
     */
    public function all(): Collection
    {
        if ($this->shouldGetFromCache()) {
            return $this->getFromCache();
        }

        $this->invalidateCache();

        $data = $this->client->all($this->resource);

        if ($this->shouldCache()) {
            $this->cache($data);
        }

        return $data;
    }

    /**
     * Find a resource by id.
     */
    public function find(int $id)
    {
        return $this->client->find($this->resource, $id);
    }

    /**
     * Set the related resource.
     */
    public function related(int $id)
    {
        $this->client->fromRelation($this->resource, $id);

        return $this;
    }

    /**
     * Check whether we should cache the response.
     */
    private function shouldCache()
    {
        return $this->cacheMinutes > 0 || $this->cacheMinutes === -1 ;
    }

    /**
     * Check if should get from cache
     */
    private function shouldGetFromCache(): bool
    {
        if (! $this->shouldCache()) {
            return false;
        }

        $max = DB::table($this->resource)->max('updated_at');

        if (is_null($max)) {
            return false;
        }

        $seconds = Carbon::now()->diffInSeconds(new Carbon($max));

        return tap(($seconds * 60) <= $this->cacheMinutes, function (bool $should) {
            if ($should === false) {
                $this->invalidateCache();
            }
        });
    }

    /**
     * Cache the response
     */
    private function cache(Collection|array $data): bool
    {
        if (! $this->shouldCache()) {
            return false;
        }

        if ($data instanceof Collection) {
            $data = $data->map(function ($record) {
                foreach ($record as $key => $value) {
                    if (is_array($value)) {
                        unset($record[$key]);
                    }

                    if (Str::snake($key) !== $key) {
                        $record[Str::snake($key)] = $value;

                        unset($record[$key]);
                    }
                }

                $record['created_at'] = now();
                $record['updated_at'] = now();

                return $record;
            });
        } else {
            $data['created_at'] = now();
            $data['updated_at'] = now();
        }

        return DB::table($this->resource)->insert($data->toArray());
    }

    /**
     * Invalidate the current cache
     */
    private function invalidateCache()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        return tap(DB::table($this->resource)->truncate(), fn () => DB::statement('SET FOREIGN_KEY_CHECKS=1'));
    }

    /**
     * Get the resource from cache.
     */
    private function getFromCache($id = null): Collection|array
    {
        Log::info("Cache hit {$this->resource} {$id}");

        $builder = DB::table($this->resource);

        if (is_null($id)) {
            return $builder->get();
        }

        return $builder->where('id', $id)
            ->first()
            ->toArray();
    }
}
