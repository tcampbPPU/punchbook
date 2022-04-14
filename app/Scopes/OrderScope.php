<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\{Builder, Model, Scope};

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
     * @param string $column
     * @param string $direction
     * @param string|null $columnSecondary
     * @param string $directionSecondary
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
     * @param Builder<TModelClass> $builder
     * @param Model $model
     */
    public function apply(Builder $builder, Model $model)
    {
        // @phpstan-ignore-next-line
        $builder->orderBy($this->column, $this->direction);

        if ($this->columnSecondary !== null) {
            // @phpstan-ignore-next-line
            $builder->orderBy($this->columnSecondary, $this->directionSecondary);
        }
    }
}
