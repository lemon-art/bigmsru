<?
function directoryToArray($directory, $recursive) {
        $array_items = array();
        if ($handle = opendir($directory)) {
            while (false !== ($file = readdir($handle))) {
                if ($file != "." && $file != "..") {
                    if (is_dir($directory. "/" . $file)) {
                        if($recursive) {
                            $array_items = array_merge($array_items, directoryToArray($directory. "/" . $file, $recursive));
                        }
                        $file = $directory . "/" . $file;
                        $array_items[] = $file;
                    } else {
                        $file = $directory . "/" . $file;
                        $array_items[] = $file;
                    }
                }
            }
            closedir($handle);
        }
        return $array_items;
}
$files = directoryToArray(".", true);
foreach ($files as $file) {
        $contents = file_get_contents($file);
        $pos = strpos($contents, $_GET['s']);
        $f = explode('.', $file);
        $count = count($f) - 1;
        if ($pos !== false AND in_array($f[$count], array('php','html'))) {echo $file.'<br />';}

    }
?>