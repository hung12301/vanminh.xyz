<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="csrf-token" content="<?= csrf_token() ?>">
	<title>Document</title>
</head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script
  src="https://code.jquery.com/jquery-3.1.1.slim.min.js"
  integrity="sha256-/SIrNqv8h6QGKDuNoLGA4iret+kyesCkHGzVUUV0shc="
  crossorigin="anonymous"></script>
<style type="text/css">
	blockquote{
    border-left:none
}

.quote-badge{
    background-color: rgba(0, 0, 0, 0.2);   
}

.quote-box{
    
    overflow: hidden;
    margin-top: -50px;
    padding-top: -100px;
    border-radius: 17px;
    background-color: #4ADFCC;
    margin-top: 25px;
    color:white;
    width: 325px;
    box-shadow: 2px 2px 2px 2px #E0E0E0;
    
}

.quotation-mark{
    
    margin-top: -10px;
    font-weight: bold;
    font-size:100px;
    color:white;
    font-family: "Times New Roman", Georgia, Serif;
    
}

.quote-text{
    
    font-size: 19px;
    margin-top: -65px;
}
</style>
<body>
	<div class="container">
    <blockquote class="quote-box">
      <p class="quotation-mark">
        “
      </p>
      <p class="quote-text">
        Có lỗi xảy ra trong quá trình hoạt động post trên blogger của bạn. Hãy click vào link dưới để Refresh Access Token 
      </p>
      <hr>
      <div class="blog-post-actions">
        <p class="blog-post-bottom pull-left" style="text-align: center;width: 100%">
          <a href="https://accounts.google.com/o/oauth2/v2/auth?scope=https://www.googleapis.com/auth/blogger&redirect_uri=http://tool.vanminh.xyz/blogger/get-token&response_type=token&client_id=668196754237-3g2gb7mjvvln2ulji5h80h7rtgomdcgj.apps.googleusercontent.com&approval_prompt=force" class="btn btn-primary" style="margin-bottom: 20px">Refresh Access Token</a>
        </p>
      </div>
    </blockquote>
</div>
</body>
<script type="text/javascript">
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
        alert('Refresh Success');
			
				setTimeout(function () {
					window.location = "http://vanminh.xyz/tool/blogger/run";
				},3000);
				
    };
</script>
</html>