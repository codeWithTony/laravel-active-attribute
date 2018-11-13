# Laravel Active Attribute

Laravel Active Attribute adds `withInactive` and `onlyInactive` functionality to an Eloquent Model.

This can be used to automatically hide inactive records unless otherwise desired. A better solution might be the use [Soft Deletes](https://laravel.com/docs/5.5/eloquent#soft-deleting) but there are a number of reasons why you might want to use an active field.

This can also server as a good example of how to do similar things to use Scopes and Macros in Laravel to manipulate queries at a higher level.

## Install

```
composer require codewithtony/laravel-active-attribute
```

## Usage

Add the `HasActiveAttribute` to any Eloquent Model that has an `->active` field that is a 1/0 boolean
```
class Thing 
{
    Use HasActiveAttribute;
    ...
}
```

After that you can use it as follows
```
Thing::all(); // only records where $model->active = 1
// or
Thing::withInactive()->all(); // records where $model->active = 1 OR 0
// or
Thing::onlyInactive()->all(); // only records where $model->active = 0
```

## Customize Active Feild

By default `active` is the default field that this will look at, to customize it you can set the constant `ACTIVE`. For example, if the field is named `is_active`.

```
class Thing 
{
    const ACTIVE = 'is_active';
    Use HasActiveAttribute;
    ...
}
```