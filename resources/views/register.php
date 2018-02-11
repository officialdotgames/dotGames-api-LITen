<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">
    <title>Register - Official dotGames</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/signin.css" rel="stylesheet">
  </head>

  <body class="text-center">
    <form class="form-signin" action="/v1/api/register" method="post">
      <img class="mb-4" src="https://getbootstrap.com/assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">
      <h1 class="h3 mb-3 font-weight-normal">Register</h1>

      <label for="email" class="sr-only">Email address</label>
      <input type="email" id="email" name="email" class="form-control form-top" placeholder="Email address" required autofocus>

      <label for="password" class="sr-only">Password</label>
      <input type="password" id="password" name="password" class="form-control form-middle" placeholder="Password" required>

      <label for="password_confirmation" class="sr-only">Confirm Password</label>
      <input type="password" id="password_confirmation" name="password_confirmation" class="form-control form-bottom" placeholder="Confirm Password" required>

      <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
      <a href="/login"><p class="register">Already Registered?</p></a>
      <p class="mt-5 mb-3 text-muted">&copy; Official dotGames 2018</p>
    </form>
  </body>
</html>
