<?php

it('is ok')->call('GET', '/vapor-ui', ['group' => 'cli'])->assertOk();
