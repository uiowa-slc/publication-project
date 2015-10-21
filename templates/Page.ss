<!doctype html>
<html lang="$ContentLocale.ATT" dir="$i18nScriptDirection.ATT">
<head>
	<% base_tag %>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="google" value="notranslate" />
	<% if $URLSegment = 'home' %>
		<title>$SiteConfig.Title - The University of Iowa</title>
	<% else %>
		<title>$Title - $SiteConfig.Title - The University of Iowa</title>
	<% end_if %>
	<% include OpenGraph %>

	<script src="https://use.typekit.net/gor3pds.js"></script>
<script>try{Typekit.load({ async: true });}catch(e){}</script>
	<link rel="icon" type="image/png" href="$ThemeDir/favicon.ico" />
	<link href="{$ThemeDir}/css/app.css" rel="stylesheet">

</head>
<body class="$ClassName.ATT">
	

	
	<%-- include UiowaBar --%>

	<% if $ClassName == "HomePage" %>
		<% include HomePageCover %>
	<% else_if $ClassName == "Issue" %>
		<% include IssueCover %>
	<% else %>
		<% include TopBar %>
	<% end_if %>

	<div class="main typography" role="main">
		$Layout
	</div>
	<% include Footer %>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

<script type="text/javascript">
function downloadJSAtOnload() {
var element = document.createElement("script");
element.src = "themes/exchanges/build/build.js";
document.body.appendChild(element);
}
if (window.addEventListener)
window.addEventListener("load", downloadJSAtOnload, false);
else if (window.attachEvent)
window.attachEvent("onload", downloadJSAtOnload);
else window.onload = downloadJSAtOnload;
</script>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-426753-15', 'auto');
  ga('send', 'pageview');

</script>
</body>
</html>
