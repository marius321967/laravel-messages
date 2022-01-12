<?php

use Illuminate\Http\Request;
use Illuminate\Session\Store;
use marius321967\Messages\Message;
use marius321967\Messages\MessageStore;
use marius321967\Messages\Middleware\LoadFlashedMessages;
use Orchestra\Testbench\TestCase;

class LoadFlashedMessagesUnitTest extends TestCase
{

    /**
     * - loads messages from session storage
     * - cleared session storage
     * 
     * @test
     */
    public function testMiddleware(): void {
        // Given
        $messageStore = new MessageStore();

        $middleware = new LoadFlashedMessages($messageStore);

        $sessionStore = app(Store::class);
        $sessionStore->put('flash_messages', [
            new Message('Resource saved successfully', 'success', true),
            new Message('XSS attempt <script></script>', 'danger', false),
        ]);

        $request = new Request();
        $request->setLaravelSession($sessionStore);

        // When
        $middleware->handle($request, function() use ($messageStore, $sessionStore) {
            // Then
            $messages = $messageStore->getActiveMessages();
            $secondMessage = $messages[1];
            $this->assertCount(2, $messages);
            $this->assertEquals($secondMessage->message(), 'XSS attempt <script></script>');
            $this->assertEquals($secondMessage->type(), 'danger');
            $this->assertEquals($secondMessage->trusted(), false);
            $this->assertEmpty($sessionStore->get('flash_messages')); 
        });
    }

}
