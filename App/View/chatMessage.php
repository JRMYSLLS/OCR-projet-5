
<?php foreach ($messages as $message):?>
    
      <p>[ <?=$message['membre']?> à <?=$message['dtime']?> ] - <?=$message['content']?></p>
    
<?php endforeach;?>
