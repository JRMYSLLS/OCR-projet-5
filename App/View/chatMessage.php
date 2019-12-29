<?php foreach ($messages as $message):?>
    
    <p><?=$message['membre']?> à <?=$message['dtime']?></p>
    <p><?=$message['content']?></p>

<?php endforeach;?>
    
