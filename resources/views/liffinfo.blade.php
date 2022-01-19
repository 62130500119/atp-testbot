<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Info</title>
    </head>
    <body>
        <script src="https://static.line-scdn.net/liff/edge/versions/2.3.0/sdk.js"></script>
        <script>
            function runApp() {
              liff.getProfile().then(profile => {
                window.location.href="/liff/info?uid="+profile.userId;
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
        <?php
            $uid = $_GET["uid"]
            $member = App\Models\Member::where('uid',$uid);
            if(is_null($name)){
            $name = $member->name;
            }
            if(is_null($tel)){
            $tel = $member->tel;
            }
            if(is_null($email)){
            $email = $member->email;
            }
             ?>
        <div class="row">
            <div class="col-md-6" style="margin:5px">
                <p>NAME: {{ $name }}</p>
                <p>TEL: {{ $tel }}</p>
                <p>EMAIL: {{ $email }}</p>
            </div>
        </div>
    </body>
</html>
