<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Register</title>

    </head>
    <body>
        <div class="row">
            <div class="col-md-6" style="margin:5px">
                <p>NAME: {{ $name ?? 'ATP' }}</p>
                <p>TEL: {{ $tel ?? '0968636561' }}</p>
                <p>EMAIL: {{ $email ?? 'atp@mail.com' }}</p>
                <p>UID: {{ $userid ?? 'atp@mail.com' }}</p>
            </div>
        </div>
    </body>
</html>
