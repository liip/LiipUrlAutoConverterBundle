<?php

namespace Liip\UrlAutoConverterBundle\Tests\Functional\Twig;

use Liip\UrlAutoConverterBundle\Extension\UrlAutoConverterTwigExtension;

class UrlAutoConverterTest extends \PHPUnit_Framework_TestCase
{
    public function testEscapedHtml()
    {
        if (method_exists('\Twig_Environment', 'createTemplate')) { // twig > 2.0
            $twig = new \Twig_Environment(new \Twig_Loader_Array());
            $twig->addExtension(new UrlAutoConverterTwigExtension());

            $body = 'Hello <a href="javascript:alert(\'ups\');">name</a>!';
            $expected = 'Hello &lt;a href=&quot;javascript:alert(&#039;ups&#039;);&quot;&gt;name&lt;/a&gt;!';

            $template = $twig->createTemplate('{{ body | converturls }}');

            $this->assertEquals($expected, $template->render(array('body' => $body)));
        } else { // twig < 2.0
            $loader = new \Twig_Loader_String();
            $twig = new \Twig_Environment($loader);
            $twig->addExtension(new UrlAutoConverterTwigExtension());

            $body = 'Hello <a href="javascript:alert(\'ups\');">name</a>!';
            $expected = 'Hello &lt;a href=&quot;javascript:alert(&#039;ups&#039;);&quot;&gt;name&lt;/a&gt;!';
            $this->assertEquals($expected, $twig->render('{{ body | converturls }}', array('body' => $body)));
        }
    }
}
