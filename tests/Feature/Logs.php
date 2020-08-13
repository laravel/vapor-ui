<?php

it('has http')->get('vapor-ui/logs/http')->assertOk();
it('has cli')->get('vapor-ui/logs/cli')->assertOk();
it('has queue')->get('vapor-ui/logs/queue')->assertOk();
