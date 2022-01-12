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

    private $messageStore;
    private $middleware;
    
    protected function setUp(): void {
        parent::setUp();

        $this->messageStore = new MessageStore();
        $this->middleware = new FlashMessages($this->messageStore);
    }

    /**
     * - flashes container's messages for next request
     * - passes response
     * 
     * @test
     */
    public function testTwoMessages(): void {
        // Given
        $this->messageStore->flash('Message #1', 'info', false);
        $this->messageStore->flash('Message #2: trusted HTML', 'success', true);

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
        $this->middleware->handle($request, function() use ($response) { return $response; });
    }

    /**
     * - no flashing when store is empty
     * 
     * @test
     */
    public function testEmpty(): void {
        $session = $this->mock(Store::class, function($mock) { 
            $mock->shouldNotReceive('flash');
        });
        
        $request = new Request();
        $request->setLaravelSession($session);
        $response = new Response();

        // Execute
        $this->middleware->handle($request, function() use ($response) { return $response; });
    }

}
