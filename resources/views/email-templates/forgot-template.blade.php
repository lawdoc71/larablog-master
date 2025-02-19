<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <style>
            body {
                margin: 0;
                padding: 0;
                font-family: Arial, sans-serif;
                background-color: #f6f6f6;
            }
            .email-container {
                width: 100%;
                max-width: 600px;
                margin: 0 auto;
                background-color: #ffffff;
                padding: 20px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }
            .email-header {
                text-align: center;
                padding: 20px 0;
                background-color: #0073e6;
                color: #ffffff;
            }
            .email-body {
                padding: 20px;
                color: #333333;
                line-height: 1.6;
            }
            .email-body h1 {
                font-size: 24px;
                margin-bottom: 20px;
            }
            .email-body p {
                margin-bottom: 20px;
            }
            .reset-button {
                display: block;
                width: 100%;
                max-width: 200px;
                margin: 20px auto;
                padding: 15px;
                text-align: center;
                background-color: #0073e6;
                color: #ffffff !important;
                text-decoration: none;
                border-radius: 5px;
            }
            .email-footer {
                text-align: center;
                padding: 20px;
                color: #999999;
            }
            @media (max-width: 600px) {
                .email-container {
                    padding: 10px;
                }
                .reset-button {
                    width: 100%;
                }
            }
        </style>

    </head>

    <body>
        <div class="email-container">

            <div class="email-header">
                <h1>Reset Your Password</h1>
            </div>

            <div class="email-body">

                <h4>Hello {{ $user->name }},</h4>

                <p>You requested a password reset. Please, click the button below to reset your password.</p>

                <a href="{{ $actionlink }}" target="_blank" class="reset-button">Reset Password</a>

                <p>The link is valid only for 15 minutes.</p>

                <p>If you did not request a password reset, please ignore this email, or contact support if you have questions.</p>

                <p>Thanks,<br>Support Team at Butler Transport</p>

            </div>

            {{-- footer --}}
            <div class="email-footer">
                <p>&copy; {{ date('Y') }} Butler Transport. All rights reserved.</p>
            </div>

        </div>
    </body>

</html>
