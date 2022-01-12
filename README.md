### Laravel Messages

Add and handle user messages of custom types in Laravel.

#### Installation
`composer require marius321967/laravel-messages`

#### Usage
Inject `marius321967\Messages\MessageStore` or use facade `marius321967\Messages\Facades\Message`

```php
// Show message in current page
if ($error) {
    $store->add('Failed to perform operation', 'error');
}

// Show message in next page (flash)
if ($error) {
    $store->flash('Failed to perform operation', 'error');
}
```

Show the added messages in your Blade template:
```php
@foreach (\marius321967\Messages\Facades\Message::getActiveMessages() as $message)
    <div class="message-{{ $message->type() }}">{{ $message->message() }}</div>
@endforeach
```
