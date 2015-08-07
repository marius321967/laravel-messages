### Laravel Messages

Add and handle user messages of custom types in Laravel.

#### Installation

Once installed, use add a Service Provider and a Facade in your `config/app.php` file:

`providers`:
`'marius321967\Messages\InfoMessageServiceProvider',`

`facades`:
`'Message'   => 'marius321967\Messages\MessageFacade'`


#### Usage

```php
// Show message in current page
if ($error) {
    \Message::add('Failed to perform operation', 'error');
}

// Show message in next page (flash)
if ($error) {
    \Message::flash('Failed to perform operation', 'error');
}
```

Show the added messages in your Blade template:
```php
@foreach (Message::getAll() as $message)
    <div class="message-{{ $message['type'] }}">{{ $message['message'] }}</div>
@endforeach
```