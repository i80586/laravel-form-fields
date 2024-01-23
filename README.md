# laravel-form-fields
Form fields generator for Laravel

### Examples:

<br>

```
{!! html()->input('firstName') !!}
```

This will be output:

```
<label for="firstName">FirstName</label>
<input type="text" id="firstName" class="form-control" name="firstName" value="">
```

<br>
You can change automatic generated label and set first default value:

```
{!! html()->input('firstName', 'John', ['label' => 'Your name']) !!}
```

This will be output:

```
<label for="firstName">Your name</label>
<input type="text" id="firstName" class="form-control" name="firstName" value="John">
```

<br>
Change input type by setting fourth argument which is set by default to text:

```
{!! html()->input('price', 0, [], 'number') !!}
```

<br>

#### Enjoy :)