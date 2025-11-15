<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;

class VerifyEmailNotification extends VerifyEmail
{
    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        return (new MailMessage)
            ->subject('Xác thực địa chỉ Email - TechShop')
            ->greeting('Xin chào!')
            ->line('Cảm ơn bạn đã đăng ký tài khoản tại TechShop!')
            ->line('Vui lòng nhấp vào nút bên dưới để xác thực địa chỉ email của bạn:')
            ->action('Xác thực Email', $verificationUrl)
            ->line('Link xác thực này sẽ hết hạn sau 60 phút.')
            ->line('Nếu bạn không tạo tài khoản này, vui lòng bỏ qua email này.');
    }

    /**
     * Get the verification URL for the given notifiable.
     */
    protected function verificationUrl($notifiable)
    {
        return URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );
    }
}
