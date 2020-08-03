<?php

it('is ok')->call('GET', '/vapor-ui/api/commands', [
    'startTime' => now()->timestamp,
])->assertOk();
