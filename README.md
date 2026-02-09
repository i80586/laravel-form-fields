# laravel-form-fields

Fluent form fields generator for Laravel

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

This will be output:

```html
<label for="name">Name</label>
<input type="text" name="name" id="name" class="form-control" value="John">
```

### Label

```php
{!! form()->input('name')->label('Your name') !!}
```

This will be output:

```html
<label for="name">Your name</label>
<input type="text" name="name" id="name" class="form-control" >
```

### Multiple CSS classes
You can pass multiple classes in one call:

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

This will be output:

```html
<input type="text" name="name" id="name" value="John" class="form-control name-select" required>
```

### Old input support

Form fields automatically use Laravel `old()` values after validation errors.

You do not need to manually fetch value from old(), the old value will be inserted automatically.

Use followed variant:

```php
{!! form()->input('email', 'some@email.com')) !!}
```

instead of:

```php
❌

{!! form()->input('email', old('name', 'some@email.com')) !!}
```

---

#### Enjoy :)