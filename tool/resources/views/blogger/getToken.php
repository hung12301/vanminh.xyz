<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="csrf-token" content="<?= csrf_token() ?>">
  <title>Document</title>
  <script
  src="https://code.jquery.com/jquery-3.1.1.slim.min.js"
  integrity="sha256-/SIrNqv8h6QGKDuNoLGA4iret+kyesCkHGzVUUV0shc="
  crossorigin="anonymous"></script>
  <script type="text/javascript">
        function findGetParameter(parameterName) {
            var result = null,
                tmp = [];
            location.search
            .substr(1)
                .split("&")
                .forEach(function (item) {
                tmp = item.split("=");
                if (tmp[0] === parameterName) result = decodeURIComponent(tmp[1]);
            });
            return result;
        }
        // First, parse the query string
        var params = [] , queryString = location.hash.substring(1),
            regex = /([^&=]+)=([^&]*)/g, m;
        while (m = regex.exec(queryString)) {
          params[decodeURIComponent(m[1])] = decodeURIComponent(m[2]);
        }

        // And send the token over to the server
        var req = new XMLHttpRequest();
        // consider using POST so query isn't logged
        var data = new FormData();
        data.append('access_token',params['access_token']);
        data.append('expires_in',params['expires_in']);

        req.open('POST', 'http://tool.vanminh.xyz/blogger/save-token', true);
        req.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
        req.send(data);

        req.onload = function () {
            console.log(this.responseText);
        };

  </script>
</head>
<body>

  <a href="https://accounts.google.com/o/oauth2/v2/auth?scope=https://www.googleapis.com/auth/blogger&redirect_uri=http://tool.vanminh.xyz/blogger/get-token&response_type=token&client_id=668196754237-3g2gb7mjvvln2ulji5h80h7rtgomdcgj.apps.googleusercontent.com&approval_prompt=force">CLICK HERE TO REFRESH TOKEN</a>
</body>
</html>