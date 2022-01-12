<?php

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Session\Store;
use marius321967\Messages\Message;
use marius321967\Messages\MessageStore;
use marius321967\Messages\Middleware\LoadFlashedMessages;
use Orchestra\Testbench\TestCase;

class LoadFlashedMessagesUnitTest extends TestCase
{

    /** @var MessageStore */
    private $messageStore;
    /** @var LoadFlashedMessages */
    private $middleware;
    /** @var Store */
    private $session;
    /** @var Request */
    private $request;
    /** @var Closure */
    private $genericNext;

    protected function setUp(): void {
        parent::setUp();

        $this->messageStore = new MessageStore();
        $this->middleware = new LoadFlashedMessages($this->messageStore);
        $this->session = $this->app->make(Store::class);

        $this->request = $this->app->make(Request::class);
        $this->request->setLaravelSession($this->session);
        
        $this->genericNext = function() { return new Response(); };
    }

    /**
     * - loads messages from session storage
     * - cleared session storage
     * 
     * @test
     */
    public function testTwoMessages(): void {
        // Given
        $this->session->put('flash_messages', [
            new Message('Resource saved successfully', 'success', true),
            new Message('XSS attempt <script></script>', 'danger', false),
        ]);

        // When
        $this->middleware->handle($this->request, function() {
            // Then
            $messages = $this->messageStore->getActiveMessages();
            $secondMessage = $messages[1];
            $this->assertCount(2, $messages);
            $this->assertEquals($secondMessage->message(), 'XSS attempt <script></script>');
            $this->assertEquals($secondMessage->type(), 'danger');
            $this->assertEquals($secondMessage->trusted(), false);
            $this->assertEmpty($this->session->get('flash_messages')); 
        });
    }

    /**
     * - empty message store when request loaded empty ssession variable
     * 
     * @test
     */
    public function testEmpty(): void {
        // Given
        // ...

        // When
        $this->middleware->handle(
            $this->request,
            function($request) {
                // Then
                $this->assertEmpty($this->messageStore->getActiveMessages());
            }
        );
    }

    /**
     * @test
     */
    public function testReturnsResponse() {
        $response = $this->middleware->handle($this->request, $this->genericNext);

        $this->assertInstanceOf(Response::class, $response);
    }

}
