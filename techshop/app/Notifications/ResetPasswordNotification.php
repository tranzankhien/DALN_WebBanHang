<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification extends ResetPassword
{
    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        $url = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        return (new MailMessage)
            ->subject('Thay đổi mật khẩu - TechShop')
            ->greeting('Xin chào ' . $notifiable->name . ',')
            ->line('Chúng tôi đã nhận được yêu cầu đặt lại mật khẩu cho tài khoản của bạn. Vui lòng nhấn vào nút bên dưới để tiếp tục.')
            ->action('Đặt lại mật khẩu', $url)
            ->line('Nếu nút không hoạt động, bạn có thể sao chép và dán liên kết sau vào trình duyệt:')
            ->line($url)
            ->line('')
            ->line('⏱️ Link có hiệu lực trong 15 phút.')
            ->line('')
            ->line('Nếu bạn không yêu cầu đặt lại mật khẩu, vui lòng bỏ qua email này hoặc liên hệ với bộ phận hỗ trợ nếu bạn có thắc mắc.')
            ->line('')
            ->salutation('Đây là email tự động, vui lòng không trả lời!');
    }
}
