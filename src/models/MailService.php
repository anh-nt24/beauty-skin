<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MailService {

    private $mailer;

    public function __construct() {
        $this->mailer = new PHPMailer(true);

        // SMTP server settings
        $this->mailer->isSMTP();
        $this->mailer->Host = 'smtp.gmail.com';
        $this->mailer->SMTPAuth = true;
        $this->mailer->Username = 'beautyskin.business.03@gmail.com';
        $this->mailer->Password = 'riyi ozbq omae uoge';
        $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->mailer->Port = 587;
        $this->mailer->setFrom('beautyskin.business.03@gmail.com', 'BeautySkin Support');
    }

    public function sendMail($to, $subject, $content) {
        try {
            $this->mailer->addAddress($to);
            $this->mailer->isHTML(true);
            $this->mailer->Subject = $subject;
            $this->mailer->Body = $content;

            return $this->mailer->send();
        } catch (Exception $e) {
            error_log('Mail could not be sent. Error: ' . $this->mailer->ErrorInfo);
            return false;
        }
    }
    
    public function sendPasswordResetEmail($email, $resetToken) {
        $subject = 'BeautySkin Password Reset Request';
        $content = $this->generatePasswordResetEmailContent($resetToken);

        return $this->sendMail($email, $subject, $content);
    }

    private function generatePasswordResetEmailContent($resetToken) {
        $resetUrl = "http://localhost/beauty-skin/password/reset-password?token=" . $resetToken;

        return "
            <html>
            <body style='font-family: Arial, sans-serif; color: #333;'>
                <h2 style='color: #4CAF50;'>Password Reset Request</h2>
                <p>Hi,</p>
                <p>We received a request to reset your BeautySkin password. If you did not make this request, please ignore this email.</p>
                <p>Otherwise, click the button below to reset your password:</p>
                <p style='text-align: center;'>
                    <a href='$resetUrl' style='display: inline-block; padding: 12px 20px; margin: 10px; font-size: 16px; color: white; background-color: #4CAF50; text-decoration: none; border-radius: 5px;'>Reset Password</a>
                </p>
                <br>
                <p>Thank you,<br>The BeautySkin Team</p>
            </body>
            </html>
        ";
    }
}