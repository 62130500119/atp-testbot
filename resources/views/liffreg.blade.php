<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Register</title>
        <script src=”https://d.line-scdn.net/liff/1.0/sdk.js"> </script>
        <script src=”lib/jquery-3.3.1.min.js”> </script>
        <script src=”lib/bootstrap.min.js”> </script>
        <link href=”lib/bootstrap.min.css” rel=”stylesheet” />
    </head>
    <body>
        <form action="register" method="get">
            <div class="row">
                <div class="col-md-6" style="margin:5px">
                    <input class="form-control" type="hidden" id="userid" name="userid" /> <br />
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
    </body>
</html>
