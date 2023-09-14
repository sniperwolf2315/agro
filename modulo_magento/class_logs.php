<?php
class Log
{
    public function __construct($filename, $path)
    {
        $this->path = ($path) ? $path : "/";
        $this->filename = ($filename) ? $filename : "log";
        $this->date = date("Y-m-d H:i:s");
    }

    public function insert($text, $dated, $clear, $backup = false)
    {
        if ($dated) {
            $date = "_" . str_replace(" ", "_", $this->date);
            $append = null;
        }
        else {
            $date = $this->fecha();
            $append = ($clear) ? null : FILE_APPEND;
            if ($backup) {
                $result = (copy($this->path . $this->filename . ".log", $this->path . $this->filename . "_" . str_replace(" ", "_", $this->date) . "-backup.log")) ? 1 : 0;
                $append = ($result) ? $result : FILE_APPEND;
            }
        }
        /* $log    = $this->date .s" [text] " . $text . PHP_EOL; */
        // $result = (file_put_contents($this->path . $this->filename . $date . ".log", $text, $append)) ? 1 : 0; /* LOG CON HORA DE INICIO y FIN  */
        $result = (file_put_contents($this->path . $this->filename . ".log", $text, $append)) ? 1 : 0; /* LOG CON HORA DE INICIO */
        return $result;
    }
    // 98071

    public function ruta()
    {
        $date = $this->fecha();
        $ruta = $this->path . $this->filename . '/' . $date;
        return $ruta;
    }
    public function fecha()
    {
        $ini_carac = ['-', ':', ' '];
        $fin_carac = ['_', '_', '_'];
        $date = str_replace($ini_carac, $fin_carac, $this->date);
        return $date;
    }
}



function crear_logs($nombre_arch, $var_array){
  /* ESTO FRAGMENTO DE CODIGO REGISTRARA EL RESULTADO DEL ARRA */
  $logs_data = var_export($var_array, true);
  $log = new Log($nombre_arch, "../logs");
  $log->insert($logs_data, false, false, false);
}



?>