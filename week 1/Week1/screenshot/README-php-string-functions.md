# PHP String Functions

## The Code

```php
<?php
$my_str = 'welcome to php republic';
echo strlen($my_str);
echo str_word_count($my_str);   // A semicolon was added
?>
```

**Output:** `234`

Why? `strlen` returns **23** and `str_word_count` returns **4**. Since nothing separates them, they run together as `234`.

To separate them:

```php
echo strlen($my_str) . "<br>";        // 23
echo str_word_count($my_str);         // 4
```

## Explanation

### 1. `strlen()` — character count

Counts **every character**, including spaces.

```
w e l c o m e _ t o _ p h p _ r e p u b l i c
```
`welcome`(7) + space(1) + `to`(2) + space(1) + `php`(3) + space(1) + `republic`(8) = **23**

### 2. `str_word_count()` — word count

Counts words separated by spaces: `welcome`, `to`, `php`, `republic` = **4**

### 3. The semicolon `;`
As the code comment notes, every PHP statement must end with `;`. Leave it out and you get a **Parse error**.

### 4. Comments

```php
// Single-line comment
# Also a single-line comment
/* Multi-line
   comment */
```

### 5. Other important string functions

```php
$my_str = 'welcome to php republic';

echo strtoupper($my_str);              // WELCOME TO PHP REPUBLIC
echo strtolower($my_str);              // welcome to php republic
echo ucfirst($my_str);                 // Welcome to php republic
echo ucwords($my_str);                 // Welcome To Php Republic
echo strrev($my_str);                  // cilbuper php ot emoclew
echo str_replace('php', 'PHP', $my_str);  // welcome to PHP republic
echo substr($my_str, 0, 7);            // welcome
echo strpos($my_str, 'php');           // 11 (starting position)
echo trim('  hello  ');                // hello (trims whitespace)
```

### 6. Quick reference

| Function | Purpose | Example output |
|----------|---------|----------------|
| `strlen()` | Character count | `23` |
| `str_word_count()` | Word count | `4` |
| `strtoupper()` | Uppercase | `WELCOME...` |
| `strtolower()` | Lowercase | `welcome...` |
| `ucfirst()` | Capitalize first letter | `Welcome...` |
| `ucwords()` | Capitalize each word | `Welcome To...` |
| `strrev()` | Reverse the string | `cilbuper...` |
| `substr()` | Extract a portion | `welcome` |
| `strpos()` | Find a position | `11` |
| `str_replace()` | Replace text | `welcome to PHP...` |
| `trim()` | Remove surrounding whitespace | `hello` |

### 7. Note: `' '` vs `" "`

This example uses single quotes:

```php
$my_str = 'welcome to php republic';
```

That's fine because there's no variable inside. But:

```php
$name = "Xuudi";
echo 'Hello $name';   // Hello $name   ❌
echo "Hello $name";   // Hello Xuudi   ✅
```

## Try It Yourself

```php
<?php
$text = 'PHP is a server-side language';

echo "Characters: " . strlen($text) . "<br>";
echo "Words: "      . str_word_count($text) . "<br>";
echo "Uppercase: "  . strtoupper($text) . "<br>";
echo "Replaced: "   . str_replace('PHP', 'Python', $text);
?>
```

## Common Mistakes

1. Forgetting the `;` — the comment in the code points this out
2. Echoing two functions in a row with no separator — the output runs together (`234`)
3. Assuming `strpos()` starts at 1 — it starts at **0**
4. Assuming `strlen()` skips spaces — it counts them
