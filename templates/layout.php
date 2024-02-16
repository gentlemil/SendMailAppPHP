<html lang="pl">

<head>
  <title>Comarch Recruitment Task</title>
  <meta charset="utf-8">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css">
  <link href="/public/style.css" rel="stylesheet">
</head>

<body class="body">
  <div class="wrapper">
    <header class="header">
      <h1><i class="far fa-clipboard"></i>MAIL SENDER APP</h1>
    </header>

    <div class="container">
      <nav class="menu">
        <ul>
          <li><a href="/">Main Page</a></li>
          <li><a href="/?action=create">New Template</a></li>
          <!-- <li><a href="/?action=createUser">New User</a></li> -->
        </ul>
      </nav>

      <article class="page">
        <?php require_once("templates/pages/$page.php"); ?>
      </article>
    </div>

    <footer class="footer">
      <p>Templates | Comarch | PHP</p>
    </footer>
  </div>
</body>

</html>