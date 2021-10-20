<?php
/**
 * @author  Foma Tuturov <fomiash@yandex.ru>
 */

namespace Phphleb\Draft\Src;

class Converter
{
    private $config = [];

    private $patternsDir;

    private $instancesDir;

    private $errors = [];


    public function __construct(array $config, string $instancesDir, string $patternsDir)
    {
        $this->config = $config;
        $this->instancesDir = $instancesDir;
        $this->patternsDir = $patternsDir;
    }

    public function run(): bool
    {
        $this->checkConfig();
        if (count($this->errors)) {
            return false;
        }
        if (!$this->createNewClasses() || count($this->errors)) {
            return false;
        }
        if(count($this->config) !== 1) {
            DirectoryChanger::recursiveRemoveDirectory($this->instancesDir);
        }
        $this->errors = [];
        return $this->createNewClasses(true);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    private function checkConfig(): void
    {
        foreach ($this->config as $key => $config) {
            if (count($config) !== 1) {
                $this->errors[] = 'Incorrectly filled draft state';
            }
            foreach($config as $k => $conf) {
                $file = $this->patternsDir . DIRECTORY_SEPARATOR . $k . '.php';
                if (!file_exists($file)) {
                    $this->errors[] = 'Draft file not found: ' . $file;
                }
            }
        }
    }

    private function createNewClasses(bool $save = false): bool
    {
        foreach ($this->config as $key => $config) {
            $class = end($config);
            $content = $this->createContent(key($config), $key, $class);
            if(is_null($content)) {
                return false;
            }
            if($save) {
                $pathParts = explode('/', str_replace('\\', '/', $key));
                $file = array_pop($pathParts);
                $directory = $this->instancesDir;
                if (count($pathParts)) {
                    $directory .= DIRECTORY_SEPARATOR . implode('/', $pathParts);
                }
                if(!is_dir($directory)) {
                    mkdir($directory, 0755, true);
                }
                $resultFile = $directory . DIRECTORY_SEPARATOR . $file . '.php';
                file_put_contents($resultFile, $content);
            }
        }
        return count($this->errors) === 0;
    }

    private function createContent(string $draftClass, string $newClass, array $listOfReplace = []): ?string
    {
        $draftFile = $this->patternsDir . DIRECTORY_SEPARATOR . str_replace('\\', '/', $draftClass) . '.php';
        $text = fopen($draftFile, "r");
        $result = '';
        $num = 0;
        if ($text) {
            $newClassParts = explode('/', str_replace('\\', '/', $newClass));
            while (($str = fgets($text)) !== false) {
                $num++;
                $str = $this->convertRow($str, $listOfReplace + ['ClassName' => end($newClassParts)]);
                if (is_null($str)) {
                    $this->errors[] = "Could not convert string $num in file $draftFile:$num";
                    break;
                }
                $result .= $str;
            }
        }
        fclose($text);
        if(count($this->errors)) {
            return null;
        }
        return DirectoryChanger::ALERT_MESSAGE . $result;
    }

    private function convertRow(string $str, array $listOfReplace = []): ?string
    {
        if (!strripos($str, '/**<-@')) {
            return $str;
        }
        if (preg_match_all('#([^\s\'\"\)\(]+)\/\*\*<-@([^\*]+)\*\/#', $str, $arr)) {
          if(!empty($arr[0]) && !empty($arr[1]) && !empty($arr[2])) {
              $newStr = $str;
              foreach($arr[2] as $key => $tag) {
                if(!array_key_exists($tag, $listOfReplace)) {
                    return null;
                }
                  $pattern = '#([^\s\'\"\)\(]+\/\*\*<-@' . $tag . '\*\/)#';
                  $value = $listOfReplace[$tag];
                  if(rtrim($arr[1][$key], '/') !== $arr[1][$key]) {
                      $value .= ' */';
                  }

                  $newStr = preg_replace($pattern, $value, $newStr);
              }
              return $newStr;
          }
        }
        return null;
    }

}


