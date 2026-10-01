# Week 1: PHP Basics

This README explains the three PHP examples shown in the screenshots in this folder: variables, output with `echo` and `print`, and string functions. Each topic includes the example code, a step-by-step explanation, the expected output, and common points to remember.

## 1. PHP Variables

![Screenshot showing the PHP variables example](Screenshot%20php_variables.php.png)

### Example code

```php
<?php
$full = "xuudi";
echo "my name is $full ";
?>
```

### What the code does

1. `<?php` begins a PHP block. PHP code in a `.php` file is processed by a PHP-enabled web server.
2. `$full = "xuudi";` creates a variable named `$full` and assigns it the text `xuudi`.
3. In PHP, variable names begin with `$`. The `=` sign assigns a value, and the semicolon `;` ends the statement.
4. `echo` sends output to the page. Because the string uses double quotes, PHP replaces `$full` with its value. This is called variable interpolation.
5. `?>` closes the PHP block.

The browser displays:

```text
my name is xuudi
```

### Variable naming rules

- A variable name must start with a letter or underscore after `$`; it cannot start with a number. For example, `$full` is valid, but `$1full` is not.
- Variable names cannot contain spaces or hyphens. Use an underscore or camelCase instead, such as `$full_name` or `$fullName`.
- PHP variable names are case-sensitive: `$full`, `$Full`, and `$FULL` are different variables.
- Assign a value before using a variable so that it contains the value you expect.

### Quotes and interpolation

Double-quoted strings interpolate variables:

```php
$name = "Xuudi";
echo "Hello $name";  // Hello Xuudi
```

Single-quoted strings treat the variable name as ordinary text:

```php
echo 'Hello $name';  // Hello $name
```

Braces make the variable boundary clear when other characters follow it:

```php
echo "Hello {$name}nimo";  // Hello Xuudinimo
```

You can also join text and variables with the concatenation operator, a dot (`.`):

```php
echo "Hello " . $name;
```

### Values a variable can hold

```php
$name = "Xuudi";  // String: text
$age = 25;         // Integer: whole number
$price = 19.99;    // Float: decimal number
$isReady = true;   // Boolean: true or false
$nothing = null;   // Null: no value
```

PHP determines a variable's type from its value, so a type usually does not need to be declared separately.

## 2. PHP `echo` and `print`

![Screenshot showing the echo and print example](Screenshot%20echo_print.php.png)

### Example code

```php
<?php
echo "<h1>welcome home page</h1>";
print "<h2>this simple php file </h2>";

echo "xuudi", "caamir";
echo "java", "react";
?>
```

### What the code does

1. `<?php` begins the PHP block.
2. `echo` sends the `<h1>` HTML element to the browser. The browser interprets it as a large heading, rather than displaying the tags as plain text.
3. `print` sends the `<h2>` element to the browser, which displays it as a smaller heading.
4. `echo "xuudi", "caamir";` prints both strings. The comma lets `echo` accept multiple arguments, but it does not insert a space between them.
5. The next `echo` similarly prints `java` immediately followed by `react`.
6. Each PHP statement ends with a semicolon.

The page shows two headings, followed by:

```text
xuudicaamir
javareact
```

The names and words run together because no space or line break was included between them.

### `echo` compared with `print`

Both constructs display output. `echo` can take multiple comma-separated arguments and has no return value. `print` takes one argument and returns `1`, so it can be used in some expressions. In ordinary output statements, either can be used.

```php
echo "Hello", " ", "world";  // Hello world
print "Hello world";          // Hello world
```

This is invalid because `print` does not accept multiple comma-separated arguments:

```php
print "Hello", "world";      // Invalid
```

### HTML, quotes, and line breaks

HTML can be included in the string sent to the browser. If the HTML itself uses double quotes, use single quotes around the PHP string:

```php
echo '<a href="index.php">Home</a>';
```

To create a visible line break in the browser, output `<br>`:

```php
echo "First line<br>";
echo "Second line<br>";
```

The characters `\n` create a newline in the generated source text, but they do not normally create a visible line break in rendered HTML.

## 3. PHP String Functions

![Screenshot showing the PHP string functions example](Screenshot%20php_string_functions.php.png)

### Example code

```php
<?php
$my_str = 'welcome to php republic';
echo strlen($my_str);
echo str_word_count($my_str);
?>
```

### What the code does

1. `$my_str` is assigned the string `welcome to php republic`.
2. `strlen($my_str)` counts every character in the string, including spaces. It returns `23`.
3. `str_word_count($my_str)` counts the words. It returns `4`.
4. Each function's result is sent to the page by `echo`.

The output is `234`, not because either function returned that number, but because the two results were printed next to each other with no separator. Add an HTML line break or other separator to make them distinct:

```php
echo strlen($my_str) . "<br>";       // 23
echo str_word_count($my_str);        // 4
```

### Useful string functions

```php
$my_str = 'welcome to php republic';

echo strtoupper($my_str);                 // WELCOME TO PHP REPUBLIC
echo strtolower($my_str);                 // welcome to php republic
echo ucfirst($my_str);                    // Welcome to php republic
echo ucwords($my_str);                    // Welcome To Php Republic
echo strrev($my_str);                     // cilbuper php ot emoclew
echo str_replace('php', 'PHP', $my_str);  // welcome to PHP republic
echo substr($my_str, 0, 7);               // welcome
echo strpos($my_str, 'php');              // 11
echo trim('  hello  ');                   // hello
```

- `strtoupper()` changes letters to uppercase.
- `strtolower()` changes letters to lowercase.
- `ucfirst()` capitalizes the first character of the string.
- `ucwords()` capitalizes the first character of each word.
- `strrev()` reverses the string.
- `str_replace()` replaces matching text with new text.
- `substr()` returns part of a string. Here it starts at position `0` and returns `7` characters.
- `strpos()` returns the position where the search text first appears. Positions start at `0`; `php` begins at position `11` in this example.
- `trim()` removes whitespace from the beginning and end of a string.

### Comments and semicolons

Comments explain code and are ignored by PHP:

```php
// Single-line comment
# Also a single-line comment
/* Multi-line
   comment */
```

PHP statements generally need a semicolon at the end. Forgetting one can cause a parse error. A comment mentioning a semicolon does not replace the semicolon in the PHP statement itself.

### Single quotes and double quotes

The example uses single quotes for `$my_str`, which is fine because the string contains no variable that needs interpolation. When a variable is inside a string, double quotes interpolate it, while single quotes leave its name as literal text:

```php
$name = "Xuudi";
echo 'Hello $name';  // Hello $name
echo "Hello $name";  // Hello Xuudi
```

## Running the examples

Open the corresponding `.php` file through a local PHP web server, such as Apache in ZAMPP. For example, a file under `htdocs` can be opened through a `http://localhost/...` address. Opening a PHP file directly as a local file does not execute its PHP code.
