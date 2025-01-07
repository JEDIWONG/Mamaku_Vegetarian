<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require '../vendor/phpmailer/PHPMailer-master/src/SMTP.php'; 
    require '../vendor/phpmailer/PHPMailer-master/src/PHPMailer.php';

class EmailNotification {
    private $mailer;

    public function __construct() {
        $this->mailer = new PHPMailer(true);

        try {
            // SMTP configuration
            $this->mailer->isSMTP();
            $this->mailer->Host = 'smtp.gmail.com'; // Replace with your SMTP server
            $this->mailer->SMTPAuth = true;
            $this->mailer->Username = 'jediwzk@gmail.com'; // Your email address
            $this->mailer->Password = 'gtgf etia tvjs sbbk'; // Your email password or app password
            $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $this->mailer->Port = 587;

            // Default sender details
            $this->mailer->setFrom('jediwzk@gmail.com', 'Mamaku Vegetarian');
        } catch (Exception $e) {
            throw new Exception("Mailer setup failed: " . $e->getMessage());
        }
    }

    public function sendEmail($toEmail, $toName, $subject, $body) {
        try {
            // Recipient details
            $this->mailer->addAddress($toEmail, $toName);

            // Email content
            $this->mailer->isHTML(true);
            $this->mailer->Subject = $subject;
            $this->mailer->Body = $body;
            $this->mailer->AltBody = strip_tags($body); // Fallback for non-HTML email clients

            $this->mailer->send();
            return true;
        } catch (Exception $e) {
            throw new Exception("Email sending failed: " . $this->mailer->ErrorInfo);
            
        }
    }
}
?>
