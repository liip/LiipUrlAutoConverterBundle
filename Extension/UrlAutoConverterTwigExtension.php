<?php

namespace Liip\UrlAutoConverterBundle\Extension;

class UrlAutoConverterTwigExtension extends \Twig_Extension
{
    protected $linkClass;
    protected $target;
    protected $debugMode;
    protected $debugColor = '#00ff00';

    // @codeCoverageIgnoreStart
    public function getName()
    {
        return 'liip_urlautoconverter';
    }

    public function setLinkClass($class)
    {
        $this->linkClass = $class;
    }

    public function setTarget($target)
    {
        $this->target = $target;
    }

    public function setDebugMode($debug)
    {
        $this->debugMode = $debug;
    }

    public function setDebugColor($color)
    {
        $this->debugColor = $color;
    }
    // @codeCoverageIgnoreEnd

    public function getFilters()
    {
        return array(
            'converturls' => new \Twig_Filter_Method(
                $this,
                'autoConvertUrls',
                array(
                    'pre_escape' => 'html',
                    'is_safe' => array('html'),
                )
            )
        );
    }

    /**
     * method that finds different occurrences of urls or email addresses in a string
     *
     * @param string    $text       Text to parse
     * @param int       $limit      Truncate URLs longer than the limit
     * @param string    $tagfill    Insert some magic into the <a> tags
     * @param bool      $autoTitle  If to add a title attribute to the link in case the url is truncated
     * @return string
     */
    public function autoConvertUrls($text, $limit= 30, $tagfill = '', $autoTitle = true)
    {
        return autolink_email(autolink($text, $limit, $tagfill, $autoTitle), $tagfill);
    }
}
