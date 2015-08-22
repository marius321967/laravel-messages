### Laravel Messages

Add and handle user messages of custom types in Laravel 5.

#### Installation

Once installed, add a Service Provider and a Facade in your `config/app.php` file:

`providers`:
`'marius321967\Messages\InfoMessageServiceProvider',`

`facades`:
`'Message'   => 'marius321967\Messages\MessageFacade'`

In `Kernel` class (`app/Http/Kernel.php`), add the following element to the `middleware` array:
```php
\marius321967\Messages\StoreFlashMessages::class
```
This will create a global filter that flashes the needed messages.

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
