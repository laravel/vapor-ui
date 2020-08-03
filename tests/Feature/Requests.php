<?php

it('is ok')->call('GET', '/vapor-ui/api/requests', [
    'startTime' => now()->timestamp,
])->assertOk();
