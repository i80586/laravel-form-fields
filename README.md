# laravel-form-fields

A fluent form field generator for Laravel

[![Latest Version](https://img.shields.io/github/release/i80586/laravel-form-fields.svg?style=flat-square)](https://github.com/i80586/laravel-form-fields/releases)
[![Build Status](https://img.shields.io/github/actions/workflow/status/i80586/laravel-form-fields/php-ci.yml?label=ci%20build&style=flat-square)](https://github.com/i80586/laravel-form-fields/actions?query=workflow%3ACI)

<hr>

## 🚀 About

`laravel-form-fields` provides a **fluent, expressive API** for generating form fields in Laravel.

Version 2 introduces a **builder-style syntax**, replacing array-based configuration with readable method chaining.

---

## 📋 Requirements

- PHP >= 8.3
- Laravel >= 10

## 📦 Installation

```bash
composer require i80586/laravel-form-fields
```

## Basic usage

```php
{!! form()->input('name') !!}
```

Output:

```html
<label for="name">Name</label>
<input type="text" name="name" id="name" class="form-control">
```

### Setting default value:

```php
{!! form()->input('name', 'John') !!}
```

This will output:

```html
<label for="name">Name</label>
<input type="text" name="name" id="name" class="form-control" value="John">
```

### Change the text of the default label

```php
{!! form()->input('name')->label('Your name') !!}
```

This will output:

```html
<label for="name">Your name</label>
<input type="text" name="name" id="name" class="form-control">
```

### Multiple CSS classes
You can pass multiple CSS classes in a single call:

```php
{!! form()
    ->input('name', 'John')
    ->label(false)
    ->required()
    ->class('form-control', 'name-select')
!!}
```

or

```php
{!! form()
    ->input('name', 'John')
    ->label(false)
    ->required()
    ->class(['form-control', 'name-select'])
!!}
```

This will output:

```html
<input type="text" name="name" id="name" value="John" class="form-control name-select" required>
```

### Select

```php
{!! form()->select('city', 1, [1 => 'Baku'], 'Choose city') !!}
```

This will output:

```html
<label for="city">City</label>
<select name="city" id="city" class="form-select">
<option value>Choose city</option>    
<option value="1" selected>Baku</option>    
</select>
```

### Old input support

Form fields automatically use Laravel `old()` values after validation errors.

You do not need to manually call old();
the previous value will be inserted automatically.

Use the following variant:

```php
{!! form()->input('email', 'some@email.com') !!}
```

instead of:

```php
❌

{!! form()->input('email', old('email', 'some@email.com')) !!}
```

---

## Philosophy

- Fluent API

- Explicit over magic

- Laravel-native behavior

- Clean and predictable HTML output

## License

MIT License