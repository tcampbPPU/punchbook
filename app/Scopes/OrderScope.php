<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

/**
 * @template TModelClass of Model
 */
class OrderScope implements Scope
{
    private string $column;

    private string $direction;

    private ?string $columnSecondary;

    private string $directionSecondary;

    /**
     * OrderScope constructor.
     */
    public function __construct(
        string $column = 'updated_at',
        string $direction = 'desc',
        string $columnSecondary = null,
        string $directionSecondary = 'desc'
    ) {
        $this->column = $column;
        $this->direction = $direction;
        $this->columnSecondary = $columnSecondary;
        $this->directionSecondary = $directionSecondary;
    }

    /**
     * Apply or sorting to the builder
     *
     * @param  Builder<TModelClass>  $builder
     */
    public function apply(Builder $builder, Model $model)
    {
        $builder->orderBy($this->column, $this->direction);

        if ($this->columnSecondary !== null) {
            $builder->orderBy($this->columnSecondary, $this->directionSecondary);
        }
    }
}
