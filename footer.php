<?php

$year = date("Y",time());
echo <<<_END
<script
			  src="http://code.jquery.com/jquery-3.3.1.min.js"
			  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
			  crossorigin="anonymous"></script>
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</body>
<div align="center">
<footer class="fixed-bottom">
<br>
============================
<br>
Bottom Menu:
 <br>
 <div>
  <p>Copyright: Lukasz Zagroba 2017 - $year</p>
  <p>Contact information: <a href="mailto:contact@jojobboard.com">
 Contact@jojobboard.com</a>.</p>
 </div>
</footer>
</div>
</html>
_END;

?>
