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
            ->greeting('Xin chào ' . $notifiable->name . ',')
            ->line('Cảm ơn bạn đã đăng ký tài khoản tại TechShop! Chúng tôi rất vui mừng được chào đón bạn.')
            ->line('Vui lòng nhấn vào nút bên dưới để xác thực địa chỉ email của bạn và kích hoạt tài khoản:')
            ->action('Xác thực Email', $verificationUrl)
            ->line('⏱️ Link có hiệu lực trong 15 phút.')
            ->line('')
            ->line('Nếu bạn không tạo tài khoản này, vui lòng bỏ qua email này hoặc liên hệ với bộ phận hỗ trợ nếu bạn có thắc mắc.')
            ->salutation('Đây là email tự động, vui lòng không trả lời!');
    }

    /**
     * Get the verification URL for the given notifiable.
     */
    protected function verificationUrl($notifiable)
    {
        return URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(15), // Changed from 60 to 15 minutes
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );
    }
}
