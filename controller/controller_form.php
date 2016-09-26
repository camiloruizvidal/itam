<?php

class controller_form
{

    private $content;
    private $url_error;
    private $url_no_valido_user;
    public $plantilla;
    public $parametros;
    public $sesiones;

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
        $url     = '../../..'.$_SERVER['PHP_SELF'];
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

    private function ValidarSesiones($sesiones)
    {
        if ($sesiones != '')
        {
            @session_start();
            if (isset($_SESSION['perfil']))
            {
                if (in_array($_SESSION['perfil'], $sesiones))
                {
                    
                }
                else
                {
                    exit('Redireccionar');
                    //Redireccionar
                }
            }
            else
            {
                exit('Redireccionar');
            }
        }
    }

    public function create()
    {
        $plantilla     = $this->plantilla;
        $parametros    = $this->parametros;
        $sesiones      = $this->sesiones;
        
        $this->ValidarSesiones($sesiones);
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
        $Formulario = str_replace(array('<#--js--#>', '<#--titulo--#>', '<#--css--#>'), array('', '', ''), $Formulario);
        echo $Formulario;
        exit();
    }

}

$form = new controller_form();
