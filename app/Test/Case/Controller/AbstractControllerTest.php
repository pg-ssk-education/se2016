<?php
class AbstractControllerTest extends ControllerTestCase
{
    public function assertModelEquals($expected, $actual)
    {
        foreach ($expected as $key => $value) {
            $this->assertEquals($value, $actual[$key]);
        }
    }

    public function assertMessageContains($type, $message)
    {
        $this->assertContains($message, serialize(CakeSession::read('Message.alert-' . $type)));
    }
}
