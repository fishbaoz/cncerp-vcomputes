<?php

/* $Id: footer.inc 5784 2012-12-29 04:00:43Z daintree $*/

echo '</div>'; // BodyWrapDiv
echo '</div>'; // BodyDiv
echo '</div>'; // Canvas-cncerp
echo '</div>'; // Canvas

echo '<div id="FooterDiv">';
echo '<div id="FooterWrapDiv">';

echo '<div id="FooterLogoDiv">';
	//echo '<img src="'. $RootPath . '/' . $_SESSION['LogoFile'] . '" width="120" alt="CNCERP" title="CNCERP ' . _('weberp') . ' &copy; cncerp.com - ' . date('Y') . '" />';
          echo '<img src="'. $RootPath . '/' . 'logo.png'. '" width="120" alt="CNCERP" title="CNCERP ' . _('weberp') . ' &copy; cncerp.com - ' . date('Y') . '" />';
echo '</div>';

echo '<div id="FooterVersionDiv">';
	echo 'CNCERP ' ._('版本') .' ' . $_SESSION['VersionNumber'] . '  <a target="_blank" href="http://www.cncerp.com">CNCERP</a>';
echo '</div>';

echo '<div id="FooterTimeDiv">';
	echo DisplayDateTime();
echo '</div>';

echo '</div>'; // FooterWrapDiv
echo '</div>'; // FooterDiv
//echo '</div>'; // Canvas

echo '</body>';
echo '</html>';

?>