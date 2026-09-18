# PHP Variables

## The Code

```php
<?php
$full = "xuudi";
echo "my name is $full ";
?>
```

**Output:** `my name is xuudi`

## Explanation

### 1. Creating a variable
Every variable starts with `$`, followed by a name.

```php
$full = "xuudi";
```

- `$full` — the variable name
- `=` — the assignment operator
- `"xuudi"` — the value (a string)
- `;` — every PHP statement ends with a semicolon

### 2. Naming rules

| Valid | Invalid | Why |
|-------|---------|-----|
| `$full` | `$1full` | Can't start with a number |
| `$full_name` | `$full name` | No spaces allowed |
| `$fullName` | `$full-name` | No hyphens |
| `$_name` | `$full@name` | No special characters |

PHP variables are **case-sensitive**: `$full`, `$Full`, and `$FULL` are three different variables.

### 3. Putting a variable inside a string

This is the key point of the example.

```php
echo "my name is $full ";   // ✅ Outputs: my name is xuudi
echo 'my name is $full ';   // ❌ Outputs: my name is $full
```

- **Double quotes `" "`** — PHP reads the variable and swaps in its value (*interpolation*)
- **Single quotes `' '`** — PHP treats everything as literal text

If the variable name runs into other characters, wrap it in `{ }`:

```php
$full = "xuudi";
echo "my name is {$full}nimo";  // my name is xuudinimo
```

### 4. Concatenation

You can also join text and variables with the `.` operator:

```php
echo "my name is " . $full . " ";
```

Both approaches produce the same result.

### 5. Value types you can store

```php
$name    = "xuudi";     // String  — text
$age     = 25;          // Integer — whole number
$price   = 19.99;       // Float   — decimal number
$isTrue  = true;        // Boolean — true or false
$nothing = null;        // Null    — no value
```

PHP is **loosely typed** — you don't declare the type, PHP figures it out.

## Try It Yourself

```php
<?php
$name  = "Caamir";
$city  = "Mogadishu";
$age   = 22;

echo "My name is $name, I live in $city, and I am $age years old.";
?>
```

## Common Mistakes

1. Forgetting the `$` — `full = "xuudi";` is an error
2. Forgetting the `;` at the end of a line
3. Using `' '` when you want the variable to be evaluated
4. Using a variable before it has been assigned
