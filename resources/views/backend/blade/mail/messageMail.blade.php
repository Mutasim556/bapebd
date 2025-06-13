<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Reply from {{ $institute }}</title>
</head>
<body style="margin:0; padding:0; background-color:#f4f4f4; font-family:Arial, sans-serif;">
  <table cellpadding="0" cellspacing="0" width="100%" style="background-color:#f4f4f4; padding: 20px;">
    <tr>
      <td>
        <table align="center" cellpadding="0" cellspacing="0" width="600" style="background-color:#ffffff; border-radius:8px; overflow:hidden;">
          <!-- Header -->
          <tr style="background-color:#00b58b;">
            <td style="padding: 20px; color:#ffffff; text-align: center;">
              <h2 style="margin:0;">{{ $institute }}</h2>
              <p style="margin:0; font-size: 14px;">Bangladesh Institute of Pharmaceutical Excellence</p>
            </td>
          </tr>

          <!-- Body -->
          <tr>
            <td style="padding: 30px; color:#333333;">
              <p style="font-size: 16px;">Dear {{ $name }},</p>

              <p style="font-size: 15px; line-height:1.6;">
                Thank you for reaching out to us. We appreciate your message and would like to respond as follows:
              </p>

              <div style="background-color:#f9f9f9; padding:15px 20px; border-left:4px solid #00b58b; margin:20px 0; font-size:14px; color:#555;">
                {{ $reply_message }}
              </div>

              <p style="font-size: 15px; line-height:1.6;">
                If you have any further questions or need additional assistance, feel free to reply to this email.
              </p>

              <p style="font-size: 15px;">Best regards,<br><strong>{{ $institute }} Team</strong></p>
            </td>
          </tr>

          <!-- Footer -->
          <tr>
            <td style="background-color:#eeeeee; padding: 20px; text-align:center; font-size: 12px; color:#888;">
              <p style="margin:0;">© {{ date('Y') }} {{ $institute }}. All rights reserved.</p>
              <p style="margin:0;">Email: {{ $bipedbemail }} | Web: <a href="{{ $institute_website }}" style="color:#00b58b; text-decoration:none;">{{ $institute_website }}</a></p>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>
</html>
