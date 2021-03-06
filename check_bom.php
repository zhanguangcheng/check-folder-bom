<?php
/**
 * 检测文件夹中存在UTF-8 BOM的文件
 * usage: php check_bom.php dir
 */

if (!isset($argv[1])) {
    die('usage: php check_bom.php dir');
}
set_time_limit(0);
$start = microtime(true);

$process = new Process;
$process->run($argv[1]);

echo 'done', PHP_EOL;
echo 'usage time: ', microtime(true) - $start;

class Process
{
    public $checkDir = '.';

    public $allowExtension = array('html', 'css', 'js', 'php');

    public function run($dir = null)
    {
        if (is_null($dir)) {
            $dir = $this->checkDir;
        }
        if ($handle = opendir($dir)) {
            while (($file = readdir($handle)) !== false) {
                if ($file != '.' && $file != '..') {
                    $fullpath = realpath($dir . "/" . $file);
                    if (!is_dir($fullpath)) {
                        $ext = pathinfo($fullpath, PATHINFO_EXTENSION);
                        if (in_array($ext, $this->allowExtension)) {
                            if ($this->checkBom($fullpath)) {
                                echo $fullpath, PHP_EOL;
                            }
                        }
                    } else {
                        $this->run($fullpath);
                    }
                }
            }
            closedir($handle);
        }
    }

    public function checkBom($filename)
    {
        $handle = fopen($filename, 'rb');
        $content = fread($handle, 3);
        fclose($handle);
        return $content == "\xEF\xBB\xBF";
    }
}
