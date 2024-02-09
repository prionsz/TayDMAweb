<div class="wrapper postbox with-pad">

	<h2 class="box-title">Setup Wizard</h2>

	<div class="inner-wrapper">

		<?php if ( ! get_option('add_purchase_code') ): ?>


		<?php endif; ?>

		<div class="list-item">
			<h4>1-click theme setup</h4>
			<p>By click Setup Now, a new window will appear with the Setup Wizard. Follow the instructions and you're done!</p>
		</div>

		<div class="list-item">
			<h4>Template, Plugins, Photos, everything...</h4>
			<p>Not only template, but all needed plugins, photos and widgets for each demo!</p>
		</div>


		<p>
            <a id="setupBtn" name="Select Template"  class="button-primary codeless-hint-qtip thickbox"><?php esc_html_e( 'Setup Now', 'remake' ); ?></a>
        </p>

	</div>

</div>