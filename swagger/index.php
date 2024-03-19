<?php

if (!isset($_POST['secret']) || $_POST['secret'] !== @SWAGGER_SECRET_KEY) {
    header('Content-Type: application/json');
    http_response_code(403);
    $forbiddenData = array("title" => '403 Forbidden', "description" => 'Access to the requested resource is forbidden.', "code" => 403, "message" => 'Forbidden.');
    echo json_encode($forbiddenData, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    exit;
}
?>

<!-- HTML for static distribution bundle build -->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title><?=@PROJECT_NAME;?> Swagger UI</title>
  <link rel="stylesheet" type="text/css" href="../swagger/swagger-ui.css" />
  <link rel="stylesheet" type="text/css" href="../swagger/index.css" />
  <link rel="icon" type="image/png" href="../swagger/favicon-32x32.png" sizes="32x32" />
  <link rel="icon" type="image/png" href="../swagger/favicon-16x16.png" sizes="16x16" />
</head>

<body>
  <div id="swagger-ui"></div>
  <script src="../swagger/swagger-ui-bundle.js" charset="UTF-8"> </script>
  <script src="../swagger/swagger-ui-standalone-preset.js" charset="UTF-8"> </script>
  <script src="../swagger/swagger-initializer.js" charset="UTF-8"> </script>
</body>

</html>