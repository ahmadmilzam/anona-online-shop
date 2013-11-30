<?php
    $num = 1;
    foreach ($data as $data) {
        echo $num++ .' - '. $data->nama .' - '. $data->email .' - '. $data->hobi .'<br>';
    }
    echo '<p class="footer">Page rendered in <strong>'.$this->benchmark->elapsed_time().'</strong> seconds</p>';
?>