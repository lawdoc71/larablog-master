<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>New Blog Post Notification</title>

        <style>
            body {
                margin: 0;
                padding: 0;
                font-family: Arial, sans-serif;
                background-color: #f4f4f4;
                color: #333;
            }
            .email-container {
                max-width: 600px;
                margin: 20px auto;
                background-color: #ffffff;
                border: 1px solid #ddd;
                border-radius: 8px;
                overflow: hidden;
            }
            .header {
                background-color: #4CAF50;
                color: white;
                text-align: center;
                padding: 20px;
            }
            .content {
                padding: 20px;
            }
            .content img {
                max-width: 100%;
                height: auto;
                border-radius: 8px;
            }
            .content h1 {
                font-size: 24px;
                margin: 20px 0 10px;
            }
            .content p {
                font-size: 16px;
                line-height: 1.6;
            }
            .action-button {
                display: inline-block;
                background-color: #4CAF50;
                color: white;
                text-decoration: none;
                padding: 12px 20px;
                border-radius: 5px;
                font-size: 16px;
                margin-top: 20px;
            }
            .footer {
                background-color: #f4f4f4;
                text-align: center;
                padding: 10px;
                font-size: 14px;
                color: #888;
            }
            @media (max-width: 600px) {
                .content h1 {
                    font-size: 20px;
                }
                .content p {
                    font-size: 14px;
                }
                .action-button {
                    padding: 10px 16px;
                    font-size: 14px;
                }
            }
        </style>

    </head>

    <body>

        <div class="email-container">

            <!-- Header -->
            <div class="header">
                <h1>New Blog Post Alert 🚀</h1>
            </div>

            <!-- Content -->
            <div class="content">

                <img src="{{ asset('images/posts/'.$post->featured_image) }}" alt="Post Image">

                <h1>{{ $post->title }}</h1>

                <p>{!! Str::ucfirst(words($post->content,43)) !!}</p>

                <a href="{{ route('read_post',$post->slug) }}" class="action-button">Read Full Post</a>

            </div>

            <!-- Footer -->
            <div class="footer">

                <p>You're receiving this email because you're subscribed to our newsletter.</p>

                <p>
                    <a href="UNSUBSCRIBE_URL" style="color: #4CAF50; text-decoration: none;">Unsubscribe</a>
                </p>
                
            </div>

        </div>

    </body>

</html>
