<?php

it('is ok')->call('GET', '/vapor-ui/api/jobs', [
    'startTime' => now()->timestamp,
])->assertOk();
