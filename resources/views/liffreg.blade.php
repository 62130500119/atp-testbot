<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Register</title>
    </head>
    <body>
        <form action="info" method="get">
            <div class="row">
                <div class="col-md-6" style="margin:5px">
                    <input class="form-control" type="hidden" id="userid" name="userid" value=""/> <br />
                    <label>NAME:</label><br />
                    <input class="form-control" type="text" id="name" name="name" /><br />
                    <label>TEL:</label><br />
                    <input class="form-control" type="text" id="tel" name="tel" /><br />
                    <label>EMAIL:</label><br />
                    <input class="form-control" type="text" id="email" name="email" /><br />
                    <br />
                    <button class="btn btn-primary">ลงทะเบียน</button>
                </div>
            </div>
        </form>
        <script src="https://static.line-scdn.net/liff/edge/versions/2.3.0/sdk.js"></script>
        <script>
            function runApp() {
              liff.getProfile().then(profile => {
                document.getElementById("userid").value = profile.userId;
                console.log(profile.userId);
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
