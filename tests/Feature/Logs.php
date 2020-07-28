<?php

it('is ok')->call('GET', '/vapor-ui/logs', ['group' => 'cli'])->assertOk();
