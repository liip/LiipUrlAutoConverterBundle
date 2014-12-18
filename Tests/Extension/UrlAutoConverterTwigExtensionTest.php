<?php

namespace Liip\UrlAutoConverterBundle\Tests\Extension;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Liip\UrlAutoConverterBundle\Extension\UrlAutoConverterTwigExtension;

class UrlAutoConverterTwigExtensionTest extends \PHPUnit_Framework_TestCase
{
    public function testGetFilters()
    {
        $classInstance = new UrlAutoConverterTwigExtension();
        $returnArray = $classInstance->getFilters();

        $this->assertIsArray($returnArray);
        $this->assertArrayHasKey('converturls', $returnArray);
        $this->assertInstanceOf('Twig_Filter_Method', $returnArray['converturls']);
        $this->assertEquals(array('html'), $returnArray['converturls']->getSafe(new \Twig_Node()));
    }

    public function provider()
    {
        return array(
            array(
                'Lorem ipsum dolor sit amet, <a href="http://www.test.com">www.test.com</a> consectetuer.',
                'Lorem ipsum dolor sit amet, www.test.com consectetuer.'
            ),
            array(
                'Lorem ipsum dolor sit amet, <a href="http://test.com">test.com</a> consectetuer adipiscing',
                'Lorem ipsum dolor sit amet, test.com consectetuer adipiscing'
            )  ,
            array(
                'Lorem ipsum dolor sit amet, <a href="http://test.com">test.com</a> aksjdhasd.',
                'Lorem ipsum dolor sit amet, http://test.com aksjdhasd.'
            ),
            array(
                'Lorem ipsum dolor sit amet, <a href="http://www.test.com">www.test.com</a> aksjdhasd.',
                'Lorem ipsum dolor sit amet, http://www.test.com aksjdhasd.'
            ),
            array(
                'Lorem ipsum dolor sit amet, lala <a href="http://subtest.test.com">subtest.test.com</a> aksjdhasd.',
                'Lorem ipsum dolor sit amet, lala subtest.test.com aksjdhasd.'
            ),
            array(
                'Lorem ipsum dolor <a href="http://subsub.subtest.test.com">subsub.subtest.test.com</a> amet, lala aksjdhasd.',
                'Lorem ipsum dolor subsub.subtest.test.com amet, lala aksjdhasd.'
            ),
            array(
                'Lorem ipsum <a href="http://subsubsub.subtest.test.com">subsubsub.subtest.test.com</a> ad amet, lala aksjdhasd.',
                'Lorem ipsum subsubsub.subtest.test.com ad amet, lala aksjdhasd.'
            ),
            array(
                'Lorem ipsum <a href="http://www.test.com/kjsdsd/safs?dfa=kdjf&sfddf=dsafsd" class="" target="">www.test.com/kjsdsd/safs?dfa=kdjf&sfddf=dsafsd</a> ad amet, lala aksjdhasd.',
                'Lorem ipsum www.test.com/kjsdsd/safs?dfa=kdjf&sfddf=dsafsd ad amet, lala aksjdhasd.'
            ),
            array(
                'Lorem ipsum <a href="http://www.test.com/kjsdsd/safs.php?dfa=kdjf&sfddf=dsafsd" class="" target="">www.test.com/kjsdsd/safs.php?dfa=kdjf&sfddf=dsafsd</a> ad amet, lala aksjdhasd.',
                'Lorem ipsum www.test.com/kjsdsd/safs.php?dfa=kdjf&sfddf=dsafsd ad amet, lala aksjdhasd.'
            ),
            array(
                '<a href="#">testlink</a>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean <a href="http://www.che">www.che</a> chcommodo ligula.kkkk ligula.kkkkk dolor. Aenean massa. Cum <a href="http://sociis.com">sociis.com</a> natoque penatibus et magnis dis parturient montes, nascetur sub.sub.sub.something.com <a href="http://sub.sub.sub.something.com">sub.sub.sub.something.com</a> <a href="http://www.sub.sub.sub.something.com">www.sub.sub.sub.something.com</a> ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. <a href="mailto:andre.abt@liip.ch">andre.abt@liip.ch</a> Nulla consequat <a href="mailto:test@eisd.com">test@eisd.com</a> massa <a href="http://www.test.com/kjsdsd/safs?dfa=kdjf&amp;sfddf=dsafsd" title="http://www.test.com/kjsdsd/safs?dfa=kdjf&sfddf=dsafsd">www.test.com/kjsdsd/safs?df...</a> quis enim.',
                '<a href="#">testlink</a>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean www.che chcommodo ligula.kkkk ligula.kkkkk dolor. Aenean massa. Cum http://sociis.com natoque penatibus et magnis dis parturient montes, nascetur sub.sub.sub.something.com http://sub.sub.sub.something.com www.sub.sub.sub.something.com ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. andre.abt@liip.ch Nulla consequat test@eisd.com massa www.test.com/kjsdsd/safs?dfa=kdjf&sfddf=dsafsd quis enim.'
            ),
            array(
                'Lorem ipsum dolor sit amet, <a href="https://any.kind.of.domain.tld/">any.kind.of.domain.tld/</a> consectetuer.',
                'Lorem ipsum dolor sit amet, https://any.kind.of.domain.tld/ consectetuer.'
            ),
            array(
                'Lorem ipsum dolor sit amet, <a href="https://any.kind.of.domain.tld/with/path/of/any/depth.ext" title="https://any.kind.of.domain.tld/with/path/of/any/depth.ext">any.kind.of.domain.tld/with...</a> consectetuer adipiscing',
                'Lorem ipsum dolor sit amet, https://any.kind.of.domain.tld/with/path/of/any/depth.ext consectetuer adipiscing'
            ),
            array(
                'Lorem ipsum <a href="http://test.com">testlink</a> aksjdhasd',
                'Lorem ipsum <a href="http://test.com">testlink</a> aksjdhasd'
            ),
            array(
                'Lorem ipsum dolor sit amet, <a href="mailto:test@test.com">test@test.com</a> consectetuer.',
                'Lorem ipsum dolor sit amet, test@test.com consectetuer.'
            ),
            array(
                'Lorem ipsum <a href="mailto:test.test@test.com">test.test@test.com</a> dolor sit amet, consectetuer.',
                'Lorem ipsum test.test@test.com dolor sit amet, consectetuer.'
            ),
            array(
                'Lorem ipsum <a href="mailto:test.test.test@test.com">test.test.test@test.com</a> dolor sit amet, consectetuer.',
                'Lorem ipsum test.test.test@test.com dolor sit amet, consectetuer.'
            ),
            array(
                'Lorem ipsum dolor sit amet, -rs.ch consectetuer.',
                'Lorem ipsum dolor sit amet, -rs.ch consectetuer.'
            ),
            array(
                'Lorem ipsum dolor sit amet, &&re.name consectetuer.',
                'Lorem ipsum dolor sit amet, &&re.name consectetuer.'
            ),
            array(
                'Lorem ipsum dolor sit amet, &&http://re.name consectetuer.',
                'Lorem ipsum dolor sit amet, &&http://re.name consectetuer.'
            ),
            array(
                'Lorem ipsum test.fffff dolor sit amet, consectetuer.',
                'Lorem ipsum test.fffff dolor sit amet, consectetuer.'
            ),
            array(
                'Lorem ipsum t.fff dolor sit amet, consectetuer.',
                'Lorem ipsum t.fff dolor sit amet, consectetuer.'
            ),
            array(
                'Lorem ipsum dolor sit amet, <a href="http://re.name">re.name</a>. Period!',
                'Lorem ipsum dolor sit amet, http://re.name. Period!'
            ),
            array(
                'Lorem ipsum dolor sit amet, <a href="http://&&http://re.name" class="" target="">&&http://re.name</a>, really?',
                'Lorem ipsum dolor sit amet, &&http://re.name, really?'
            ),
            array(
                'Lorem ipsum dolor sit amet, <a href="http://re.name">re.name</a>, really?',
                'Lorem ipsum dolor sit amet, http://re.name, really?'
            ),
            array(
                'Lorem ipsum dolor sit amet, &&http://re.name?',
                'Lorem ipsum dolor sit amet, &&http://re.name?'
            ),
            array(
                'Lorem ipsum dolor sit amet, <a href="http://www.test.com/myÄcçènted/page.htm" class="" target="">http://www.test.com/myÄcçènted/page.htm</a> consectetuer.',
                'Lorem ipsum dolor sit amet, http://www.test.com/myÄcçènted/page.htm consectetuer.'
            ),
            array(
                'Lorem ipsum dolor sit amet, <a href="http://www.test.com/my_page(with_parentheses).htm" class="" target="">http://www.test.com/my_page(with_parentheses).htm</a> consectetuer.',
                'Lorem ipsum dolor sit amet, http://www.test.com/my_page(with_parentheses).htm consectetuer.'
            ),
            array(
                'Lorem ipsum dolor sit amet, <a href="http://test.com?param=1" class="" target="">http://test.com?param=1</a> consectetuer.',
                'Lorem ipsum dolor sit amet, http://test.com?param=1 consectetuer.'
            ),
        );
    }

    /**
     * @dataProvider provider
     */
    public function testAutoConvertUrls($a, $b)
    {
        $classInstance = new UrlAutoConverterTwigExtension();

        $this->assertEquals($a, $classInstance->autoconverturls($b));
    }

    private function assertIsArray($test)
    {
        $this->assertTrue(is_array($test));
    }
}
