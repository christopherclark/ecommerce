<nav class="purchases navbar navbar-default">
	<div class="container-fluid">
		<ul class="nav navbar-header">
			<p class="navbar-brand">H&H Supplies</p>
		</ul>
		<ul class="nav navbar-nav navbar-right">
			<li><a href="/purchases/view_cart">Shopping Cart (<?php
					if(FALSE !== ($this->session->userdata('cart_count'))) {
						echo $this->session->userdata('cart_count');
					} else {
						echo "0";
					}
					?>)</a></li>
		</ul>
	</div>
</nav>