<?php

namespace BroadHorizon\EventSourcing\Test\TestCase\Form;

use BroadHorizon\EventSourcing\Command;
use BroadHorizon\EventSourcing\CommandInterface;
use BroadHorizon\EventSourcing\Exception\ValidationException;
use BroadHorizon\EventSourcing\Form\CommandForm;
use BroadHorizon\EventSourcing\Payload;
use Cake\Cache\Cache;
use Cake\TestSuite\TestCase;
use Cake\Validation\Validator;

class TestCommand extends Command
{
    private $email;

    public function __construct($email)
    {
        $this->email = $email;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function toPayload(): Payload
    {
        return new Payload([
            'email' => $this->email,
        ]);
    }

    public static function fromPayload(Payload $payload): CommandInterface
    {
        return new static($payload->get('email'));
    }

    public static function validator(): Validator
    {
        $validator = new Validator();

        return $validator
            ->email('email');
    }
}

class CommandFormTest extends TestCase
{
    public function testWithCorrectData()
    {
        $commandForm = new CommandForm(TestCommand::class);

        $testCommand = $commandForm->execute([
            'email' => 'info@true.nl',
        ]);
        $this->assertEquals('info@true.nl', $testCommand->getEmail());
    }

    /**
     * @expectedException BroadHorizon\EventSourcing\Exception\ValidationException
     */
    public function testWithInCorrectData()
    {
        $commandForm = new CommandForm(TestCommand::class);

        $commandForm->execute([
            'email' => 'Invalid e-mail',
        ]);
    }

    public function testWithInCorrectValidationErrorCount()
    {
        $commandForm = new CommandForm(TestCommand::class);

        try {
            $commandForm->execute([
                'email' => 'Invalid e-mail',
            ]);
        } catch (ValidationException $exception) {
            $this->assertEquals(1, $exception->getValidationErrorCount());
            $this->assertArrayHasKey('email', $exception->getValidationErrors());
        }
    }
}
