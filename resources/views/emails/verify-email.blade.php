<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Verify Your Email Address</title>
  <style>
    body {
      font-family: 'Segoe UI', Roboto, Arial, sans-serif;
      background-color: #eef2f7;
      margin: 0;
      padding: 0;
      color: #333;
    }

    .email-wrapper {
      max-width: 650px;
      margin: 40px auto;
      background: #fff;
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
      font-size: 26px;
      font-weight: 600;
    }

    .content {
      padding: 35px 30px;
      font-size: 16px;
      line-height: 1.7;
    }

    .content p {
      margin: 15px 0;
      color: #444;
    }

    .verify-button {
      background-color: #003085;
      color: #f5b020 !important;
      text-decoration: none;
      padding: 14px 34px;
      border-radius: 6px;
      display: inline-block;
      font-weight: bold;
      font-size: 16px;
      letter-spacing: 0.3px;
      margin-top: 25px;
      transition: all 0.3s ease;
      box-shadow: 0 4px 10px rgba(0, 48, 133, 0.25);
    }

    .verify-button:hover {
      background-color: #f5b020;
      color: #003085 !important;
      transform: translateY(-1px);
    }

    .link-box {
      background-color: #f8fafc;
      border: 1px solid #e2e8f0;
      border-radius: 6px;
      padding: 12px 15px;
      word-break: break-all;
      font-size: 14px;
      color: #555;
    }

    .note {
      background-color: #fff7e6;
      padding: 15px;
      border-left: 5px solid #f5b020;
      border-radius: 6px;
      margin: 25px 0;
      color: #704c00;
      font-size: 14px;
      line-height: 1.6;
    }

    .footer {
      background-color: #f9fafc;
      text-align: center;
      border-top: 1px solid #e2e8f0;
      padding: 25px 20px;
      font-size: 13px;
      color: #666;
    }

    .footer a {
      color: #003085;
      text-decoration: none;
      font-weight: 600;
    }

    @media (max-width: 600px) {
      .email-wrapper {
        margin: 20px;
      }
      .content {
        padding: 25px 20px;
      }
      .verify-button {
        width: 100%;
        text-align: center;
      }
    }
  </style>
</head>
<body>
  <div class="email-wrapper">
    <div class="header">
      <!-- Base64 encoded logo for reliable email client display -->
      @if(isset($logoBase64))
        <img src="{{ $logoBase64 }}" alt="Website Logo" style="max-height: 70px; margin-bottom: 15px; border-radius: 8px;">
      @endif
      <h1>Verify Your Email Address</h1>
    </div>

    <div class="content">
      <p>Hello {{ $user->name }},</p>

      <p>Thank you for registering with us! To complete your sign-up and unlock all features, please verify your email address by clicking the button below:</p>

      <div style="text-align: center;">
        <a href="{{ $url }}" class="verify-button">Verify Email Address</a>
      </div>

      <p>If the button above doesn’t work, you can copy and paste the link below into your browser:</p>

      <div class="link-box">
        {{ $url }}
      </div>

      <div class="note">
        <strong>Note:</strong> This verification link will expire in 60 minutes for security reasons. If you didn’t create an account, please ignore this email.
      </div>
    </div>

    <div class="footer">
      <p>Need help? Contact our <a href="{{ config('app.support_url', '#') }}">support team</a>.</p>
      <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
    </div>
  </div>
</body>
</html>