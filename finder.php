<?php

return \StubsGenerator\Finder::create()
    ->in('wordpress')
    ->notPath('wp-admin/includes/noop.php')
    ->notPath('wp-content/plugins')
;
