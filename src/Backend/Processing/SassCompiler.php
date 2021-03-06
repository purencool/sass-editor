<?php
/**
 * App sass compiler
 */

namespace purencool_editor\Backend\Processing;

use \Leafo\ScssPhp\Compiler;

/**
 * Undocumented class
 */
class SassCompiler
{

    /**
     * Undocumented variable
     *
     * @var string
     */
    protected $response;
    
    /**
     * Undocumented function
     */
    public function __construct($app)
    {
        $this->unCompressedSassCompiler($app);
        $this->compressedSassCompiler($app);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    protected function unCompressedSassCompiler($app)
    {
        $app['message']->setMessage('Compile Sass Directories into uncompress file');
        $sassDir =  $app['config']->getSassDirectory();
        $cssDir =  $app['config']->getCssDirectory();
        $defaultScssFile = "@import '". $app['config']->getDefaultSassFile()."'";
        $defaultCssFile = $app['config']->getUnCompressedCssFile();

        $scss = new Compiler($dir);
        $scss->setImportPaths($sassDir);
        $outPut = $scss->compile($defaultScssFile);
        $app['message']->setMessage("<pre>$outPut</pre>");
        $this->response = file_put_contents($cssDir.'/'.$defaultCssFile, $outPut);
    }





    /**
     * Undocumented function
     *
     * @return void
     */
    protected function compressedSassCompiler($app)
    {
        $app['message']->setMessage('Compile Sass Directories in compressed file');
        $sassDir =  $app['config']->getSassDirectory();
        $cssDir =  $app['config']->getCssDirectory();
        $defaultScssFile = "@import '". $app['config']->getDefaultSassFile()."'";
        $defaultCssFile = $app['config']->getDefaultCssFile();

        $scss = new Compiler($dir);
        $scss->setImportPaths($sassDir);
        $scss->setFormatter('Leafo\ScssPhp\Formatter\Compressed');
        $outPut = $scss->compile($defaultScssFile);
        $app['message']->setMessage("<pre>$outPut</pre>");
        $this->response = file_put_contents($cssDir.'/'.$defaultCssFile, $outPut);
    }

    public function getResponse()
    {
        if ($this->response >= 1) {
            return 'Did compile';
        }

        return 'Didn\'t compile';
    }
}
