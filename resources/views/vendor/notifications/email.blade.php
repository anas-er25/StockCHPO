<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f7f8fa;
        }
        .email-wrapper {
            width: 100%;
            background-color: #ffffff;
            padding: 40px 20px;
            box-sizing: border-box;
        }
        .email-content {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            border: 1px solid #e4e4e4;
            text-align: center;
        }
        h1 {
            font-size: 26px;
            color: #333;
            font-weight: 600;
            margin-bottom: 20px;
        }
        .greeting, .intro-lines, .outro-lines {
            margin: 15px 0;
            font-size: 16px;
            color: #555;
            line-height: 1.6;
        }
        .button {
            display: inline-block;
            padding: 12px 25px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 20px;
            text-align: center;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }
        .button:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
        }
        .salutation {
            font-size: 16px;
            margin-top: 20px;
            color: #555;
        }
        .subcopy {
            font-size: 14px;
            color: #555;
            margin-top: 15px;
            line-height: 1.5;
        }
        .custom-message {
            background-color: #e9f7f4;
            border-left: 5px solid #28a745;
            padding: 15px 20px;
            margin-top: 25px;
            font-style: italic;
            color: #333;
            font-weight: 600;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="email-content">
            <!-- Greeting -->
            <h1>
                {{ isset($greeting) ? $greeting : (now()->hour < 18 ? 'Bonjour,' : 'Bonsoir,') }}
            </h1>

            <!-- Intro Lines -->
            <div class="intro-lines">
                @foreach ($introLines as $line)
                    <p>{{ $line }}</p>
                @endforeach
            </div>

            <!-- Action Button -->
            @isset($actionText)
                <?php
                    $buttonColor = match($level) {
                        'success', 'error' => $level,
                        default => 'primary',
                    };
                ?>
                <a href="{{ $actionUrl }}" class="button" style="background-color: {{ $buttonColor }};">
                    {{ $actionText }}
                </a>
            @endisset

            <!-- Outro Lines -->
            <div class="outro-lines">
                @foreach ($outroLines as $line)
                    <p>{{ $line }}</p>
                @endforeach
            </div>

            <!-- Custom Message Section -->
            @isset($customMessage)
                <div class="custom-message">
                    <p><strong>{{ $customMessage }}</strong></p>
                </div>
            @endisset

            <!-- Salutation -->
            <div class="salutation">
                {{ isset($salutation) ? $salutation : 'Cordialement,' }}<br>
                <strong>{{ config('app.name') }}</strong>
            </div>

            <!-- Subcopy -->
            @isset($actionText)
                <div class="subcopy">
                    <p>Si vous rencontrez des difficultés pour cliquer sur le bouton  <strong>{{ $actionText }}</strong>, copiez et collez l'URL ci-dessous dans votre navigateur Web :</p>
                    <p><a href="{{ $actionUrl }}" style="word-break: break-all; color: #007bff;">{{ $actionUrl }}</a></p>
                </div>
            @endisset
        </div>
    </div>
</body>
</html>
