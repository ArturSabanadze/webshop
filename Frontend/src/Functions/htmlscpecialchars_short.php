<?php

function hsc($column_name) 
{
    return 'htmlspecialchars($row[\'' . $column_name . '\'])';
}