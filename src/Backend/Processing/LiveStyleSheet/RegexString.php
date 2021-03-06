<?php
/**
 * App sass compiler
 */

namespace purencool_editor\Backend\Processing\LiveStyleSheet;

use FileFetcher\FileFetchingException;
use FileFetcher\SimpleFileFetcher;

/**
 * Undocumented class
 */
class RegexString
{

/**
 * Undocumented variable
 *
 * @var [type]
 */
    protected $app;
    
    /**
     * Undocumented array
     *
     * @var array
     */
    protected $response = [];


    /**
     * Undocumented string
     *
     * @var string
     */
    protected $styleChunk;



    /**
     * Undocumented variable
     *
     * @var string
     */
    protected $fileContents;




    
    /**
     * Undocumented function
     */
    public function __construct($app)
    {
        $this->app = $app;
    }

    /**
     * Undocumented function
     *
     * @return void
     *
     *  @title "first button"
     *  @link "first button"
     *  @html <button class="button">First button</button>
     *  @description "this is a description about the button"
     *
     *
     */
    protected function styleChunk()
    {
        //@todo needs to be tested  
        //preg_match_all("/\/\*\*\s*\*\s*\@style\s*\*\/(.*?)\/\*\s*\@end\s*\*\//s", $input, $matches3, PREG_PATTERN_ORDER);
   // print_r($matches3[0]);
        $matchesArray = explode('@style', $this->fileContents);

        foreach ($matchesArray as $key => $stringToBeTested) {
            if (strpos($stringToBeTested, "@end")) {
                $removeExcessCSS = strstr($stringToBeTested, '@end', true);
                $matches[] = "/*". $removeExcessCSS . "*/";
            }
        }

   
 
        foreach ($matches as $array) {
            $this->styleChunk = $array;

            $return['css'] = $this->cssString();
            $return['html'] = $this->htmlString();
            $return['link'] = $this->linkString();
            $return['title'] = $this->titleString();
            $return['description'] = $this->descriptionString();

            $this->response[] = $return;
            unset($return);
        }
    }


    /**
     * Undocumented function
     *
     * @return void
     */
    protected function cssString()
    {
        preg_match_all('/([-0-9a-zA-Z,.:\[\]()\s#>]+\{[^}]+\})/', $this->styleChunk, $matches);

        return $matches;
    }




    /**
     * Undocumented function
     *
     * @return void
     */
    protected function htmlString()
    {
        preg_match_all('/@html "(.*?)"/', $this->styleChunk, $matches);

        return $matches;
    }



    /**
        * Undocumented function
        *
        * @return void
        */
    protected function linkString()
    {
        preg_match_all('/@link "(.*?)"/', $this->styleChunk, $matches);

        return $matches;
    }




    /**
        * Undocumented function
        *
        * @return void
        */
    protected function titleString()
    {
        preg_match_all('/@title "(.*?)"/', $this->styleChunk, $matches);
        
        return $matches;
    }


    /**
        * Undocumented function
        *
        * @return void
        */
    protected function descriptionString()
    {
        preg_match_all('/@description "(.*?)"/', $this->styleChunk, $matches);

        return $matches;
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    protected function fileFinder()
    {
        $directory = $this->app['config']->getCssDirectory();
        $fileName = $this->app['config']->getUnCompressedCssFile();
        $fetcher = new SimpleFileFetcher();

        $this->fileContents = $fetcher->fetchFile($directory.'/'.$fileName);
    }


    /**
     * Undocumented function
     *
     * @return string
     */
    public function getResponse()
    {
        $this->fileFinder();
        $this->styleChunk();
        return $this->response;
    }
}
