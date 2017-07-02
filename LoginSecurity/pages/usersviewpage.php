<?php
$jumPage=ceil($jumlahData / $dataperPage);
if($noPage > 1) {
	echo '<li>';              
	echo "<a href='./page.php?page=users&hal=".($noPage-1)."'><span class='glyphicon glyphicon-step-backward'></span></a>";
	echo '</li>';
}
for($page = 1; $page <= $jumPage; $page++) {
	$showPage = 0;
	if ((($page >= $noPage - 3) && ($page <= $noPage + 3)) || ($page == 1) || ($page == $jumPage)) {
		if (($showPage == 1) && ($page != 2)) {
			echo '<li class="disabled">';
			echo "<a href='#'>...</a>";
			echo '</li>';
		}
        if (($showPage != ($jumPage - 1)) && ($page == $jumPage)) {
			echo '<li class="disabled">';
			echo "<a href='#'>...</a>";
			echo '</li>';
		}
		if ($page == $noPage){
			echo '<li class="disabled">';
			echo " <a href='#'><b>".$page."</b></a> ";
			echo '</li>';
		} else {
			echo '<li>';              
			echo "<a href='./page.php?page=users&hal=".$page."'>".$page."</a>";
			echo '</li>';
		}
		$showPage=$page;
	}
}
if ($noPage < $jumPage) {
	echo '<li>';              
	echo "<a href='./page.php?page=users&hal=".($noPage+1)."'><span class='glyphicon glyphicon-step-forward'></span></a>";
	echo '</li>';
}
?>