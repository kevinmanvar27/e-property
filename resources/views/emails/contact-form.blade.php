<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>New Contact Form Submission</title>
  <style>
    body {
      font-family: 'Segoe UI', Roboto, Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #eef2f7;
      color: #333;
    }
    .email-wrapper {
      max-width: 650px;
      margin: 40px auto;
      background: #ffffff;
      border-radius: 14px;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
      overflow: hidden;
      border: 1px solid #e0e7ff;
    }
    .header {
      background: linear-gradient(135deg, #003085, #0055c4);
      color: #fff;
      text-align: center;
      padding: 40px 25px 30px;
    }
    .header h1 {
      margin: 0;
      font-size: 24px;
      font-weight: 600;
    }
    .header p {
      margin-top: 10px;
      font-size: 15px;
      opacity: 0.9;
    }
    .content {
      padding: 35px 30px;
    }
    .field {
      margin-bottom: 20px;
    }
    .field-label {
      font-weight: 600;
      color: #003085;
      text-transform: uppercase;
      font-size: 13px;
      margin-bottom: 6px;
      display: inline-block;
      letter-spacing: 0.5px;
    }
    .field-value {
      background-color: #f8fafc;
      border: 1px solid #e2e8f0;
      border-left: 5px solid #f5b020;
      padding: 12px 14px;
      border-radius: 6px;
      font-size: 15px;
      color: #444;
      line-height: 1.5;
    }
    .footer {
      background-color: #f9fafc;
      border-top: 1px solid #e2e8f0;
      text-align: center;
      padding: 25px 20px;
      font-size: 13px;
      color: #666;
    }
    .footer p {
      margin: 5px 0;
    }
    .highlight {
      color: #f5b020;
      font-weight: bold;
    }
  </style>
</head>
<body>
  <div class="email-wrapper">
    <div class="header">
      <!-- Base64 encoded logo for reliable email client display -->
        <img
          src="{{ $logoBase64 }}"
          alt="Website Logo"
          style="max-height:70px;margin-bottom:15px;border-radius:8px;">
      <h1>📬 New Contact Form Submission</h1>
      <p>You’ve received a new message from your website contact form</p>
    </div>

    <div class="content">
      <div class="field">
        <span class="field-label">Name</span>
        <div class="field-value">{{ $name }}</div>
      </div>

      <div class="field">
        <span class="field-label">Email</span>
        <div class="field-value">{{ $email }}</div>
      </div>

      @if($phone)
      <div class="field">
        <span class="field-label">Phone</span>
        <div class="field-value">{{ $phone }}</div>
      </div>
      @endif

      <div class="field">
        <span class="field-label">Subject</span>
        <div class="field-value">{{ $subject }}</div>
      </div>

      <div class="field">
        <span class="field-label">Message</span>
        <div class="field-value">{{ $messageBody }}</div>
      </div>
    </div>

    <div class="footer">
      <p>This email was sent from your <span class="highlight">website contact form</span>.</p>
      <p>Please respond to the customer as soon as possible.</p>
    </div>
  </div>
</body>
</html>