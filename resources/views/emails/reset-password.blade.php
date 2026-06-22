<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Website Desa Kalimanah Wetan</title>
</head>
<body style="margin: 0; padding: 0; width: 100%; background-color: #ffffff; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; -webkit-font-smoothing: antialiased; line-height: 1.5; color: #1a202c;">

    <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="margin: 0; padding: 0; width: 100%; background-color: #ffffff;">
        <tr>
            <td align="center" style="padding: 40px 20px;">
                
                <!-- Container -->
                <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="max-width: 600px; margin: 0 auto;">
                    
                    <!-- Content -->
                    <tr>
                        <td style="padding: 0 0 32px;">
                            
                            <h1 style="margin: 0 0 16px; font-size: 20px; font-weight: 600; color: #1a202c;">Halo!</h1>
                            
                            <p style="margin: 0 0 24px; font-size: 16px; color: #4a5568;">
                                Anda menerima email ini karena kami menerima permintaan reset password untuk akun Anda.
                            </p>
                            
                            <!-- Button -->
                            <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="margin: 32px 0;">
                                <tr>
                                    <td align="center">
                                        <a href="{{ $url }}" style="display: inline-block; padding: 12px 24px; background-color: #1a202c; color: #ffffff; text-decoration: none; border-radius: 6px; font-size: 16px; font-weight: 500;">
                                            Reset Password
                                        </a>
                                    </td>
                                </tr>
                            </table>
                            
                            <p style="margin: 24px 0 0; font-size: 16px; color: #4a5568;">
                                Link reset password ini akan kadaluarsa dalam <strong>60 menit</strong>.
                            </p>
                            
                            <p style="margin: 16px 0 0; font-size: 16px; color: #4a5568;">
                                Jika Anda tidak meminta reset password, abaikan email ini.
                            </p>
                            
                        </td>
                    </tr>
                    
                    <!-- Footer -->
                    <tr>
                        <td style="padding: 24px 0; border-top: 1px solid #e2e8f0;">
                            <p style="margin: 0 0 4px; font-size: 16px; color: #4a5568;">
                                Hormat kami,
                            </p>
                            <p style="margin: 0; font-size: 16px; color: #4a5568;">
                                <strong>Website Desa Kalimanah Wetan</strong>
                            </p>
                        </td>
                    </tr>
                    
                    <!-- Fallback URL -->
                    <tr>
                        <td style="padding: 16px 0 0;">
                            <p style="margin: 0; font-size: 14px; color: #718096;">
                                Jika tombol "Reset Password" tidak bisa diklik, salin dan tempel URL di bawah ini ke browser Anda:
                                <a href="{{ $url }}" style="color: #2563eb; text-decoration: underline; word-break: break-all;">
                                    {{ $url }}
                                </a>
                            </p>
                        </td>
                    </tr>
                    
                </table>
                
            </td>
        </tr>
    </table>

</body>
</html>