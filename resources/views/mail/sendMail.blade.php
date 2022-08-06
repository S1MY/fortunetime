<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Merriweather:wght@700&family=Roboto:wght@400;700;900&display=swap');

        body {
            background: #F5F5F5;
            margin: 0;
            width: 100%;
            padding: 0;
            font-family: 'Roboto', sans-serif;
        }

        hr{
            background: #fff;
            margin: 15px 0;
        }

        .mainTable {
            background: #4168D2;
            box-shadow: 0px 0px 12px rgba(33, 33, 33, 0.1);
            width: 100%;
            margin: 0 auto;
            margin-top: 60px;
            padding: 40px 80px;
            min-height: 500px;
        }

        .logoTr {
            width: 100%;
            text-align: center;
        }

        .logoTr td {
            padding-bottom: 30px;
        }

        .logoTrTitle td {
            padding-bottom: 15px;
            text-transform: uppercase;
            font-size: 28px;
            line-height: 32px;
            font-weight: 900;
            color: #fff;
        }

        .logoTrHello td {
            font-size: 18px;
            line-height: 25px;
            letter-spacing: 0.5px;
            font-weight: 700;
            color: #fff;
            padding-bottom: 20px;
        }

        .logoTrHello td span,
        .logoTrHello td span a {
            font-family: 'Merriweather', sans-serif;
            padding: 5px 28px;
            background: #fff;
            color: #4168D2;
            margin-left: 5px;
        }

        .logoTrText td {
            font-size: 16px;
            line-height: 24px;
            color: #fff;
            padding-bottom: 0;
            font-weight: 400;
            text-align: left;
        }

        @media only screen and (max-width: 640px) {
            .mainTable {
                max-width: 540px;
                width: 100%;
                padding: 40px 60px;
            }

            .dopTable {
                max-width: 540px;
                width: 100%;
            }
        }

        @media only screen and (max-width: 540px) {
            .emailimage {
                width: 360px;
            }

            .mainTable {
                max-width: 414px;
                width: 100%;
                padding: 30px 40px;
            }

            .dopTable {
                max-width: 414px;
                width: 100%;
            }
        }

        @media only screen and (max-width: 460px) {
            .emailimage {
                width: 320px;
            }

            .mainTable {
                max-width: 360px;
                width: 100%;
                padding: 20px 20px;
            }

            .dopTable {
                max-width: 360px;
                width: 100%;
            }
        }

        @media only screen and (max-width: 360px) {
            .emailimage {
                width: 280px;
            }

            .mainTable {
                max-width: 320px;
                width: 100%;
                padding: 20px 20px;
            }

            .dopTable {
                max-width: 320px;
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <table class="mainTable">
        <tr class="logoTr">
            <td>
                <a href="{{ Request::root() }}" class="logotype">
                    <img src="{{ Request::root() }}/image/logotype.png" alt="emailimage" class="emailimage">
                </a>
            </td>
        </tr>
        <tr class="logoTr logoTrTitle">
            <td>Форма обратной связи</td>
        </tr>
        <tr class="logoTr logoTrHello">
            <td>Отправитель, <span><a href="mailto:{{ $email }}">{{ $name }}</a></span></td>
        </tr>
        <hr>
        <tr class="logoTr logoTrText">
            <td>Текст сообщения:</td>
        </tr>
        <tr class="logoTr logoTrText">
            <td>{{ $question }}</td>
        </tr>
    </table>
</body>

</html>
