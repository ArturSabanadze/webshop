<?php
function hsc(array $row, string $column_name)
{
    return htmlspecialchars($row[$column_name] ?? '');
}