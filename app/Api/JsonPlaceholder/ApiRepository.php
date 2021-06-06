<?php

namespace App\Api\JsonPlaceholder;

use PDOException;
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
    // Cache implementation should be moved to other class
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

        $data = $this->client->all($this->resource);

        if ($this->shouldCache()) {
            $this->cache($data);
        }

        return $data;
    }

    /**
     * Find a resource by id.
     */
    public function find(int $id): array
    {
        if ($this->shouldGetFromCache()) {
            return $this->getFromCache($id);
        }

        $data = $this->client->find($this->resource, $id);

        if ($this->shouldCache()) {
            $this->cache($data);
        }

        return $data;
    }

    /**
     * Set the related resource.
     */
    public function related(int $id): self
    {
        $this->client->fromRelation($this->resource, $id);

        return $this;
    }

    /**
     * Check whether we should cache the response.
     */
    private function shouldCache()
    {
        return $this->cacheMinutes > 0;
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

        return tap(($seconds / 60) <= $this->cacheMinutes, function (bool $should) {
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
            $data = $data->map(fn ($record) => $this->parseRecord($record))->toArray();
        } else {
            $data = $this->parseRecord($data);
        }

        try {
            DB::beginTransaction();

            return tap(DB::table($this->resource)->insert($data), fn () => DB::commit());
        } catch (PDOException $e) {
            DB::rollback();

            return false;
        }
    }

    /**
     * Parse a givne record to cache.
     */
    private function parseRecord(array $record): array
    {
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
    }

    /**
     * Invalidate the current cache
     */
    private function invalidateCache()
    {
        if ($mysql = config('database.default') === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0');
        }

        return tap(DB::table($this->resource)->truncate(), function () use ($mysql) {
            if ($mysql) {
                DB::statement('SET FOREIGN_KEY_CHECKS=1');
            }
        });
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

        return (array) $builder->where('id', $id)->first();
    }
}
