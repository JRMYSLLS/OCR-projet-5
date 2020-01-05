<?php foreach ($messages as $message):?>
    <div class=" container">
        <p>[ <?=$message['membre']?> à <?=$message['dtime']?> ] - <?=$message['content']?></p>
    </div>
<?php endforeach;?>