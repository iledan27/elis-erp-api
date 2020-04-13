<?php

namespace App\Notifications;

use Browser;
use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class RegisterDevice extends Notification
{
    use Queueable;

    protected $request;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Register Device to ElisERP')
                    ->line('You need to first register your device to have access to the api!')
                    ->line('Your device has ' . Browser::platformName() . ' OS and the browser is '. Browser::browserFamily())
                    ->line('You have one minute to complete the registration after the link will expire!')
                    ->action('Register Device', $this->getURL($notifiable))
                    ->line("If you didn't register any device, simply ignore this e-mail!")
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }

    protected function getURL($notifiable) {
        return URL::temporarySignedRoute(
            'verification.device',
            Carbon::now()->addMinutes(1),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($this->request->server('HTTP_USER_AGENT')),
            ]
        );
    }
}
