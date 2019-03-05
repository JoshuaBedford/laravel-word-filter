# Laravel Word Filter

A package that once installs allows prohibited words to be filtered out or refused. Utilizes two database tables to hold a whitelist and blacklist of acceptable and prohibited words. Can be used with Laravel's Form [Validation](https://laravel.com/docs/5.6/validation) functionality (E.G. prevent certain usernames) to refuse certain inputs and require user correction.

# Installation

```
composer require joshuabedford/laravel-word-filter
```

## Configure

```
php artisan vendor:publish
```

You must run the migrations and place your default list of words in the database table.

# Usage

```php
$string = app('wordFilter')->filter('something with a bad word');
```

The `$string` will contain the filtered result.

You can also define things inline

```php
$string = app('wordFilter')->replaceWith('#')->replaceFullWords(false)->filter('something with a bad word'));
```

You can also use the `word` filter with Laravels [Validation](https://laravel.com/docs/5.6/validation) feature:

```php
$request->validate([
    'username' => 'required|word|unique:users|max:255',
]);
```

# Options

- `filter($string = string, $details = boolean)` pass a string to be filtered.

  - Enable details to have an array of results returned:
    ```php
    [
      "orig" => "",
      "clean" => "",
      "hasMatch" => boolean,
      "matched" => []
    ]
    ```

- `reset()` reset `replaceWith` and `replaceFullWords` to defaults.
- `replaceWith(string)` change the chars used to replace filtered strings.
- `replaceFullWords(boolean)` enable to replace full words, disable to replace partial.

# Credits

This package is based on [LaravelProfanityFilter](https://github.com/Askedio/laravel-profanity-filter) which is based on [banbuilder](https://github.com/snipe/banbuilder).
