# File Constructor

Make file and directory from php array.

## Install

```
composer mitsuru793/file-constructor
```

## Example

```php
<?php

$root = '/tmp/test';
$fs = new FileConstructor($root);
$fs->append([
    'dir1' => [],
    'dir2' => [
        'dir3' => [],
        'dir2-f1' => '',
    ],
    'f1' => '',
    'f2' => 'hello',
]);

// has made dirs and files
// If value is string, it's file content.
```


## Test

You can use factory method to use a temporary directory. This will make a root directory as temporary.

```php
<?php
$fs = FileConstructor::inTempDir();
$fs->append([
    'f1' => 'hello',
]);
```
