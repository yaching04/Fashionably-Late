<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>お問い合わせ完了</title>
    <link rel="stylesheet" href="{{ asset('css/layouts/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/layouts/layout.css') }}">
    <link rel="stylesheet" href="{{ asset('css/contacts/thanks.css') }}">
</head>

<body>

<div class="contact-page">

    <div class="contact-container">

        <div class="thanks-content">
            <h1>お問い合わせありがとうございました</h1>

            <div class="thanks-button">
                <a href="{{ route('contacts.index') }}" class="btn">
                    HOME
                </a>
            </div>
        </div>

    </div>
</div>

</body>
</html>
