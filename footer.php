<?php

$year = date("Y",time());
echo <<<_END
</body>
<div align="center">
<footer>
<br>
============================
<br>
Bottom Menu:
 <br>
  <p>Copyright: Lukasz Zagroba 2017 - $year</p>
  <p>Contact information: <a href="mailto:contact@jojobboard.com">
 Contact@jojobboard.com</a>.</p>
</footer>
</div>
</html>
_END;

?>
