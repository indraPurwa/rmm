<!DOCTYPE HTML>
<html>
  <head>
    <title>LOGIN</title>
    <link rel="shotchut icon" href="img/favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/login.css" rel="stylesheet">
  </head>
  <body>
    <div class="container">
      <div class="row">
        <div class="col-md-4 col-md-offset-4 login">
          <div class="header">
            <div class="media">
              <img class="pull-left media-object" style="padding-right: 0;margin-bottom: 5px;" src="img\11779865_1088352257849247_1573709096002270238_o.gif">
              <div class="media-body"><h1>Login</h1></div>
            </div>
          </div>
          <hr style="margin: 0 -15px 20px;">
          <form class="form-horizontal" role="form" action="proses_login.php" method="POST">
            <div class="form-group">
              <label for="username" class="col-md-3 col-md-offset-1 control-label">Username</label>
              <div class="col-md-7">
                <input type="text" name="email" class="form-control" id="username" placeholder="Enter username">
              </div>
            </div>
            <div class="form-group">
              <label for="password" class="col-md-3 col-md-offset-1 control-label">Password</label>
              <div class="col-md-7">
                <input type="password" name="password" class="form-control" placeholder="Enter password">
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-offset-4 col-md-8">
                <div class="checkbox">
                  <label><input type="checkbox">Remember Password</label>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-offset-4 col-md-8">
                <input type="submit" class="btn btn-default" value="Sign in">
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </body>
</html?
