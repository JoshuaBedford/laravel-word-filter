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

You can edit the default list of words to filter along with the settings in `config/profanity.php`.

`replaceWith` can also be a string of chars to be randomly chosen to replace with, like `'&%^@#'`.

You can create your own list of words, per language, in `resources/lang/[language]/profanity.php`.

# Usage

```php
$string = app('profanityFilter')->filter('something with a bad word');
```

The `$string` will contain the filtered result.

You can also define things inline

```php
$string = app('profanityFilter')->replaceWith('#')->replaceFullWords(false)->filter('something with a bad word'));
```

You can also use the `profanity` filter with Laravels [Validation](https://laravel.com/docs/5.6/validation) feature:

```php
$request->validate([
    'username' => 'required|profanity|unique:users|max:255',
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
