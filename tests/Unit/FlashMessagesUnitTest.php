<?php

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Session\Store;
use marius321967\Messages\Message;
use marius321967\Messages\MessageStore;
use marius321967\Messages\Middleware\FlashMessages;
use Orchestra\Testbench\TestCase;

class FlashMessagesUnitTest extends TestCase
{

    /**
     * - flashes container's messages for next request
     * - passes response
     * 
     * @test
     */
    public function testMiddleware(): void {
        // Given
        $messageStore = new MessageStore();
        $messageStore->flash('Message #1', 'info', false);
        $messageStore->flash('Message #2: trusted HTML', 'success', true);

        $middleware = new FlashMessages($messageStore);

        $session = $this->mock(Store::class, function($mock) { 
            $mock->shouldReceive('flash')
                ->with('flash_messages', [
                    new Message('Message #1', 'info', false),
                    new Message('Message #2: trusted HTML', 'success', true),
                ]);
        });

        $request = new Request();
        $request->setLaravelSession($session);
        $response = new Response();

        // Execute
        $middleware->handle($request, function() use ($response) { return $response; });
    }

}
