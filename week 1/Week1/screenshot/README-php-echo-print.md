# PHP `echo` and `print`

## The Code

```php
<?php
echo "<h1>welcome home page</h1>";
print "<h2>this simple php file </h2>";

echo "xuudi", "caamir";
echo "java", "react";
?>
```

**Output:**
```
welcome home page      (large h1 heading)
this simple php file   (smaller h2 heading)
xuudicaamir
javareact
```

## Explanation

### 1. PHP file structure
All PHP code lives inside `<?php ... ?>`, and the file must be saved with a `.php` extension.

### 2. `echo`
`echo` prints text to the screen. It's a **language construct**, not a function, so parentheses are optional.

```php
echo "Hello";
echo("Hello");   // also works
```

### 3. `print`
`print` also outputs text, but there are small differences.

| | `echo` | `print` |
|---|---|---|
| Type | Statement | Statement that returns a value |
| Return value | Nothing | Always `1` |
| Multiple arguments | ✅ Yes (comma-separated) | ❌ No, one only |
| Speed | Slightly faster | Slightly slower |

That's why `echo "xuudi", "caamir";` works, but this fails:

```php
print "xuudi", "caamir";   // ❌ Parse error
```

### 4. HTML inside PHP
You can write HTML tags directly inside the output string:

```php
echo "<h1>welcome home page</h1>";
```

The browser reads it as HTML, so `<h1>` renders as a large heading and `<h2>` as a smaller one.

⚠️ **Watch out:** if your HTML contains `"` characters, use single quotes on the outside:

```php
echo '<a href="index.php">Home</a>';
```

### 5. Comma vs dot

```php
echo "xuudi", "caamir";    // comma — faster, echo only
echo "xuudi" . "caamir";   // dot   — concatenation
```

Both output `xuudicaamir` — no space is added automatically. If you want a space:

```php
echo "xuudi", " ", "caamir";   // xuudi caamir
```

### 6. Line breaks
`\n` creates a new line in the page source, but the browser won't display it as a break. Use `<br>` for the browser:

```php
echo "xuudi<br>";
echo "caamir<br>";
```

## Try It Yourself

```php
<?php
echo "<h1>Learning PHP</h1>";
echo "<p>Today we are learning echo and print.</p>";
echo "Languages: ", "PHP", ", ", "JavaScript", "<br>";
print "This is the last line.";
?>
```

## Common Mistakes

1. Forgetting the `;` at the end of a statement
2. Using commas with `print`
3. Using `"` inside `"` without escaping it with `\`
4. Expecting `\n` to break the line in the browser — use `<br>`
