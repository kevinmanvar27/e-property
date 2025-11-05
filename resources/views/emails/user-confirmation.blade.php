<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Thank you for contacting us</title>
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
      background: linear-gradient(135deg, #00a86b, #00c980);
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
    .message-box {
      background-color: #f0fdf4;
      border: 1px solid #bbf7d0;
      border-left: 5px solid #00a86b;
      padding: 20px;
      border-radius: 6px;
      font-size: 16px;
      color: #444;
      line-height: 1.6;
      margin-bottom: 25px;
    }
    .details {
      background-color: #f8fafc;
      border: 1px solid #e2e8f0;
      padding: 20px;
      border-radius: 6px;
    }
    .detail-item {
      margin-bottom: 15px;
      display: flex;
    }
    .detail-label {
      font-weight: 600;
      color: #00a86b;
      min-width: 100px;
      font-size: 14px;
    }
    .detail-value {
      flex: 1;
      font-size: 15px;
      color: #444;
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
      color: #00a86b;
      font-weight: bold;
    }
    .icon {
      font-size: 48px;
      margin-bottom: 15px;
    }
  </style>
</head>
<body>
  <div class="email-wrapper">
    <div class="header">
      <!-- Base64 encoded logo for reliable email client display -->
      <img
        src="{{ asset('storage/' . \App\Models\Setting::get('general', 'logo')) }}"
        alt="Website Logo"
        style="max-height:70px;margin-bottom:15px;border-radius:8px;"
        onerror="this.style.display='none';"/>

      <h1>Thank You for Reaching Out!</h1>
      <p>We've received your message and will get back to you soon</p>
    </div>

    <div class="content">
      <div class="message-box">
        Hello {{ $name }},<br><br>
        We received your mail and will be shortly contact in 24 hours.<br><br>
        Our team is reviewing your message and will reach out to you at {{ $email }} as soon as possible.<br><br>
        Thank you for contacting us!
      </div>

    </div>

    <div class="footer">
      <p>This is an automated confirmation of your contact form submission.</p>
      <p>If you have any urgent inquiries, please contact us directly.</p>
    </div>
  </div>
</body>
</html>