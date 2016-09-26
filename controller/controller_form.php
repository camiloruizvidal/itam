<?php

class controller_form
{

    public function __construct()
    {
        
    }

    private $content;

    private function prepocesar($data)
    {
        ob_start();
        eval("?> $data <?php ");
        $salida = ob_get_clean();
        return $salida;
    }

    private function read_content()
    {
        $linea   = '';
        $copiar  = true;
        $iniciar = FALSE;
        $url     = '../../../itam/view/form/index.php';
        $fp      = fopen($url, 'r');
        while (!feof($fp))
        {
            $txt = fgets($fp);
            if (is_numeric(strpos($txt, '<#--content_fin--#>')))
            {
                $iniciar = FALSE;
            }
            if ($iniciar)
            {
                $linea.=$txt;
            }
            if (is_numeric(strpos($txt, '<#--content_ini--#>')))
            {
                $iniciar = TRUE;
            }
        }
        return $this->prepocesar($linea);
    }

    private function leer_plantilla($plantilla)
    {
        $fp    = fopen($plantilla, "r");
        $linea = '';
        while (!feof($fp))
        {
            $linea .= fgets($fp);
        }
        $linea = str_replace('<#--contenido--#>', $this->content, $linea);
        return $linea;
    }

    private function css($data)
    {
        $res = '';
        if (is_array($data))
        {
            foreach ($data as $temp)
            {
                $res .= '<link rel = "stylesheet" type = "text/css" href = "' . $temp . '" media = "screen">' . "\n";
            }
        }
        else
        {
            $res = '<link rel = "stylesheet" type = "text/css" href = "' . $data . '" media = "screen">' . "\n";
        }
        return $res;
    }

    private function js($data)
    {
        $res = '';
        if (is_array($data))
        {
            foreach ($data as $temp)
            {
                $res .= ' <script type="text/javascript" src="' . $temp . '"></script>' . "\n";
            }
        }
        else
        {
            $res = ' <script type="text/javascript" src="' . $data . '"></script>' . "\n";
        }
        return $res;
    }

    public function create_formulario($plantilla, $parametros = '')
    {
        @session_start();
        $this->content = $this->read_content();
        $plantilla     = '../plantilla/' . $plantilla;
        $Formulario    = $this->leer_plantilla($plantilla);
        if ($parametros != '')
        {
            foreach ($parametros as $key => $reg)
            {
                switch ($key)
                {
                    case 'css':$reg = $this->css($reg);
                        break;
                    case 'js':$reg = $this->js($reg);
                        break;
                }
                $Formulario = str_replace('<#--' . $key . '--#>', $reg, $Formulario);
            }
        }
        else
        {
            $Formulario = str_replace(array('<#--js--#>', '<#--titulo--#>', '<#--css--#>'), array('', '', ''), $Formulario);
        }
        echo ($Formulario);
        exit();
    }

}

$form = new controller_form();
