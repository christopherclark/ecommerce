<nav class="purchases navbar navbar-default">
	<div class="container-fluid">
		<ul class="nav navbar-header">
			<a href="/">
				<p class="navbar-brand">H&H Supplies</p>
			</a>
		</ul>
		<ul class="nav navbar-nav navbar-right">
			<li><a href="/purchases/view_cart">Shopping Cart (<?php
					if(FALSE !== ($this->session->userdata('total_quantity'))) {
						echo $this->session->userdata('total_quantity');
					} else {
						echo "0";
					}
					?>)</a></li>
		</ul>
	</div>
</nav>