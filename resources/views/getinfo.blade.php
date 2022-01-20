<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Info</title>
    </head>
    <body>
        <div class="row" id="showInfo" hidden="true">
            <div class="col-md-6" style="margin:5px">
                <p>NAME: <strong id="name"></strong> </p>
                <p>TEL: <strong id="tel"></strong></p>
                <p>EMAIL: <strong id="email"></strong></p>
            </div>
        </div>
        <script src="https://static.line-scdn.net/liff/edge/versions/2.3.0/sdk.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script>
            const ROUTE_URL = "{{ URL::to('/api/get/info') }}";
            function runApp() {
              liff.getProfile().then(profile => {
                $.post(ROUTE_URL,{'userid': profile.userId}, function (data) {
                if(data != null){
                    document.getElementById('name').innerHTML = data.name;
                    document.getElementById('tel').innerHTML = data.tel;
                    document.getElementById('email').innerHTML = data.email;
                    document.getElementById('showInfo').hidden = false;
                }
                });
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
