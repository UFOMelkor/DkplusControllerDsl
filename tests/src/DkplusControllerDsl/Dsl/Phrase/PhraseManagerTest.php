<?php
/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Dsl\Phrase
 * @author     Oskar Bley <oskar@programming-php.net>
 */

namespace DkplusControllerDsl\Dsl\Phrase;

use DkplusUnitTest\TestCase;
use Exception;

/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Dsl\Phrase
 * @author     Oskar Bley <oskar@programming-php.net>
 */
class PhraseManagerTest extends TestCase
{
    /** @var Dsl */
    private $manager;

    protected function setUp()
    {
        $this->manager = new PhraseManager();
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     * @testdox is a plugin manager
     */
    public function isPluginManager()
    {
        $this->assertInstanceOf('Zend\ServiceManager\AbstractPluginManager', $this->manager);
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function doesNotSharePluginsByDefault()
    {
        $this->assertFalse($this->manager->shareByDefault());
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function acceptsPhrases()
    {
        $phrase = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\Phrase\PhraseInterface');

        try {
            $this->manager->validatePlugin($phrase);
        } catch (Exception $e) {
            $this->fail('Phrases should pass the validation');
        }
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     * @expectedException \Zend\ServiceManager\Exception\RuntimeException
     * @expectedExceptionMessage Plugins must implement DkplusControllerDsl\Dsl\Phrase\PhraseInterface
     * @dataProvider provideInvalidPlugins
     * @testdox does not accept non-phrases
     */
    public function doesNotAccept($plugin)
    {
        $this->manager->validatePlugin($plugin);
    }

    public static function provideInvalidPlugins()
    {
        return array(
            array(null),
            array('foo'),
            array(4),
            array(new \stdClass())
        );
    }
}

