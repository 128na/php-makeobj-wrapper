# php-makeobj-wrapper

PHPからmakeobjを実行できるラッパークラスです。

# install

```
composer require 128na/php-makeobj-wrapper
```

# usage

Windows,Linuxで実行可能です。

```
<?php
use _128Na\Simutrans\Makeobj\Makeobj;

$makeobj = new Makeobj(Makeobj::OS_LINUX); // or Makeobj::OS_WIN

$response = $makeobj->version();

echo $reponse;
// --- stdout ---
// Makeobj version 60.5 for Simutrans 122.0 and higher
// ...
```
