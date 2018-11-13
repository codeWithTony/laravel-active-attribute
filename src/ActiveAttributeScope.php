<?php namespace CodeWithTony;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class ActiveAttributeScope implements Scope
{
    protected $extensions = ['WithInactive', 'WithoutInactive', 'OnlyInactive'];

    public function apply(Builder $builder, Model $model)
    {
        $builder->where($model->getQualifiedActiveColumn(), 1);
    }

    public function extend(Builder $builder)
    {
        foreach ($this->extensions as $extension) {
            $this->{"add{$extension}"}($builder);
        }
    }

    protected function getActiveColumn(Builder $builder)
    {
        if (count((array) $builder->getQuery()->joins) > 0) {
            return $builder->getModel()->getQualifiedActiveColumn();
        }

        return $builder->getModel()->getActiveColumn();
    }

    protected function addWithInactive(Builder $builder)
    {
        $builder->macro('withInactive', function (Builder $builder, $withInactive = true) {
            if (! $withInactive) {
                return $builder->withoutInactive();
            }

            return $builder->withoutGlobalScope($this);
        });
    }

    protected function addWithoutInactive(Builder $builder)
    {
        $builder->macro('withoutInactive', function (Builder $builder) {
            $model = $builder->getModel();

            $builder->withoutGlobalScope($this)->where(
                $model->getQualifiedActiveColumn(),
                1
            );

            return $builder;
        });
    }

    protected function addOnlyInactive(Builder $builder)
    {
        $builder->macro('onlyInactive', function (Builder $builder) {
            $model = $builder->getModel();

            $builder->withoutGlobalScope($this)->where(
                $model->getQualifiedActiveColumn(),
                0
            );

            return $builder;
        });
    }

}