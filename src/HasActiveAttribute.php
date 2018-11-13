<?php namespace CodeWithTony;

trait HasActiveAttribute
{
    /**
     * Boot the soft deleting trait for a model.
     *
     * @return void
     */
    public static function bootHasActiveAttribute()
    {
        static::addGlobalScope(new ActiveAttributeScope());
    }

    /**
     * Determine if the model instance has been soft-deleted.
     *
     * @return bool
     */
    public function is_active()
    {
        return $this->{$this->getActiveColumn()} == 1;
    }

    public function getActiveColumn()
    {
        return defined('static::ACTIVE') ? static::ACTIVE : 'active';
    }

    public function getQualifiedActiveColumn()
    {
        return $this->qualifyColumn($this->getActiveColumn());
    }
}
