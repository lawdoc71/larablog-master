<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Contact Form Message</title>

        <style>
            /* General styling for responsiveness */
            body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 0;
                background-color: #f5f5f5;
                color: #333333;
            }
            table {
                max-width: 600px;
                width: 100%;
                margin: 20px auto;
                background-color: #ffffff;
                border-spacing: 0;
                border-collapse: collapse;
            }
            td {
                padding: 15px;
            }
            .header {
                background-color: #007BFF;
                color: #ffffff;
                text-align: center;
                font-size: 20px;
                padding: 20px;
            }
            .content {
                padding: 20px;
                font-size: 16px;
                line-height: 1.5;
            }
            .content p {
                margin: 0 0 10px;
            }
            .footer {
                background-color: #f0f0f0;
                text-align: center;
                padding: 10px;
                font-size: 12px;
                color: #666666;
            }
            @media only screen and (max-width: 480px) {
                .header {
                    font-size: 18px;
                }
                .content {
                    font-size: 14px;
                }
            }
        </style>

    </head>

    <body>
        <table>
            
            <!-- Header -->
            <tr>
                <td class="header">
                    New inquiry from contact form
                </td>
            </tr>

            <!-- Content -->
            <tr>
                <td class="content">
                    <p><strong>Name:</strong> {{ $name }}</p>
                    <p><strong>Email:</strong> {{ $email }}</p>
                    <p><strong>Message:</strong></p>
                    <p>{{ $message }}</p>
                </td>
            </tr>

            <!-- Footer -->
            <tr>
                <td class="footer">
                    This email was generated automatically. Please do not reply directly.
                </td>
            </tr>

        </table>
    </body>

</html>
