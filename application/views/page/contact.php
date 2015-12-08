<div class="container-fluid" style="padding:0;margin-top:-20px">
	<div class="row-fluid">
		<ul class="breadcrumb">
			<li><?php echo anchor('/','Home'); ?> <span class="divider">&#x203a;&#x203a;</span></li>
			<li class="active">Liên hệ <span class="divider">&#x203a;&#x203a;</span></li><?php
			$seg = $this->uri->segment(3);
			if(!empty($seg)):
			?><li class="active"><?php echo html_escape($contact['name']); ?></li><?php
			endif;
			?>
		</ul>
	</div><div class="row-fluid">
		<div class="span12 border_radius show board nonDeco" id="page_contact">
			<div class="white_border border_radius">
				<div class="headline show">
					<span id="polygon_tag" class="kirnberg nonSelect">Jotun Shop</span>
				</div>
				<div class="row-fluid">
					<div class="span12 contact_content">
						<div class="row-fluid">
							<div class="span8">
								<div id="top_letter" class="span12 nonSelect">
									<?php echo nl2br(html_escape($contact['name']));
								?></div>
								<div id="contain_letter" class="span12"><?php echo parseBbcode($contact['content']); ?></div>
								<div id="bottom_letter" class="span12"></div>
							</div><div class="span4 show">
								<div class="letter_box carousel_radius show">
									<span class="letter_box_deco"></span>
									<div class="link_letter_holder carousel_radius show"><?php
										echo anchor('/page/contact/ckt','<p>Bưu điện chuyển khoản trước</p>','class="show"');
									?></div>
								</div>
								<div class="letter_box carousel_radius show">
									<span class="letter_box_deco"></span>
									<div class="link_letter_holder carousel_radius show"><?php
										echo anchor('/page/contact/cks','<p>Bưu điện chuyển khoản sau</p>','class="show"');
									?></div>
								</div>
								<div class="letter_box carousel_radius show">
									<span class="letter_box_deco"></span>
									<div class="link_letter_holder carousel_radius show"><?php
										echo anchor('/page/contact/gnh','<p>Gửi & nhận hàng <br />tại trạm xe</p>','class="show"');
									?></div>
								</div>
							</div>
						</div>
					</div>
				</div><div class="row-fluid">
					<div class="small_ribbon show"></div>
				</div><div class="row-fluid">
					<div class="span12 backlink text-right"><?php
					if(!empty($seg))
						echo anchor('/page/contact','Trở về trang trước');
					?></div>
				</div>
			</div>
		</div>
	</div>
</div>