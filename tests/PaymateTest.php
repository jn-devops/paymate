<?php

it('has configuration', function () {
    expect(config('paymate.merchant_id'))->toBe('102530003108');
});
