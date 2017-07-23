<?php

namespace Application\View\Helper;

use Zend\View\Helper\AbstractHelper;

class AngularBuildPathHelper extends AbstractHelper
{
    /** @var string */
    private $fileName;
    /** @var string */
    private $fileDir;
    /** @var string */
    private $fileExt;

    /**
     * @param $fileLocation
     * @return mixed
     */
    public function __invoke($fileLocation)
    {
        return $this->process($fileLocation);
    }

    private function process($fileLocation)
    {
        $parts = pathinfo($fileLocation);
        $this->fileName = $parts['filename'];
        $this->fileDir = $parts['dirname'];
        $this->fileExt = $parts['extension'];
        return $this->view->basePath($this->getFileNameWithHash());
    }

    private function getFileNameWithHash()
    {
        $files = $this->getAllFilesFromParentPath();
        foreach ($files as $file) {
            $hash = $this->getHash($file);
            if ($hash !== false) {
                return $this->buildPath($hash);
            }
        }
        return $this->buildPath();
    }

    private function buildPath($hash = false)
    {
        $file = join('.', [$this->fileName, $this->fileExt]);
        if ($hash !== false) {
            $file = join('.', [$this->fileName, $hash, $this->fileExt]);
        }
        return join(DIRECTORY_SEPARATOR, [$this->fileDir, $file]);
    }

    private function getAllFilesFromParentPath()
    {
        $dir = 'public' . $this->fileDir;
        if (! is_dir($dir)) {
            return [];
        }
        $allFiles = scandir($dir);
        return array_diff($allFiles, ['.', '..']);
    }

    private function getHash($file)
    {
        $regex = '/^' . preg_quote($this->fileName) . '\.(.*)\.' . $this->fileExt . '$/';
        preg_match($regex, $file, $output);
        return isset($output[1]) ? $output[1] : false;
    }
}
