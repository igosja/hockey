<?php

return [
    'h1' => 'Forgot password?',
    'submit' => 'Recover password',
    'text-1' => '<p>
            Here you can request to send <strong>a forgotten password to your mailbox</strong>,
            which you specified when registering.
        </p>
        <p>
            Enter your <strong>login</strong> or <strong>email</strong>:
        </p>',
    'text-2' => '<p>
            If during the registration you entered your email incorrectly or it does not work anymore,
            <br/>
            then email us at <span class="strong">' . Yii::$app->params['infoEmail'] . '</span>
            <br/>
            and we will try to find your account manually.
        </p>',
];
