<?php
    $script = null;
    if (!empty($scripts_js))
    {
        foreach ($scripts_js as $script_js) 
        {
            $script .= ' <script type="module" src="build/js/' . $script_js . '"></script>';
        }
    }
?>