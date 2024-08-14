<?php

it('has configuration', function () {
    expect(config('paymate.merchant_id'))->toBe('102530003108');
    expect(config('paymate.base_url'))->toBe('https://paymentapi.wepayez.com/gateway/payment');
    expect(config('paymate.merpubkey'))->toBe('MIIEvAIBADANBgkqhkiG9w0BAQEFAASCBKYwggSiAgEAAoIBAQCy2zyLNF79qrdYuOV0iGc0Y9AuhlrpM7enXVYdgYKf9zwyjnWMV7HOtcaMdEwNTTju4hopDB8ER8HgftyLlxEO6M9U8hj+QGzq4RXBANlpCfrkbOSTbv+UGgcixPqeABN5V7HOPukBuW2AQZ/CPQ17HOdySacK9rwF1UT4XGVWjaLPZYRpdrFY+/13gDC5gpEfyXKu94Slvcr7aZU2xo2mWkQ/Jdo+gIF80zfCGSBCoJXsLPPk7xzjDZ6OjhRdidstLMZE+6Ka7VkJeCAnVrIrfbKfwvOIIv/Dq9kZR7J82AojZGQDljv0syffhiOMLlUnMA62oZl6YXmVsOR4g4lrAgMBAAECggEAeKZ9m+XTIkjz72yilE6jV+rw90F4uBFEFSlYOwUvSZtsxynkT6ykbC2g5wRYfSyXeEWbog7kKW4Ccd8CBUP9pNIVclbx1yk8j+EQXKanAj1SOp7ePjpFO/Gm2KSJ7uVcPaGTdu5nHduo6zjZfRzUKDViR205uqKgSUsJgIRLc+tsROZWc+IrcRpOsUQ1x6+cdbHXN0bjbdKwvzl/lOIbekO0LzDiFoPWOZJD13JSitT8Nvwyn64wm2WpVVlU6oDxSz7pniobH4XtV93jYi3JlVyAkyhqSNvOaxu0ixfOnm8aDCftNY143Yt0NDBRpkTHuORsLvDP3/qWVpf1EkjpiQKBgQDiEv/GozcdxIHSa9mXoLyY9xYgJfwXh0Xramt1IwnPumpuhNjKTEk7UvUsA6fFxv26i7vAkukOI17Vu0Ij2r4zkMS1HlXQzsp4lhlA42I1jvVZcIadHIQIn1GnOHo9Z2nITcEeAfW+F2Ip5tQUem1bh8XoakWGbE/ctIHQNt4rVwKBgQDKiCl5x20Q71oMZ1o8clFs5bHgEHdKXu9msTpa8WIL1UD0L/MmGtIQ7uvWPV+a50C42lbd4q5+wSD9YC4QWVjAY195c8IKpwSIzd8pwZ4UZVLlH7vuvJvcKG8c3ugwVGH74zAok0sQr+AF8oIREcwyjYDUzFbkkZEL389PH3+aDQKBgGPmQWBlf1WIIFX7kouOW8i8ZuqN3ngHLr54qEN62DsTBTURPzsluracUfrBIsIizLxCQxU11gaJWr7XoMJ3RtVCg6oFXaaHurDOoxopYJyKL6D2OIX0s+Obg1mBe4Lmz7fTpCK+evklHBuoBM+HygtIVAv/6fkco63DlhmMJWDBAoGARF7rAX1dSFZE4+MQB0/gRQ7VmXp1itm5n8U8me7a1nvLTaPSRY7QU38UhmJ5n+VpZ/3tTUJ0/b1c0axiYIqI94mUdX+qhcYUNcqqB4KhRuldrpOj8dgiFZRgzjJB1+7klRAA9fGjaaK10cwoNHL5qCc00qGYw9iQSp3nciKEBRECgYBSQE3NIbdUOZZd1kIYeHydOD441VrdiA8t/Ah5nM4rqcMz+S2AQ7yhuAJqQPDnHggW5gAfTfCcIezT8aBZ+B0mdJ9wPOWCbOvsC+r4x8Xz9MmFpBDVohondZQkCXpbzTBAC6RxYBD1P285oa7EyupkBXrggO3Nktq4HS6957fPXQ==');
    expect(config('paymate.jwskey'))->toBe('MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAtOzOTRFZtakJwdBDbSuheMWxKhV2EokXaOM6r66hADP1BP2rG6kXErriL9PcR1Mt4agtfcGndXnaS3X2HxFkezv9vNdUapo8DYdAzknWhZ3r9rrNXeE5v+KuS/esocJfBkKvMgY82x4otzPEocU1m/LNJGYeTuKQu0bjHCvrWfuBrQ2yeAFasu5AsLj8wk1WXyVIwqB6fenqVTfwX8aVttryLDs3BUlwBXMgoehYCom+2+dUuZHtjsNzC2QW+xyFe/OjbguIshapkNatb6OXNQEbj0C1pcsMHpntBgz5pcCot5G4OEP7vP3CntVY4uCsiMNFYpzBwNsp+D2lAOtVowIDAQAB');
    expect(config('paymate.jwekey'))->toBe('MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAjIhrN/UGzoTN387JXhL6qF4JlxKqpJrFIwzIlPKotC95KZqvA8cZPDY0S3EkUzeJl3MDwxwWjD/rTHj9gHVmqhKECHflOEWtS/6q3bjgw53CIHl8ZSHRVZwE63W2UUMTdByddotHHTlYxc2t/auV+rKGr1F/Seb/atwsqj2Q33ltNbDWvx1zrHSihpmA/fahghlUlpyQ+yeQy4roON6lttFGBQrzLeLnSoKqsWY6duYhUc53VqbrzSD8v63d5UNYKMqVtYEv6ZWEDQ9JB5D0WvMahLPbkdLb3E65QJDwmisIwD0E0jeDO8MvD3EGWkMuS3YsWvyzUTkojkrIsTWtWwIDAQAB');
    expect(config('paymate.callback'))->toBe('https://homeful.ph');
    expect(config('paymate.notifyurl'))->toBe('https://eoktie2n2pdyofg.m.pipedream.net');
});
