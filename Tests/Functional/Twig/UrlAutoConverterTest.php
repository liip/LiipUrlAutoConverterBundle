<?php

namespace Liip\UrlAutoConverterBundle\Tests\Functional\Twig;

use PHPUnit\Framework\TestCase;
use Liip\UrlAutoConverterBundle\Extension\UrlAutoConverterTwigExtension;

class UrlAutoConverterTest extends TestCase
{
    public function testEscapedHtml()
    {
        $loader = new \Twig_Loader_String();
        $twig = new \Twig_Environment($loader);
        $twig->addExtension(new UrlAutoConverterTwigExtension());

        $body = 'Hello <a href="javascript:alert(\'ups\');">name</a>!';
        $expected = 'Hello &lt;a href=&quot;javascript:alert(&#039;ups&#039;);&quot;&gt;name&lt;/a&gt;!';
        $this->assertEquals($expected, $twig->render('{{ body | converturls }}', array('body' => $body)));
    }
}
