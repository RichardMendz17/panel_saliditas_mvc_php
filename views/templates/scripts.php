<?php
if (!empty($scripts_js))
{
    foreach ($scripts_js as $script_js) 
    {
        $script .= ' <script src="build/js/' . $script_js . '"></script>';
    }
}
?>