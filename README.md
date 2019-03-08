# Note: NOT FULLY TESTED

P.S. Yes, I am cringing my way through this one. No, I don't know what most of these words/phrases mean.

# Laravel Word Filter

A package that, once installed, allows prohibited words to be filtered out or refused. Works as standalone or with Laravel Validator. Utilizes two database tables to hold a whitelist and blacklist of acceptable and prohibited words. Can be used with Laravel's Form [Validation](https://laravel.com/docs/5.6/validation) functionality (E.G. prevent certain usernames) to refuse certain inputs and require user correction.

# Installation

```
composer require joshuabedford/laravel-word-filter
```

## Configure

```
php artisan vendor:publish
```

The command above will publish the appropriate files. Next, we have to install the database tables.

```
php artisan migrate
```

Now that the database tables are installed, we can seed them with data.

```
php artisan db:seed --class=JoshuaBedford\\LaravelWordFilter\\Database\\Seeds\\DatabaseSeeder
```

This should seed the database with our list of words that we consider necessary to blacklist or whitelist.

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
