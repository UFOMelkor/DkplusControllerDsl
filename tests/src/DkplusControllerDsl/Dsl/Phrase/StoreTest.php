<?php
/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Dsl\Phrase
 * @author     Oskar Bley <oskar@programming-php.net>
 */

namespace DkplusControllerDsl\Dsl\Phrase;

use PHPUnit_Framework_TestCase as TestCase;

/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Dsl\Phrase
 * @author     Oskar Bley <oskar@programming-php.net>
 */
class StoreTest extends TestCase
{
    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     * @testdox is a modifiable phrase
     */
    public function isModifiablePhrase()
    {
        $this->assertInstanceOf('DkplusControllerDsl\Dsl\Phrase\ModifiablePhraseInterface', new Store(array()));
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function canRetrieveDataFromConstructorOptions()
    {
        $data = array('data' => 'to store');

        $phrase = new Store(array($data));
        $this->assertEquals($data, $phrase->getData());
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function canRetrieveDataFromOptions()
    {
        $data = array('data' => 'to store');

        $phrase = new Store(array());
        $phrase->setOptions(array('data' => $data));
        $this->assertEquals($data, $phrase->getData());
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function canRetrieveStorageTargetFromOptions()
    {
        $callable = function () {
        };

        $phrase = new Store(array());
        $phrase->setOptions(array('target' => $callable));
        $this->assertEquals($callable, $phrase->getTarget());
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function storesDataIntoStorageTarget()
    {
        $data = array('data' => 'to store');

        $storage = $this->getMock('stdClass', array('store'));
        $storage->expects($this->once())
                ->method('store')
                ->with($data);

        $phrase = new Store(array($data));
        $phrase->setOptions(array('target' => array($storage, 'store')));
        $phrase->execute($this->getMockForAbstractClass('DkplusControllerDsl\Dsl\ContainerInterface'));
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function allowsDataToBeCallable()
    {
        $data     = array('data' => 'to store');
        $dataFunc = function () use ($data) {
            return $data;
        };


        $storage = $this->getMock('stdClass', array('store'));
        $storage->expects($this->once())
                ->method('store')
                ->with($data);

        $phrase = new Store(array($dataFunc));
        $phrase->setOptions(array('target' => array($storage, 'store')));
        $phrase->execute($this->getMockForAbstractClass('DkplusControllerDsl\Dsl\ContainerInterface'));
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function canHandleAdditionalArguments()
    {
        $data = array('data' => 'to store');
        $foo  = 'foo';
        $bar  = 'bar';

        $storage = $this->getMock('stdClass', array('store'));
        $storage->expects($this->once())
                ->method('store')
                ->with($data, $foo, $bar);

        $phrase = new Store(array($data));
        $phrase->setOptions(array('target' => array($storage, 'store'), 'with' => array('foo', 'bar')));
        $phrase->execute($this->getMockForAbstractClass('DkplusControllerDsl\Dsl\ContainerInterface'));
    }
}
