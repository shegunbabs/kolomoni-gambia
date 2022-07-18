<?php

namespace App\Notifications\API;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewDeviceOtp extends Notification
{
    use Queueable;

    private string $otp;
    /**
     * @var User
     */
    private User $user;

    /**
     * Create a new notification instance.
     *
     * @param string $otp
     * @param User $user
     */
    public function __construct(string $otp, User $user)
    {
        $this->otp = $otp;
        $this->user = $user;
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
            ->subject('OTP to register new device')
            ->greeting("Hello {$this->user->fullname},")
                    ->line('Use this OTP: '. $this->otp)
                    ->line('Thank you for using Kolomoni!');
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
}
