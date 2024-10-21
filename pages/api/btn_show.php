<?php
$irc = 0;
_selectRowNoParam(
     "select irc from btn_show",
     $irc
    );
    echo $irc;