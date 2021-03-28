 <!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>Sign Up</title>
    <link href="loginStyle.css" rel="stylesheet" type="text/css" />
  </head>


  <body>
    <main id="main-section">
      <h1 id="login-title">Mentee Portal Sign-Up</h1>

      <form action="insert.php" method="post">
        <p>
            <label for="username">Username:</label>
            <input type="text" name="username" id="username">
        </p>
        <p>
            <label for="password">Password:</label>
            <input type="text" name="password" id="password">
        </p>
        <p>
            <label for="email">Email Address:</label>
            <input type="text" name="email" id="email">
        </p>
        <p>
            <label for="mentorname">Mentor's Name:</label>
            <input type="text" name="mentorname" id="mentorname">
        </p>
        <p>
            <label for="mentoremail">Mentor's Email:</label>
            <input type="text" name="mentoremail" id="mentoremail">
        </p>
        <input type="submit" value="Submit">

    </main>
  </body>

</html>