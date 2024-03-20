<?php

namespace App\Traits\Models;

use Illuminate\Database\Eloquent\Model;

use function Laravel\Prompts\select;

trait HasSlug
{
    protected static function bootHasSlug(): void
    {
        static::creating(function (Model $item) {
            $item->makeSlug();
        });
//
//        static::creating(function (Model $item) {
//            $item->slug = $item->slug
//                ?? str($item->{self::slugFrom()})
//                    ->append(time())
//                    ->slug();
//        });
    }

    public  function makeSlug(): void
    {
        if(!$this->{$this->slugColumn()}){
            $slug = $this->slugUnique(
                str($this->{$this->slugFrom()})
                    ->slug()
                    ->value()
            );
        }

        $this->{$this->slugColumn()} = $slug;
    }

    protected function slugFrom(): string
    {
        return 'title';
    }

    protected function slugColumn(): string
    {
        return 'slug';
    }

    private function slugUnique(string $slug): string
    {
        $originalSlug = $slug;
        $i = 0;

        while ($this->isSlugExist($slug)) {
            $i++;
            $slug = $originalSlug.'-'.$i;

        }

        return $slug;
    }

    private function isSlugExist(string $slug): bool
    {
        $query = $this->newQuery()
            ->where(self::slugColumn(), $slug)
            ->withoutGlobalScopes();

        return $query->exists();
    }

}
