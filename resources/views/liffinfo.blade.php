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
                {{-- <p>NAME: {{ $name ?? 'ATP' }}</p>
                <p>TEL: {{ $tel ?? '0968636561' }}</p>
                <p>EMAIL: {{ $email ?? 'atp@mail.com' }}</p> --}}
                <p>UID: <strong id="uid"></strong></p>
                <p>NAME: <strong id="name"></strong></p>
                <p>TEL: <strong id="tel"></strong></p>
                <p>EMAIL: <strong id="email"></strong></p>
            </div>
        </div>
        <script src="https://static.line-scdn.net/liff/edge/versions/2.3.0/sdk.js"></script>
        <script>
            function runApp() {
              liff.getProfile().then(profile => {
                document.getElementById("name").src = profile.pictureUrl;
                document.getElementById("uid").innerHTML = '<b>UserId:</b> ' + profile.userId;
                document.getElementById("tel").innerHTML = '<b>DisplayName:</b> ' + profile.displayName;
                document.getElementById("email").innerHTML = '<b>StatusMessage:</b> ' + profile.statusMessage;
              }).catch(err => console.error(err));
            }
            liff.init({ liffId: "1656819334-zJP6arE9" }, () => {
              if (liff.isLoggedIn()) {
                runApp()
              } else {
                liff.login();
              }
            }, err => console.error(err.code, error.message));
          </script>
    </body>
</html>
