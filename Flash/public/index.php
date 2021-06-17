<?php

include __DIR__ . "/../Flash.php";

Flash::flashMessage('first', 'first message');
Flash::flashMessage('second', 'second message');

echo Flash::flashMessage('first');

var_dump($_SESSION);

echo Flash::flashMessage('second');
