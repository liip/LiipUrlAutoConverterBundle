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
            'converturls' => new \Twig_Filter_Method($this, 'autoConvertUrls', array('is_safe' => array('html'))),
            new \Twig_SimpleFilter(
                'secureconverturls',
                array($this, 'secureAutoConvertUrls'),
                array(
                    'is_safe' => array('html'),
                    'pre_escape' => 'html' // Escape the input to prevent JavaScript injection
                )
            )
        );
    }

    /**
     * method that finds different occurrences of urls or email addresses in a string
     * @param string $string input string
     * @return string with replaced links
     */
    public function autoConvertUrls($string)
    {
        $pattern = '/(href=")?([-a-zA-Z0-9@:%_\+.~#?&\/\/=]{2,256}\.[a-z]{2,4}\b(\/?[-a-zA-Z0-9@:%_\+.~#?&\/\/=]+)?)/';
        $stringFiltered = preg_replace_callback($pattern, array($this, 'callbackReplace'), $string);

        return $stringFiltered;
    }

    /**
     * This method receives an pre-escaped string to assure that no JavaScript like for example
     * <a href="#" onmouseenter="var cookie = encodeURIComponent(document.cookie);var request = new XMLHttpRequest();
     * ...and so on...">steal my php session cookies</a>. This also prevents users from using other HTML tags as well
     * which is possible using the converturls filter.
     * After that it simply runs the unsecure UrlAutoConverterTwigExtension::autoConvertUrls($string)
     */
    public function secureAutoConvertUrls($string)
    {
        return $this->autoConvertUrls($string);
    }

    public function callbackReplace($matches)
    {
        if ($matches[1] !== '') {
            return $matches[0]; // don't modify existing <a href="">links</a>
        }

        $url = $matches[2];
        $urlWithPrefix = $matches[2];

        if (strpos($url, '@') !== false) {
            $urlWithPrefix = 'mailto:'.$url;
        } elseif (strpos($url, 'https://') === 0 ) {
            $urlWithPrefix = $url;
        } elseif (strpos($url, 'http://') !== 0) {
            $urlWithPrefix = 'http://'.$url;
        }

        $style = ($this->debugMode) ? ' style="color:'.$this->debugColor.'"' : '';

        // ignore tailing special characters
        // TODO: likely this could be skipped entirely with some more tweakes to the regular expression
        if (preg_match("/^(.*)(\.|\,|\?)$/", $urlWithPrefix, $matches)) {
            $urlWithPrefix = $matches[1];
            $url = substr($url, 0, -1);
            $punctuation = $matches[2];
        } else {
            $punctuation = '';
        }

        return '<a href="'.$urlWithPrefix.'" class="'.$this->linkClass.'" target="'.$this->target.'"'.$style.'>'.$url.'</a>'.$punctuation;
    }
}
