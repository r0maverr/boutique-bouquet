<?php

/* @var $this \yii\web\View view component instance */
/* @var $user \common\models\extended\Users */
/* @var $link string */

?>

<h2>Email confirmation</h2>
<p>
    To confirm email please follow this <a href="<?=$link?>">link</a>!
</p>
<p>
    Sincerely, the <?= Yii::$app->params['settings']['serviceName'] ?>.
</p>